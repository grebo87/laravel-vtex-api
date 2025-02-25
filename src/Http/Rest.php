<?php

namespace Grebo87\LaravelVtexApi\Http;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class Rest
{
    private const DEFAULT_ENVIRONMENT = 'vtexcommercestable';
    private const HEADER_ACCEPT = 'application/json';
    private const HEADER_CONTENT_TYPE = 'application/json';
    private const GATEWAY_TIMEOUT_CODE = 504;

    protected string $accountName;
    protected string $appKey;
    protected string $appToken;
    protected string $environment;
    protected string $endpoint;

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function __construct()
    {
        $this->accountName = config('vtex.account_name') ?? throw new \InvalidArgumentException('VTEX account name is not configured');
        $this->appKey = config('vtex.app_key') ?? throw new \InvalidArgumentException('VTEX app key is not configured');
        $this->appToken = config('vtex.app_token') ?? throw new \InvalidArgumentException('VTEX app token is not configured');
        $this->environment = config('vtex.environment') ?? self::DEFAULT_ENVIRONMENT;

        $this->endpoint = sprintf('https://%s.%s.com.br/', $this->accountName, $this->environment);
    }

    public function get(string $uri, array $data = [])
    {
        return $this->request('get', $uri, $data);
    }

    public function put(string $uri, array $data)
    {
        return $this->request('put', $uri, $data);
    }

    public function post(string $uri, array $data)
    {
        return $this->request('post', $uri, $data);
    }

    public function delete(string $uri)
    {
        return $this->request('delete', $uri);
    }

    protected function request(string $method, string $uri, array $data = []): mixed
    {
        $url = $this->endpoint . $uri;

        try {
            $response = $this->makeHttpRequest($method, $url, $data);
            return $this->handleResponse($response);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    protected function makeHttpRequest(string $method, string $url, array $data = []): Response
    {
        $http = Http::withOptions($this->optionsDefault())
                    ->timeout(30)
                    ->retry(3, 100);

        return empty($data)
            ? $http->$method($url)
            : $http->$method($url, $data);
    }

    protected function handleResponse(Response $response): mixed
    {
        try {
            if ($response->failed()) {
                Log::error('VTEX API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                if ($response->status() === self::GATEWAY_TIMEOUT_CODE) {
                    return $this->response('GATEWAY_TIMEOUT', self::GATEWAY_TIMEOUT_CODE);
                }

                return $this->response('VTEX API Error: ' . $response->body(), $response->status());
            }

            $data = $response->json();
            return empty($data) ? $response->body() : $data;
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    private function optionsDefault(): array
    {
        return [
            'headers' => [
                'Accept' => self::HEADER_ACCEPT,
                'Content-Type' => self::HEADER_CONTENT_TYPE,
                'X-VTEX-API-AppKey' => $this->appKey,
                'X-VTEX-API-AppToken' => $this->appToken,
            ],
            'verify' => true,
        ];
    }

    private function handleException(\Throwable $e): array
    {
        $code = $e->getCode() ?: 500;
        $message = $e->getMessage();

        Log::error('VTEX API error', [
            'code' => $code,
            'message' => $message,
            'trace' => $e->getTraceAsString()
        ]);

        if ($code === self::GATEWAY_TIMEOUT_CODE) {
            return $this->response('GATEWAY_TIMEOUT', self::GATEWAY_TIMEOUT_CODE);
        }

        return $this->response(
            sprintf('VTEX API Error: %s', $message),
            $code
        );
    }

    private function response(string $message, int $code): array
    {
        return [
            'success' => $this->isSuccessStatusCode($code),
            'message' => $message,
            'code' => $code
        ];
    }

    private function isSuccessStatusCode(int $code): bool
    {
        return $code >= 200 && $code <= 299;
    }
}

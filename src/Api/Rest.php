<?php

namespace Grebo87\LaravelVtexApi\Api;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Exceptions\HttpResponseException;

class Rest
{
    protected $accountName;
    protected $appKey;
    protected $appToken;
    private $environment = "vtexcommercestable";
    private $headerAccept = "application/json";
    private $headerContentType = "application/json";
    private $endpoint;

    public function __construct()
    {
        $this->accountName = config('vtex.account_name');
        $this->appKey = config('vtex.app_key');
        $this->appToken = config('vtex.app_token');
        $this->environment = config('vtex.environment');

        $this->endpoint = "https://{$this->accountName}.{$this->environment}.com.br/";
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

    private function request(string $method, string $uri, array $data = [])
    {
        $url = "{$this->endpoint}{$uri}";

        try {
            
            $http = Http::withOptions($this->optionsDefault());

            if (!empty($data)) {
                $response = $http->$method($url, $data);
            } else {
                $response = $http->$method($url);
            }

            if ($response->failed()) {
                return $response->throw();
            }

            $response_data = $response->json();

            if (!empty($response_data)) {
                return $response_data;
            }

            return $response->body();
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    final private function optionsDefault(): array
    {
        return [
            'headers' => [
                'Accept' => $this->headerAccept,
                'Content-Type' => $this->headerContentType,
                'X-VTEX-API-AppKey' => $this->appKey,
                'X-VTEX-API-AppToken' => $this->appToken,
            ],
        ];
    }

    final private function handleException(\Throwable $e)
    {
        $code = $e->getCode();

        if ($code == 504) {
            return $this->response("GATEWAY_TIMEOUT", 504);
        }

        return $this->response("Response Vtex Api : {$e->getMessage()}", $code);
    }

    final private function response(string $message, int $code)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => $this->isSuccessStatusCode($code),
                'message' => $message,
                'code' => $code
            ], $code)
        );
    }

    final private function isSuccessStatusCode(int $code): bool
    {
        return $code >= 200 && $code <= 299;
    }
}

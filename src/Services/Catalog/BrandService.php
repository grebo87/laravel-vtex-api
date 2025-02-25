<?php

namespace Grebo87\LaravelVtexApi\Services\Catalog;

use Grebo87\LaravelVtexApi\Http\Rest;

use Grebo87\LaravelVtexApi\Data\Catalog\Brands\BrandListData;
use Grebo87\LaravelVtexApi\Data\Catalog\Brands\BrandCreateData;
use Grebo87\LaravelVtexApi\Data\Catalog\Brands\BrandPaginatedListData;
use Grebo87\LaravelVtexApi\Data\Catalog\Brands\BrandPagingData;
use Illuminate\Support\Collection;

class BrandService extends Rest
{
    private const ENDPOINTS = [
        'list' => 'api/catalog_system/pvt/brand/list',
        'paged_list' => 'api/catalog_system/pvt/brand/pagedlist',
        'brand' => 'api/catalog_system/pvt/brand/%d',
        'brand_and_context' => 'api/catalog_system/pvt/brand/%d/context',
        'create' => 'api/catalog/pvt/brand',
        'update' => 'api/catalog/pvt/brand/%d',
        'delete' => 'api/catalog/pvt/brand/%d',
    ];

    /**
     * Get the list of brands.
     *
     * @return Collection List of brands.
     * @throws \Throwable If the API request fails.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#get-/api/catalog_system/pvt/brand/list
     */
    public function getBrandList(): Collection
    {
        $response = $this->get(self::ENDPOINTS['list']);
        return collect($response)->map(function ($brand) {
            return new BrandListData(
                id: $brand['id'],
                name: $brand['name'],
                isActive: $brand['isActive'],
                metaTagDescription: $brand['metaTagDescription'] ?? null,
                imageUrl: $brand['imageUrl'] ?? null,
                title: $brand['title'] ?? null
            );
        });
    }

    /**
     * Get a paginated list of brands.
     *
     * @param int $pageSize Number of items per page (1-100).
     * @param int $page Page number (>= 1).
     * @return array Paginated list of brands.
     * @throws \Throwable If the API request fails.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#get-/api/catalog_system/pvt/brand/pagedlist
     */
    public function getBrandListPerPage(int $pageSize = 50, int $page = 1): BrandPaginatedListData
    {
        $response = $this->get(self::ENDPOINTS['paged_list'], [
            'page' => $page,
            'pageSize' => $pageSize
        ]);

        $items = collect($response['items'])->map(function ($brand) {
            return new BrandListData(
                id: $brand['id'],
                name: $brand['name'],
                isActive: $brand['isActive'],
                metaTagDescription: $brand['metaTagDescription'] ?? null,
                imageUrl: $brand['imageUrl'] ?? null,
                title: $brand['title'] ?? null
            );
        })->all();

        $paging = new BrandPagingData(
            page: $response['paging']['page'],
            perPage: $response['paging']['perPage'],
            total: $response['paging']['total'],
            pages: $response['paging']['pages']
        );

        return new BrandPaginatedListData(
            items: $items,
            paging: $paging
        );
    }

    /**
     * Get details of a specific brand.
     *
     * @param int $brandId Brand ID.
     * @return array Details of the brand.
     * @throws \Throwable If the API request fails.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#get-/api/catalog_system/pvt/brand/-brandId-
     */
    public function getBrand(int $brandId): BrandListData
    {
        $endpoint = sprintf(self::ENDPOINTS['brand'], $brandId);
        $response = $this->get($endpoint);
        return new BrandListData(
            id: $response['id'],
            name: $response['name'],
            isActive: $response['isActive'],
            metaTagDescription: $response['metaTagDescription'] ?? null,
            imageUrl: $response['imageUrl'] ?? null,
            title: $response['title'] ?? null
        );
    }

    /**
     * Get a brand and its context information.
     *
     * @param int $brandId Brand ID.
     * @return array Brand and context information.
     * @throws \Throwable If the API request fails.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#get-/api/catalog_system/pvt/brand/-brandId-/context
     */
    public function getBrandAndContext(int $brandId): array
    {
        $endpoint = sprintf(self::ENDPOINTS['brand_and_context'], $brandId);
        return $this->get($endpoint);
    }

    /**
     * Create a new brand.
     *
     * @param array $data Brand details.
     * @return array The created brand.
     * @throws \Throwable If the API request fails.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#post-/api/catalog/pvt/brand
     */
    public function createBrand(array $data): BrandCreateData
    {
        $response = $this->post(self::ENDPOINTS['create'], $data);
        return new BrandCreateData(
            id: $response['Id'],
            name: $response['Name'],
            text: $response['Text'] ?? null,
            keywords: $response['Keywords'] ?? null,
            siteTitle: $response['SiteTitle'] ?? null,
            active: $response['Active'] ?? true,
            menuHome: $response['MenuHome'] ?? false,
            adWordsRemarketingCode: $response['AdWordsRemarketingCode'] ?? null,
            lomadeeCampaignCode: $response['LomadeeCampaignCode'] ?? null,
            score: $response['Score'] ?? null,
            linkId: $response['LinkId'] ?? null
        );
    }

    /**
     * Update details of a brand.
     *
     * @param int $brandId Brand ID.
     * @param array $data Updated brand details.
     * @return array The updated brand.
     * @throws \Throwable If the API request fails.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#put-/api/catalog/pvt/brand/-brandId-
     */
    public function updateBrand(int $brandId, array $data): BrandCreateData
    {
        $endpoint = sprintf(self::ENDPOINTS['update'], $brandId);
        $response = $this->put($endpoint, $data);
        return new BrandCreateData(
            id: $response['Id'],
            name: $response['Name'],
            text: $response['Text'] ?? null,
            keywords: $response['Keywords'] ?? null,
            siteTitle: $response['SiteTitle'] ?? null,
            active: $response['Active'] ?? true,
            menuHome: $response['MenuHome'] ?? false,
            adWordsRemarketingCode: $response['AdWordsRemarketingCode'] ?? null,
            lomadeeCampaignCode: $response['LomadeeCampaignCode'] ?? null,
            score: $response['Score'] ?? null,
            linkId: $response['LinkId'] ?? null
        );
    }

    /**
     * Delete a brand.
     *
     * @param int $brandId Brand ID to delete.
     * @return void
     * @throws \Throwable If the API request fails.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#delete-/api/catalog/pvt/brand/-brandId-
     */
    public function deleteBrand(int $brandId): void
    {
        $endpoint = sprintf(self::ENDPOINTS['delete'], $brandId);
        $this->delete($endpoint);
    }
}

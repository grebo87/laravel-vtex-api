<?php

namespace Grebo87\LaravelVtexApi\Services\Catalog;

use Grebo87\LaravelVtexApi\Http\Rest;
use Grebo87\LaravelVtexApi\Data\Catalog\Categories\CategorySpecificationData;
use Illuminate\Support\Collection;

class CategorySpecificationService extends Rest
{
    private const ENDPOINTS = [
        'specifications' => 'api/catalog_system/pvt/specification/field/listByCategoryId/%d',
        'specifications_tree' => 'api/catalog_system/pvt/specification/field/listTreeByCategoryId/%d'
    ];

    /**
     * Get specifications by category ID.
     *
     * @param int $categoryId Category ID.
     * @return Collection List of specifications.
     * @throws \Throwable If the API request fails.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#get-/api/catalog_system/pub/specification/field/listByCategoryId/-categoryId-
     */
    public function getSpecifications(int $categoryId): Collection
    {
        $endpoint = sprintf(self::ENDPOINTS['specifications'], $categoryId);
        $response = $this->get($endpoint);

        return collect($response)->map(function ($specification) {
            return new CategorySpecificationData(...$specification);
        });
    }

    /**
     * Get specifications tree by category ID.
     *
     * @param int $categoryId Category ID.
     * @return Collection List of specifications in tree format.
     * @throws \Throwable If the API request fails.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#get-/api/catalog_system/pub/specification/field/listTreeByCategoryId/-categoryId-
     */
    public function getSpecificationsTree(int $categoryId): Collection
    {
        $endpoint = sprintf(self::ENDPOINTS['specifications_tree'], $categoryId);
        $response = $this->get($endpoint);

        return collect($response)->map(function ($specification) {
            return new CategorySpecificationData(...$specification);
        });
    }
}

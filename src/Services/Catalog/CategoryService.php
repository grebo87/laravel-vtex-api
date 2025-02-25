<?php

namespace Grebo87\LaravelVtexApi\Services\Catalog;

use Grebo87\LaravelVtexApi\Http\Rest;
use Grebo87\LaravelVtexApi\Data\Catalog\Categories\CategoryData;
use Grebo87\LaravelVtexApi\Data\Catalog\Categories\CategoryTreeData;
use Illuminate\Support\Collection;

class CategoryService extends Rest
{
    private const ENDPOINTS = [
        'tree' => 'api/catalog_system/pub/category/tree/%d',
        'category' => 'api/catalog_system/pvt/category/%d',
        'create' => 'api/catalog/pvt/category',
        'update' => 'api/catalog/pvt/category/%d'
    ];

    /**
     * Get the category tree.
     *
     * @param int $categoryLevels Number of category levels to retrieve (default: 3)
     * @return Collection List of categories in tree format.
     * @throws \Throwable If the API request fails.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#get-/api/catalog_system/pub/category/tree/-categoryLevels-
     */
    public function getCategoryTree(int $categoryLevels = 3): Collection
    {
        $endpoint = sprintf(self::ENDPOINTS['tree'], $categoryLevels);
        $response = $this->get($endpoint);

        return collect($response)->map(function ($category) {
            return $this->mapCategoryTree($category);
        });
    }

    /**
     * Get details of a specific category.
     *
     * @param int $categoryId Category ID.
     * @return CategoryData Details of the category.
     * @throws \Throwable If the API request fails.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#get-/api/catalog_system/pvt/category/-categoryId-
     */
    public function getCategory(int $categoryId): CategoryData
    {
        $endpoint = sprintf(self::ENDPOINTS['category'], $categoryId);
        $response = $this->get($endpoint);
        return new CategoryData(...$response);
    }

    /**
     * Create a new category.
     *
     * @param CategoryData $data Category data.
     * @return CategoryData Created category.
     * @throws \Throwable If the API request fails.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#post-/api/catalog/pvt/category
     */
    public function createCategory(CategoryData $data): CategoryData
    {
        $response = $this->post(self::ENDPOINTS['create'], (array) $data);

        return new CategoryData(...$response);
    }

    /**
     * Update an existing category.
     *
     * @param int $categoryId Category ID.
     * @param CategoryData $data Updated category data.
     * @return CategoryData Updated category.
     * @throws \Throwable If the API request fails.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#put-/api/catalog/pvt/category/-categoryId-
     */
    public function updateCategory(int $categoryId, CategoryData $data): CategoryData
    {
        $endpoint = sprintf(self::ENDPOINTS['update'], $categoryId);
        $response = $this->put($endpoint, (array) $data);
        return new CategoryData(...$response);
    }

    /**
     * Recursively map category tree data from API response to CategoryTreeData objects.
     *
     * @param array $category Raw category data from API response
     * @return CategoryTreeData Mapped category tree data
     */
    private function mapCategoryTree(array $category): CategoryTreeData
    {
        $children = collect($category['children'] ?? [])->map(function ($child) {
            return $this->mapCategoryTree($child);
        })->all();

        return new CategoryTreeData(
            id: $category['id'],
            name: $category['name'],
            hasChildren: $category['hasChildren'],
            url: $category['url'],
            children: $children,
            Title: $category['Title'] ?? null,
            MetaTagDescription: $category['MetaTagDescription'] ?? null
        );
    }
}

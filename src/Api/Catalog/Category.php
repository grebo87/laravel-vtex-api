<?php

namespace Grebo87\LaravelVtexApi\Api\Catalog;

use Illuminate\Support\Facades\Validator;
use Grebo87\LaravelVtexApi\Api\Rest;
use Grebo87\LaravelVtexApi\Exceptions\CustomValidationException;

class Category extends Rest
{
    /**
     * Get a listing of the category tree in Vtex.
     *
     * @param  int $categoryLevels Level of the category tree to be displayed, defaults to 3.
     * @return array Category tree.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api/#get-/api/catalog_system/pub/category/tree/-categoryLevels-
     */
    public function getCategoryTree(int $categoryLevels = 3): array
    {
        return $this->get("api/catalog_system/pub/category/tree/{$categoryLevels}");
    }

    /**
     * Get a category based on its Id in Vtex.
     *
     * @param  int $categoryId Category identifier.
     * @return object Found category.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api/#get-/api/catalog/pvt/category/-categoryId-
     */
    public function getCategoryById(int $categoryId): object
    {
        return $this->get("api/catalog/pvt/category/{$categoryId}");
    }

    /**
     * Update a category in Vtex.
     *
     * @param int $categoryId Category id.
     * @param array $category Category attributes.
     * @return object Registered or updated category.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api/#put-/api/catalog/pvt/category/-categoryId-
     */
    public function updateCategory(int $categoryId, array $category): object
    {
        $this->validateCategoryData($category);

        return $this->put("api/catalog/pvt/category/{$categoryId}", $category);
    }

    /**
     * Create a new category in Vtex if it does not exist.
     *
     * @param  array $category Category attributes.
     * @return object Registered or updated category.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#post-/api/catalog/pvt/category
     */
    public function createCategory(array $category): object
    {
        $this->validateCategoryData($category);

        return $this->post("api/catalog/pvt/category", $category);
    }

    /**
     * Validate the data for a category.
     *
     * @param array $category Category attributes to be validated.
     * @return bool|object Returns false if validation passes, otherwise throws a CustomValidationException.
     */
    private function validateCategoryData(array $category): bool|object
    {
        $validator = Validator::make($category, [
            'Id' => 'nullable|integer',
            'Name' => 'required|string|max:100',
            'Keywords' => 'required|string',
            'Title' => 'required|string|max:150',
            'Description' => 'required|string',
            'AdWordsRemarketingCode' => 'nullable|string|max:200',
            'LomadeeCampaignCode' => 'nullable|string|max:200',
            'FatherCategoryId' => 'nullable|integer',
            'GlobalCategoryId' => 'required|integer',
            'ShowInStoreFront' => 'required|boolean',
            'IsActive' => 'required|boolean',
            'ActiveStoreFrontLink' => 'required|boolean',
            'ShowBrandFilter' => 'required|boolean',
            'Score' => 'nullable|integer',
            'StockKeepingUnitSelectionMode' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new CustomValidationException($validator);
        }

        return false;
    }
}

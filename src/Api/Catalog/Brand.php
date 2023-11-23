<?php

namespace Grebo87\LaravelVtexApi\Api\Catalog;

use Illuminate\Support\Facades\Validator;
use Grebo87\LaravelVtexApi\Api\Rest;
use Grebo87\LaravelVtexApi\Exceptions\CustomValidationException;

class Brand extends Rest
{
    /**
     * Get the list of brands.
     *
     * @return array List of brands.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#get-/api/catalog_system/pvt/brand/list
     */
    public function getBrandList(): array
    {
        return $this->get("api/catalog_system/pvt/brand/list");
    }

    /**
     * Get a paginated list of brands.
     *
     * @param int $pageSize Number of items per page.
     * @param int $page     Page number.
     * @return object Paginated list of brands.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#get-/api/catalog_system/pvt/brand/pagedlist
     */
    public function getBrandListPerPage(int $pageSize = 5, int $page = 1): object
    {
        return $this->get("api/catalog_system/pvt/brand/pagedlist", ['pageSize' => $pageSize, 'page' => $page]);
    }

    /**
     * Get details of a specific brand.
     *
     * @param int $brandId Brand ID.
     * @return object Details of the brand.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#get-/api/catalog_system/pvt/brand/-brandId-
     */
    public function getBrand(int $brandId): object
    {
        return $this->get("api/catalog_system/pvt/brand/{$brandId}");
    }

    /**
     * Create a new brand.
     *
     * @param array $brand Brand details.
     * @return object  new brand
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#post-/api/catalog/pvt/brand
     */
    public function createBrand(array $brand) : object
    {
        $this->validateBrandData($brand);
        return $this->post("api/catalog/pvt/brand", $brand);
    }

    /**
     * Get details of a brand and its context.
     *
     * @param int $brandId Brand ID.
     * @return object Brand details with context.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#get-/api/catalog/pvt/brand/-brandId-
     */
    public function getBrandAndContext(int $brandId): object
    {
        return $this->get("api/catalog/pvt/brand/{$brandId}");
    }

    /**
     * Update details of a brand.
     *
     * @param int   $brandId Brand ID.
     * @param array $brand   Updated brand details.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#put-/api/catalog/pvt/brand/-brandId-
     */
    public function updateBrand(int $brandId, array $brand)
    {
        $this->validateBrandData($brand);
        return $this->put("api/catalog/pvt/brand/{$brandId}", $brand);
    }

    /**
     * Delete a brand.
     *
     * @param int $brandId Brand ID to delete.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#delete-/api/catalog/pvt/brand/-brandId-
     */
    public function deleteBrand(int $brandId)
    {
        return $this->delete("api/catalog/pvt/brand/{$brandId}");
    }

    /**
     * Validate data for brand.
     *
     * @param array $brand Brand details to validate.
     * @return bool|object Returns false if validation passes, otherwise throws CustomValidationException.
     */
    private function validateBrandData(array $brand): bool|object
    {
        $validator = Validator::make($brand, [
            "Id" => 'required|integer',
            "Name" => "required|string",
            "Text" => "nullable|string",
            "Keywords" => "nullable|string",
            "SiteTitle" => "nullable|string",
            "Active" => 'boolean',
            "MenuHome" => "nullable|boolean",
            "AdWordsRemarketingCode" => "nullable|string",
            "LomadeeCampaignCode" => "nullable|string",
            "Score" => "nullable|integer",
            "LinkId" => "nullable|string",
        ]);

        if ($validator->fails()) {
            throw new CustomValidationException($validator);
        }

        return false;
    }
}

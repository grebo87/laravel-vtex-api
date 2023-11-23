<?php

namespace Grebo87\LaravelVtexApi\Api\Catalog;

use Grebo87\LaravelVtexApi\Api\Rest;

/**
 * Class CategorySpecification
 *
 * Provides methods to retrieve category specifications from the Vtex Catalog API.
 */
class CategorySpecification extends Rest
{
    /**
     * Get specifications by category ID.
     *
     * @param  int $categoryId Category ID
     * @return array|string   Array of specifications or an error message
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#get-/api/catalog_system/pub/specification/field/listByCategoryId/-categoryId-
     */
    public function getSpecificationsByCategoryId(int $categoryId): array|string
    {
        return $this->get("api/catalog_system/pub/specification/field/listByCategoryId/{$categoryId}");
    }

    /**
     * Get specifications tree by category ID.
     *
     * @param  int $categoryId Category ID
     * @return array|string   Array of specifications tree or an error message
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#get-/api/catalog_system/pub/specification/field/listTreeByCategoryId/-categoryId-
     */
    public function getSpecificationsTreeByCategoryId(int $categoryId): array|string
    {
        return $this->get("api/catalog_system/pub/specification/field/listTreeByCategoryId/{$categoryId}");
    }
}


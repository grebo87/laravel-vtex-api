<?php

namespace Grebo87\LaravelVtexApi\Api\Catalog;

use Illuminate\Support\Facades\Validator;
use Grebo87\LaravelVtexApi\Api\Rest;
use Grebo87\LaravelVtexApi\Exceptions\CustomValidationException;

class SpecificationGroup extends Rest
{
    private array $rulesCreate = [
        'CategoryId' => 'required|integer',
        'Name' => 'required|string|max:100'
    ];

    private array $rulesUpdate = [
        'CategoryId' => 'required|integer',
        'Name' => 'required|string|max:100',
        'Id' => 'required|integer',
        'Position' => 'required|integer'
    ];

    /**
     * Get the list of Specification Group By Category.
     *
     * @param int $categoryId
     * @return array  List of Specification Group.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#get-/api/catalog_system/pvt/specification/groupbycategory/-categoryId-
     */
    public function listSpecificationGroupByCategory(int $categoryId): array
    {
        return $this->get("api/catalog_system/pvt/specification/groupbycategory/{$categoryId}");
    }

    /**
     * Get the Specification Group.
     *
     * @param int $groupId
     * @return array The Specification Group.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#get-/api/catalog_system/pub/specification/groupGet/-groupId-
     */
    public function getSpecificationGroup(int $groupId): array
    {
        return $this->get("api/catalog_system/pub/specification/groupGet/{$groupId}");
    }

    /**
     * Create the Specification Group.
     *
     * @param array $specificationGroup
     * @return object New Specification Group.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#post-/api/catalog/pvt/specificationgroup
     */
    public function createSpecificationGroup(array $specificationGroup): object
    {
        $this->validateSpecificationGroupData($specificationGroup);
        return $this->post("api/catalog/pvt/specificationgroup", $specificationGroup);
    }

    /**
     * Update the Specification Group.
     *
     * @param int $groupId
     * @param array $specificationGroup
     * @return object Updated Specification Group.
     * @link https://developers.vtex.com/docs/api-reference/catalog-api#put-/api/catalog/pvt/specificationgroup/-groupId-
     */
    public function updateSpecificationGroup(int $groupId, array $specificationGroup): object
    {
        $this->validateSpecificationGroupData($specificationGroup, false);
        return $this->put("api/catalog/pvt/specificationgroup/{$groupId}", $specificationGroup);
    }

    /**
     * Validate the data for new or updated Specification Group.
     *
     * @param array $specificationGroup Specification Group attributes to be validated.
     * @param bool $createFlag Flag to determine whether it's for creating or updating.
     * @return bool|object Returns false if validation passes, otherwise throws a CustomValidationException.
     */
    private function validateSpecificationGroupData(array $specificationGroup, bool $createFlag = true): bool|object
    {
        $validator = Validator::make(
            $specificationGroup,
            $createFlag ? $this->rulesCreate
                : $this->rulesUpdate
        );

        if ($validator->fails()) {
            throw new CustomValidationException($validator);
        }

        return false;
    }
}

<?php

namespace Grebo87\LaravelVtexApi\Facades;

use Grebo87\LaravelVtexApi\Services\Catalog\CategorySpecificationService;
use Illuminate\Support\Facades\Facade;

class CategorySpecification extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return CategorySpecificationService::class;
    }
}

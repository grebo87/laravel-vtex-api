<?php

namespace Grebo87\LaravelVtexApi\Facades;

use Grebo87\LaravelVtexApi\Services\Catalog\BrandService;
use Illuminate\Support\Facades\Facade;

class Brand extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return BrandService::class;
    }
}

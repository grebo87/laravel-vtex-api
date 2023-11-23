<?php

namespace Grebo87\LaravelVtexApi\Facades;

use Illuminate\Support\Str;
use \Illuminate\Support\Facades\Facade;

class Brand extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'vtex-' . Str::snake('Brand', '-');
    }
}

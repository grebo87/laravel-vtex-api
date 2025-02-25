<?php

namespace Grebo87\LaravelVtexApi\Providers;

use Grebo87\LaravelVtexApi\Services\Catalog\BrandService;
use Illuminate\Support\ServiceProvider;

class LaravelVtexApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register config
        $this->mergeConfigFrom(__DIR__ . '/../../config/vtex.php', 'vtex');

        // Register services
        $this->app->singleton(BrandService::class, function ($app) {
            return new BrandService(
                config('vtex.base_url'),
                config('vtex.app_key'),
                config('vtex.app_token')
            );
        });
    }

    public function boot(): void
    {
        // Publish config
        $this->publishes([
            __DIR__ . '/../../config/vtex.php' => config_path('vtex.php'),
        ], 'vtex-config');
    }
}

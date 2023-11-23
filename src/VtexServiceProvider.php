<?php

namespace Grebo87\LaravelVtexApi;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class VtexServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerVtexClasses();

        $this->mergeConfigFrom(__DIR__ . '/../config/vtex.php', 'vtex');
    }
 
    /**
      * Bootstrap services.
      *
      * @return void
    */
     public function boot()
     {
         $this->publishes([
             __DIR__ . '/config/vtex.php' => config_path('vtex.php'),
         ]);
 
     }

    protected function registerVtexClasses() : void {
        $filesystem = new Filesystem();
        $classes = $filesystem->files(__DIR__ . '/Api/Catalog');

        foreach ($classes as $class) {
            $class = 'Grebo87\LaravelVtexApi\Api\Catalog\\' . pathinfo($class)['filename'];
            $name = 'vtex-' . Str::snake( class_basename($class), '-');
        
            $this->app->singleton($name, function () use ($class) {
                return new $class();
            });
        }
    }
}

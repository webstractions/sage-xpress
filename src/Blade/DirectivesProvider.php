<?php

namespace SageDevTools\Blade;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Roots\Sage\Container;

class DirectivesProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/blade-directives.php' => config_path('blade-directives.php'),
            ], 'config');
        }

        $this->registerDirectives();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->registerDirectives($this->app);
        $this->mergeConfigFrom(__DIR__.'/../../config/blade-directives.php', 'blade-directives');
    }

    /**
     * Register all directives.
     *
     * @return void
     */
    public function registerDirectives($app)
    {
        $directives = require __DIR__.'/directives.php';

        $sageBlade = $app->get('sage.blade');

        // $directives = array_merge(
        //     $directives,
        //     Config::get('blade-directives.directives')
        // );

        DirectivesRepository::register($directives, $sageBlade);
    }
}

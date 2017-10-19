<?php

namespace SageXpress\Blade;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Roots\Sage\Container;

class DirectivesProvider extends ServiceProvider
{
    protected $configpath;

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->configpath = $this->app['config']['theme.dir'] . '/config/blade-directives.php';

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/blade-directives.php' => $this->configpath,
            ], 'config');
        }

        $this->register();
    }

    /**
     * Register all directives.
     *
     * @return void
     */
    public function register()
    {
        $this->configpath = $this->app['config']['theme.dir'] . '/config/blade-directives.php';
        $defaults = require __DIR__.'/blade-directives.php';
        $directives = array_merge( $defaults, require $this->configpath);
        $blade = $this->app->get('sage.blade');

        // $directives = array_merge(
        //     $directives,
        //     Config::get('blade-directives.directives')
        // );

        DirectivesRepository::register($directives, $blade);
    }
}

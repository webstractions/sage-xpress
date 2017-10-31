<?php

namespace SageXpress\Blade;

use Roots\Sage\Container;
use SageXpress\Providers\AbstractProvider;
use SageXpress\Providers\Traits\ConfigTrait;

class DirectivesProvider extends AbstractProvider
{
    protected $name = 'blade-directives';

    use ConfigTrait;

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register all directives.
     *
     * @return void
     */
    public function register()
    {
        $defaults = require __DIR__.'/blade-directives.php';
        $directives = array_merge( $defaults, $this->config);
        $blade = $this->app->get('sage.blade');

        DirectivesRepository::register($directives, $blade);
    }
}

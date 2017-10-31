<?php

namespace SageXpress\Providers;

use SageXpress\Config\ConfigRepository;

abstract class AbstractProvider
{
    protected $app;

    protected $name='';

    /**
     * Constructor
     *
     * Stores an instance of the Container and
     * registers possible config and render traits.
     *
     * @param $app The Sage Container
     */
    function __construct($app)
    {
        $this->app = $app;

        $this->registerConfig();
    }

    /**
     * Gets fired during instantiation of the provider.
     * Use this method for adding actions, filters, registrations
     * or anything else that needs to be setup prior to use.
     *
     * @return void
     */
    public function boot(){}

    /**
     * Register a provider.
     *
     * @return void
     */
    public function register(){}

    /**
     * Register possible ConfigTrait.
     *
     * @return void
     */
    public function registerConfig(){}

    /**
     * Render a provider's view component.
     *
     * @return void
     */
    public function render(){}
}

<?php

namespace SageXpress\Providers;

abstract class AbstractProvider
{
    protected $app;

    protected static $name='';

    /**
     * Constructor
     *
     * Automatically calls the boot() method.
     *
     * @param $app The Sage Container
     */
    function __construct($app)
    {
        $this->app = $app;

        $this->boot();
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
    public static function register(){}

    /**
     * Render a provider's view component.
     *
     * @return void
     */
    public function render(){}

    /**
     * Get configuration for this provider.
     *
     * @param $item The name of the config file item.
     * @return void
     */
    protected function getConfig($item)
    {
        return $this->app['config']->get( $item );
    }
}

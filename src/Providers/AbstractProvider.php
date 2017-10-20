<?php

namespace SageXpress\Providers;

use SageXpress\Config\ConfigRepository;

abstract class AbstractProvider
{
    protected $app;

    protected $name='';

    protected $config = [];

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

        $this->registerConfig();

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
     * Register a config path.
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

    /**
     * Get configuration for this provider.
     *
     * @param $key The name of the config file item.
     * @return void
     */
    protected function getConfig($key)
    {
        return $this->config = $this->app['config']->get( $key );
    }

    /**
     * Set configuration item for this provider.
     *
     * @param $key The name of the config file item.
     * @return void
     */
    protected function setConfig($key)
    {
        if( ! $this->app['config']->get($key) ) {
            $rootPath = $this->app['config']->get('theme.dir');
            $value = require $rootPath . "/config/$key.php";
            $this->app['config']->set($key,$value);
        }

        return $this->getConfig($key);
    }
}

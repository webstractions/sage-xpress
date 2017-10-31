<?php

namespace SageXpress\Providers\Traits;

use SageXpress\Config\ConfigRepository;

trait ConfigTrait
{
    /**
     * Configuration
     *
     * @var array
     */
    protected $config = [];

    /**
     * Register a config path.
     *
     * @return void
     */
    public function registerConfig()
    {
        $this->config = $this->setConfig( $this->name );
    }

    /**
     * Get configuration for this provider.
     *
     * @param string $key Config key in dot-notation.
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
        // dd($this->app->sage);
        if( ! $this->app->config->get($key) ) {
            $rootPath = $this->app['config']->get('theme.dir');
            $value = require $rootPath . "/config/$key.php";
            $this->app['config']->set($key,$value);
        }

        return $this->getConfig($key);
    }

}

<?php
namespace SageXpress\Providers;

class MenuProvider extends AbstractProvider
{
    protected $name = 'menu';

    /**
     * Gets fired during instantiation of the provider.
     * Use this method for adding actions, filters, registrations
     * or anything else that needs to be setup prior to use.
     *
     * @return void
     */
    public function boot() {

        register_nav_menus($this->config['register']);
    }

    /**
     * Register a config path.
     *
     * @return void
     */
    public function registerConfig() {

        $this->config = $this->setConfig( $this->name );
    }

    /**
     * Render a registered menu class.
     *
     * @param string $name
     * @return wp_nav_menu|false
     */
    public function render($name = null)
    {
        $registry = array_keys( $this->config['register'] );
        $default = $this->config['default'];

        if (in_array($name, $registry)) {
            return wp_nav_menu( $this->config["$name"] + $default );
        }

        return false;
    }
}

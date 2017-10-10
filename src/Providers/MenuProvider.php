<?php
namespace SageXpress\Providers;

class MenuProvider extends AbstractProvider
{
    protected static $name = 'menu';

    /**
     * Gets fired during instantiation of the provider.
     * Use this method for adding actions, filters, registrations
     * or anything else that needs to be setup prior to use.
     *
     * @return void
     */
    public function boot() {
        register_nav_menus($this->getConfig('menu.register'));
    }

    /**
     * Render a registered menu class.
     *
     * @param string $name
     * @return wp_nav_menu|false
     */
    public function render($name = null)
    {
        $registry = array_keys($this->getConfig('menu.register'));
        $default = $this->getConfig("menu.default");

        if (in_array($name, $registry)) {
            return wp_nav_menu( $this->getConfig("menu.$name") + $default );
        }

        return false;
    }
}

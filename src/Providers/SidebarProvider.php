<?php
namespace SageXpress\Providers;

class SidebarProvider extends AbstractProvider
{
    protected $name = 'sidebar';

    /**
     * Gets fired during instantiation of the provider.
     * Use this method for adding actions, filters, registrations
     * or anything else that needs to be setup prior to use.
     *
     * @return void
     */
    public function boot() {

        \add_action('widgets_init', function () {
            foreach( $this->getConfig('sidebar.register') as $sidebar ) {
                \register_sidebar(
                    $this->getConfig("sidebar.$sidebar") + $this->getConfig('sidebar.default')
                );
            }
        });
    }

    /**
     * Register a config path.
     *
     * @return void
     */
    public function registerConfig() {

                $this->setConfig( $this->name );
            }

    /**
     * Render a registered item.
     *
     * @param string $name
     * @return string|false
     */
    public function render($name = null)
    {
        $registry = array_keys($this->getConfig('sidebar.register'));

        if (in_array($name, $registry)) {
            return dynamic_sidebar($name);
        }

        return false;
    }
}

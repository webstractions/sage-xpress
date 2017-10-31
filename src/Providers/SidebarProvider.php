<?php
namespace SageXpress\Providers;

use SageXpress\Providers\Traits\ConfigTrait;

class SidebarProvider extends AbstractProvider
{
    protected $name = 'sidebar';

    use ConfigTrait;

    /**
     * Gets fired during instantiation of the provider.
     * Use this method for adding actions, filters, registrations
     * or anything else that needs to be setup prior to use.
     *
     * @return void
     */
    public function boot() {

        \add_action('widgets_init', function () {
            foreach( $this->config['register'] as $sidebar ) {
                \register_sidebar(
                    $this->config["$sidebar"] + $this->config['default']
                );
            }
        });
    }

    /**
     * Render a registered item.
     *
     * @param string $name
     * @return string|false
     */
    public function render($name = null)
    {
        $registry = array_keys( $this->config['register'] );

        if (in_array($name, $registry)) {
            return dynamic_sidebar($name);
        }

        return false;
    }
}

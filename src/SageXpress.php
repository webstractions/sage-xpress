<?php

namespace SageXpress;

use Roots\Sage\Container;
use SageXpress\Blade\DirectivesProvider;
use SageXpress\Providers\MenuProvider;

class SageXpress {

    protected $sage;

    public function __construct(Container $sage) {

        $this->sage = $sage;
    }

    public function bootstrap() {

        $this->registerBladeDirectives();
        $this->registerMenuProvider();
        $this->registerSidebarProvider();
        $this->registerShortcodesProvider();
        $this->registerLayoutProvider();
    }

    protected function registerBladeDirectives() {

        (new DirectivesProvider($this->sage))->register();

    }

    protected function registerMenuProvider() {

        $this->sage->singleton('sage.menu', function () {
            return new MenuProvider($this->sage);
        });
    }

    protected function registerSidebarProvider() {

    }

    protected function registerShortcodesProvider() {

    }

    protected function registerLayoutProvider() {

    }
}

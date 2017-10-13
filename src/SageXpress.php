<?php

namespace SageXpress;

use Roots\Sage\Container;
use SageXpress\Blade\DirectivesProvider;
use SageXpress\Providers\MenuProvider;
use SageXpress\Providers\SidebarProvider;

class SageXpress {

    protected $sage;

    public function __construct(Container $sage) {

        $this->sage = $sage;
    }

    public function bootstrap() {

        $this->registerBladeDirectives();
        $this->registerMenuProvider();
        $this->registerSidebarProvider();
        $this->registerSchemaProvider();
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

        new SidebarProvider($this->sage);
    }

    protected function registerSchemaProvider() {

        $this->sage->bind('HtmlSchema', \SageXpress\Schema\SchemaFunctions::class);
        new \SageXpress\Schema\SchemaProvider($this->sage);
    }

    protected function registerShortcodesProvider() {

    }

    protected function registerLayoutProvider() {

    }
}

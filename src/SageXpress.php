<?php

namespace SageXpress;

use Roots\Sage\Container;
use SageXpress\Blade\DirectivesProvider;

class SageXpress {

    protected $sage;

    public function __construct(Container $sage) {

        $this->sage = $sage;
    }

    public function bootstrap() {

        $this->registerBladeDirectives();
        $this->registerMenuProvider();
        $this->registerSidebarProvider();
        $this->registerLayoutProvider();
    }

    protected function registerBladeDirectives() {

        (new DirectivesProvider($this->sage))->register();

    }

    protected function registerMenuProvider() {

    }

    protected function registerSidebarProvider() {

    }

    protected function registerLayoutProvider() {

    }
}

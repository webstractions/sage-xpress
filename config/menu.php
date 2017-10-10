<?php

return [

    /**
     * Register and Defaults
     *
     * This section configures your registery and defaults. The
     * Menu Provider will handle the action necessary to register
     * the menus with the provided configurations.
     *
     *
     */
    'register' => [
        'primary'    => __('Primary Navigation', 'sage'),
        'subsidiary' => __('Sub-footer Navigation', 'sage'),
    ],

    'default' => [
        'menu_class'   => 'menu',
        'container'    => 'div',
        'depth'        => 0,
        'echo'         => true,
        'item-spacing' => 'preserve',
    ],

    /**
     * Configuration Names
     *
     * Named configurations should match your "register" keys.
     * The "default" key will be merged with your named configurations.
     *
     */
    'primary' => [
        'theme_location'    => 'primary',
        'container_class'   => 'collapse navbar-collapse',
        'container_id'      => 'primary-menu',
        'menu_class'        => 'navbar-nav ml-auto',
        'depth'             => 2,
        'fallback_cb'		  => '\App\Lib\WP_Bootstrap_Navwalker::fallback',
        'walker'			  => new \App\Lib\WP_Bootstrap_Navwalker(),
    ],

    'subsidiary' => [
        'theme_location'    => 'subsidiary',
        'container_class'   => 'row justify-content-center',
        'container_id'      => 'subsidiary-menu',
        'depth'             => 1,
        'fallback_cb'		  => '\App\Lib\WP_Bootstrap_Navwalker::fallback',
        'walker'			  => new \App\Lib\WP_Bootstrap_Navwalker(),
    ],

];

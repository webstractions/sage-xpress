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
        'footer' => __('Footer Navigation', 'sage'),
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
        'depth'             => 2,
    ],

    'footer' => [
        'theme_location'    => 'footer',
        'depth'             => 1,
    ],

];

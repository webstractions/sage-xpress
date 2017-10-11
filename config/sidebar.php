<?php

return [

    /**
     * Ids of sidebars you want to register.
     */
    "register" => [
        'sidebar-primary',
        'sidebar-footer'
    ],

    /**
     * Default config options for all sidebars
     */
    "default" => [
        'after_widget'  => "</section>",
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>'
    ],

    /**
     * Sidebar configuration.
     */
    'sidebar-primary' => [
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary',
        'before_widget' => '<section class="widget %1$s %2$s">',
    ],

    /**
     * Sidebar configuration.
     */
    'sidebar-footer' => [
        'name'          => __('Footer', 'sage'),
        'id'            => 'sidebar-footer',
        'before_widget' => '<section class="widget col-lg %1$s %2$s">',
    ],
];


# Sage Xpress

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/appstract/laravel-blade-directives/master.svg?style=flat-square)](https://travis-ci.org/webstractions/sage-xpress)

A collection of extensions for your Roots\Sage 9.x beta themes.

- **Blade Directives:** @directives for loop, query, sidebar, FontAwesome, and more.
- **Menu Provider:** Register nav menus via configuration file.

## Requirements
This package is specifically built for `Roots\Sage 9.0.0-beta.4` and above. It goes without saying that your development server needs to have `Php 7.0` or greater as well.

## Installation

You can install the package via composer:

```bash
composer require webstractions/sage-xpress
```
## Sage Xpress Setup

Add to your `after_theme_setup` action in `app/setup.php` file. It is important that you make this addition **after** Sage's singleton for the `BladeProvider`:

```php
add_action('after_setup_theme', function (){

  ...

  /**
    * Add Blade to Sage container
    */
  sage()->singleton('sage.blade', function (Container $app) {
      $cachePath = config('view.compiled');
      if (!file_exists($cachePath)) {
          wp_mkdir_p($cachePath);
      }
      (new BladeProvider($app))->register();
      return new Blade($app['view']);
  });

  // Copy this part into app\setup.php after_theme_setup action.
  // Make sure it follows the Sage singleton for the Blade Provider.
  (new \SageXpress\SageXpress(sage()))->bootstrap();

});
```
## Overview
Outside of one line of code that you need to add to `setup.php` and the config files, there is nothing else you need to do. Config files are automatically registered with the Sage Container, no messing with `functions.php`.

Additionally, your `setup.php` file should actually be leaner. No need for `widgets_init`, `register_nav_menus`, and funky `wp_nav_menu` callouts in your controllers or blade files. The providers automatically do the registration for you based on your configurations and there are Blade Directives to spew them out.

### Blade Directives
There are a whole slew of directives, and requires its own [Blade Directives Documentation](https://github.com/webstractions/sage-xpress/tree/master/docs/blade.md).

One example, the `@loop` directive does a nice job of cleaning up your templates.
```blade
@loop

   {{-- Code inside of the loop --}}

@endloop
```
The directive will output this php.

```php
if (have_posts()) :
  while(have_posts()) :
    the_post();

    // Code inside of the loop

  endwhile;
endif;
```
### Menu Provider
Configure your menus in `config\menu.php`. The `MenuProvider` will handle the registration with WordPress.
```php
<?php

return [

    'register' => [
        'primary'    => __('Primary Navigation', 'sage'),
    ],

    'default' => [],

    'primary' => [
        'theme_location'    => 'primary',
        'container_class'   => 'collapse navbar-collapse',
        'container_id'      => 'primary-menu',
        'menu_class'        => 'navbar-nav ml-auto',
        'depth'             => 2,
        'fallback_cb'       => '\App\Lib\WP_Bootstrap_Navwalker::fallback',
        'walker'            => new \App\Lib\WP_Bootstrap_Navwalker(),
    ],
];
```
You can safely remove any configured menus from your `setup.php` file.
```php
// Delete this function. MenuProvider has it handled.
register_nav_menus([
	'primary' => __('Primary Navigation', 'sage'),
]);
```
Use `@menu` directive in your Blade files to render a menu.
```blade
@menu('primary')
```

Alternatively, you can create a static rendering function in `app\controllers\app.php`
```php
public static function renderMenu($name='')
{
    return sage('menu')->render($name);
}
```
Then call the function in your Blade files.
```blade
@php( \App::renderMenu('primary') )
```

### Sidebar Provider
Configure your sidebars in `config\sidebar.php`. The `SidebarProvider` will handle the registration with WordPress.

```php
<?php

return [

    /**
     * Ids of sidebars you want to register.
     */
    "register" => [
        'sidebar-primary',
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
];
```

You can safely remove any configured sidebars from your `setup.php` file.
```php
// Delete this function. The SidebarProvider has it handled.
/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary'
    ] + $config);

});
```

Use `@sidebar` directive in your Blade files to render a menu.
```blade
@sidebar('sidebar-primary')
```

Alternatively, you can still use WordPress functions to display a sidebar.

```blade
@php( \dynamic_sidebar('sidebar-primary') )
```
## Documentation
- [Blade Directives](https://github.com/webstractions/sage-xpress/tree/master/docs/blade.md)

## Acknowledgements
- Roots/Sage Discourse thread [Resources for Blade](https://discourse.roots.io/t/best-practice-resources-for-blade/8341) and [Log1x's](https://discourse.roots.io/u/Log1x) contributions for inspiring the Blade component.
- Appstract's [Laravel Blade Directives](https://github.com/appstract/laravel-blade-directives) for configuration and service provider logic.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

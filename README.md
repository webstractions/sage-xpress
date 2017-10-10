# Sage Xpress

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/appstract/laravel-blade-directives/master.svg?style=flat-square)](https://travis-ci.org/webstractions/sage955)

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
## Documentation
- [Blade Directives](https://github.com/webstractions/sage-xpress/tree/master/docs/blade.md)

## Acknowledgements
- Roots/Sage Discourse thread [Resources for Blade](https://discourse.roots.io/t/best-practice-resources-for-blade/8341) and [Log1x's](https://discourse.roots.io/u/Log1x) contributions for inspiring the Blade component.
- Appstract's [Laravel Blade Directives](https://github.com/appstract/laravel-blade-directives) for configuration and service provider logic.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

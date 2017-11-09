# Sage Xpress

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://travis-ci.org/webstractions/sage-xpress.svg?branch=master)](https://travis-ci.org/webstractions/sage-xpress)

A collection of extensions, providers, and Blade revisions for your Roots\Sage 9.x beta themes.

- **Blade Directives:** @directives for loop, query, sidebar, FontAwesome, and more.
- **Menu Provider:** Register nav menu and markup via configuration file.
- **Sidebar Provider:** Register sidebar and widget markup via configuration file.
- **Comment Form Provider:** Register comment form markup via configuration file.
- **Schema Provider** Quickly add schema.org markup via @schema directive.
- **Facade/Alias Support** Provide a "static" interface to classes that are bound to the Sage container.
- **Blade Fixes** Fixes Blade `@inject` directive and 5.5's `Blade::if()` method.

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

**Important** Since this package is introducing new Blade directives, you should clear your cached/compiled Blade files. Those files are located in `wp-content\uploads\cache`.

## Configuration Files
Currently, you have to copy and paste the sample config files into your theme `config` directory. You can find them in the `vendor\webstractions\sage-xpress\config` directory.

The configuration files are a major component of SageXpress that drives the Providers (more below).

- `app.php` Registers theme environment, providers, composers, and aliases.
- `blade-directives.php` For your custom Blade directives.
- `comments.php` Comment form configuration. Other comments related tasks.
- `menu.php` Register nav menus and configurations.
- `sidebar.php` Register sidebars and configurations.

## Overview
Outside of one line of code that you need to add to `setup.php` and the config files, there is nothing else you need to do. Config files are automatically registered with the Sage Container, no messing with `functions.php`.

Additionally, your `setup.php` file should actually be leaner. No need for `widgets_init`, `register_nav_menus`, and funky `wp_nav_menu` callouts in your controllers or blade files. The providers automatically do the registration for you based on your configurations and there are Blade Directives to spew them out.

## Facades and Aliases
You can now register `aliases` via the `config\app.php` configuration file. Currently, there are standard Laravel Facades for Blade, Config, Event, File, and View. Facades for SageXpress providers are in a state of flux and currently supports Comments, Menu, and Sidebar.

With Facades, you can reference bound providers with unruly instantiation and method calls like the following.

Instead of
```php
sage('blade')->compiler()->directive('name', function ($expression) {
        // Handle the directive.
    });
```
You can:
```php
Blade::directive('name', function ($expression) {
        // Handle the directive.
    });
```
Facades have some advantages. Rather than list the pros and cons of Facades, and how they work, please reference the [Laravel Facade Documentation](https://laravel.com/docs/5.4/facades).

## The SageXpress Provider
SageXpress providers are similar to Laravel Service Providers, but they contain additional methods for `config()` and `render()`. You can think of them as configurable components that can be rendered in a Blade view.

Providers are autoloaded via the `config\app.php` congifuration file during the SageXpress boot process. The providers are then bound to the Sage Container where you can use or reference them from your theme classes and controllers.

Providers handle WordPress-centric methods for registration, filters, etc. The `render()` method can be used for the creation of custom Blade directives.

### Blade Directives Provider
Provides some handy Blade directives targetted mostly for WordPress use, but other helpful functionality as well.

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

### Comment Form Provider
Configure your comment form in `config\comments.php` and use the `@commentform` directive to display in your Blade templates.

The following shows an example configuration for Bootstrap 4 Beta markup.
```php
<?php

return [
    'comment_form' => [
        // Change the title of send button
        'label_submit' => __( 'Send', 'textdomain' ),
        // Change the title of the reply section
        'title_reply' => __( 'Write a Reply or Comment', 'textdomain' ),
        // Remove "Text or HTML to be displayed after the set of comment fields".
        'comment_notes_after' => '',
        'comment_field' => '
          <div class="form-group">
            <label for="comment">' . _x( 'Comment', 'sage' ) . '</label>
            <br />
            <textarea id="comment" name="comment" class="form-control" aria-required="true"></textarea>
          </div>',
        'fields' => [
          'author' => '
            <div class="form-group row">
              <label for="author" class="col-2 col-form-label">' . _x( 'Name', 'sage' ) . '</label>
              <div class="col-10">
                <input type="text" class="form-control" id="author" name="author" maxlength="245" required>
                <div class="invalid-feedback">
                    Please provide a valid name.
                </div>
              </div>
            </div>',
          'email' => '
            <div class="form-group row">
              <label for="email" class="col-2 col-form-label">' . _x( 'Email', 'sage' ) . '</label>
              <div class="col-10">
                <input type="email" class="form-control" id="email" name="email" maxlength="245" aria-required="true" required="required">
              </div>
              <div class="invalid-feedback">
                  Please provide a valid email.
              </div>
            </div>',
          'url' => '
            <div class="form-group row">
              <label for="url" class="col-2 col-form-label">' . _x( 'Url', 'sage' ) . '</label>
              <div class="col-10">
                <input class="form-control" type="url" value="" id="url">
              </div>
            </div>',
        ],
    ],
];
```

### Schema Provider
As with the Blade directives, there are numerous schema.org attributes and has its own documentaion. There are also two filters for each attribute, which can be used to extend them further. See [Schema Provider Documentation](https://github.com/webstractions/sage-xpress/tree/master/docs/schema.md) for complete details.

Using the `@schema` directive makes markup simple.

```blade
{{--  Author  --}}
<span @schema( 'entry-author' )>
  @php( the_author_posts_link() )
</span>
```
Will produce the following Php.
```php
<span class="entry-author" itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person">
    <?php ( the_author_posts_link() ); ?>
</span>
```

## Documentation
- [Blade Directives](https://github.com/webstractions/sage-xpress/tree/master/docs/blade.md)
- [Schema Attributes](https://github.com/webstractions/sage-xpress/tree/master/docs/schema.md)

## Acknowledgements
- Roots/Sage Discourse thread [Resources for Blade](https://discourse.roots.io/t/best-practice-resources-for-blade/8341) and [Log1x's](https://discourse.roots.io/u/Log1x) contributions for inspiring the Blade component.
- Appstract's [Laravel Blade Directives](https://github.com/appstract/laravel-blade-directives) for configuration and service provider logic.
- Justin Tadlock's `hybrid_attr()` functions from older versions of [Hybrid Core](https://github.com/justintadlock/hybrid-core).


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

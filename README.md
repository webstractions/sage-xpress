# Roots\Sage Developer Extensions

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/appstract/laravel-blade-directives/master.svg?style=flat-square)](https://travis-ci.org/webstractions/sage955)

A collection of extensions for your Roots\Sage themes.

- **Blade Directives:** @directives for loop, query, sidebar, FontAwesome, and more.
- **Whoops Pretty Debugger:** PHP error handler for cool kids .
- **GetTheImage:** (very soon) Adapted version of Justin Tadlock's plugin for Sage use.
- **Schema Attributes:** (planned) Add schema.org attributes with no fuss.
- **Template Utilities:** (planned) Bootstrap Walker Menu, filter/action configurations, etc.
- **Sage CLI:** (planned) A Sage counterpart to Laravel Artisan.

## Requirements
This package is specifically built for `Roots\Sage 9.0.0-beta.4` and above. It goes without saying that your development server needs to have `Php 7.0` or greater as well.

## Installation

You can install the package via composer:

```bash
composer require webstractions/sage-devtools
```

## Whoops Setup
Add the following to the top of your `app\setup.php` file. The higher up the better, preferrably following all of the `use` statements:

```php
namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;
use This\Other\Class\Too;

// Copy this part into app\setup.php
function registerWhoops() {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}
registerWhoops();
```

## Blade Directives Setup

Add to your `after_theme_setup` action in `app/setup.php` file. It is important that you make this addition **after** Sage's singleton for the `BladeProvider`:

```php
add_action('after_setup_theme', function (){

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
  (new \SageDevTools\Blade\DirectivesProvider(sage()))->register();

});
```

## Blade Directives Usage

### @loop

```blade
@loop

   {{-- Code inside of the loop --}}

@endloop
```
Output:

```php
if (have_posts()) :
  while(have_posts()) :
    the_post();

    // Code inside of the loop

  endwhile;
endif;
```

### @query( $query )

```blade
@query('expression')

   {{-- Code inside of your new query loop --}}

@endquery
```

Output:
```php
$__query = new WP_Query(' . $expression . ');
if ($__query->have_posts()) :
  while($__query->have_posts()) :
    $__query->the_post(); ?>";

    // Code inside of your new query loop

  endwhile;
endif;
```

### @doaction( $action )

```blade
@doaction('before_header')
```

### @sidebar( $location )

```blade
@sidebar('primary')
```

### @wphead and @wpfooter

```blade
@wphead
@wpfooter
```

### @fa

Quickly output a Font Awesome icon.

```blade
@fa('address-book')
```


### @istrue

Only show when ```$variable``` isset and true.

```blade
@istrue($variable)
   This will be echoed
@endistrue
```

Or when you would like to quickly echo

```blade
@istrue($variable, 'This will be echoed')
```

### @isfalse

Same as ```@istrue``` but checks for isset and false.

```blade
@isfalse($variable)
   This will be echoed
@endisfalse
```

### @dump and @dd

```blade
@dump($var)

@dd($var)
```

### @mix

Create a HTML element to your Laravel-Mix css or js.
```blade
@mix('/css/app.css')
@mix('/css/app.js')
```
Output:

```blade
<link rel="stylesheet" href="{{ mix('/css/app.css') }}">
<script src="{{ mix('/css/app.js') }}"></script>
```

### @style

Create a ```<style>``` element or ```<link>``` element with a css path.

```blade
@style
    body { background: black }
@endstyle


@style('/css/app.css')
```

### @script

Create a ```<script>``` element with or without a js path.

```blade
@script
    alert('hello world')
@endscript


@script('/js/app.js')
```

### @inline

Load the contents of a css or js file inline in your view.

```blade
@inline('/js/manifest.js')
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

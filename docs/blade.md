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

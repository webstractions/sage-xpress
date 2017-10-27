<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Theme Configuration (WIP)
    |--------------------------------------------------------------------------
    | Set a few environment variables defined in our .env
    | - name   : Name of this theme
    | - env    : Environment is either 'local' or default 'production'
    | - debug  : Either 'true' or default 'false'
    | - textdomain : Default is 'sage'
    | - Locale : Locale used by the TranslationServiceProvider (not used yet)
    */

    'name'       => env( 'SAGE_THEME_NAME',   'SageXpress'   ),
    'env'        => env( 'SAGE_THEME_ENV',    'production' ),
    'debug'      => env( 'SAGE_THEME_DEBUG',   false       ),
    'textdomain' => env( 'SAGE_TEXTDOMAIN',    'sage'      ),

    // -- OTHER ENV VARIABLES AVAILABLE
    // SAGE_SAVE_QUERIES=false
    // SAGE_SCRIPT_DEBUG=false
    // SAGE_CACHE_DRIVER=file

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Sage Xpress Service Providers
         */
        SageXpress\Blade\DirectivesProvider::class,
        SageXpress\Providers\AppProvider::class,
        SageXpress\Providers\CommentsProvider::class,
        SageXpress\Providers\MenuProvider::class,
        SageXpress\Providers\SidebarProvider::class,
        SageXpress\Schema\SchemaProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Autoloaded View Composers
    |--------------------------------------------------------------------------
    |
    | The view composers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own composers to
    | this array to grant expanded functionality to your applications.
    |
    */
    'composers' => [
        App\Composers\AcfObjectComposer::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases (WIP)
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        /* Illuminate Facades */
        // 'Artisan'      => Illuminate\Support\Facades\Artisan::class,
        'Blade'        => Illuminate\Support\Facades\Blade::class,
        // 'Cache'        => Illuminate\Support\Facades\Cache::class,
        'Config'       => Illuminate\Support\Facades\Config::class,
        'Event'        => Illuminate\Support\Facades\Event::class,
        'File'         => Illuminate\Support\Facades\File::class,
        // 'Lang'         => Illuminate\Support\Facades\Lang::class,
        // 'Route'        => Illuminate\Support\Facades\Route::class,
        // 'Storage'      => Illuminate\Support\Facades\Storage::class,
        'View'         => Illuminate\Support\Facades\View::class,

        /* SageXpress Facades */
        // 'App'          => App\Foundation\Support\Facades\App::class,
        // 'Action'       => App\Foundation\Support\Facades\Action::class,
        // 'Filter'       => App\Foundation\Support\Facades\Filter::class,
        // 'PostType'     => App\Foundation\Support\Facades\PostType::class,
        // 'Loop'         => App\Foundation\Support\Facades\Loop::class,
        // 'Query'        => App\Foundation\Support\Facades\Query::class,
        // 'Taxonomy'     => App\Foundation\Support\Facades\Taxonomy::class,
        // 'Asset'        => App\Foundation\Support\Facades\Asset::class,

    ],

];

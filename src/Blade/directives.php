<?php

use SageXpress\Blade\DirectivesRepository;

return [

    /**
     * WordPress centric directives
     */
    'loop' => function() {
        return "<?php if (have_posts()) : while(have_posts()) : the_post(); ?>";
    },

    'endloop' => function() {
        return "<?php endwhile; endif; ?>";
    },

    'query' => function($expression) {
        return
        "<?php $__query = new WP_Query(' . $expression . ');
        if ($__query->have_posts()) :
            while($__query->have_posts()) :
                $__query->the_post(); ?>";

    },

    'endquery' => function() {
        return "<?php endwhile; endif; wp_reset_postdata(); ?>";
    },

    'sidebar' => function($expression) {
        return "<?php dynamic_sidebar($expression); ?>";
    },

    'menu' => function($expression) {
        return sage('menu')->render($name);
    },

    'wphead' => function() {
        return "<?php wp_head(); ?>";
    },

    'wpfooter' => function() {
        return "<?php wp_footer(); ?>";
    },

    'doaction' => function($expression) {
        return "<?php echo do_action($expression); ?>";
    },

    /*
    |---------------------------------------------------------------------
    | @schema
    |---------------------------------------------------------------------
    */
    'schema' => function($expression) {
        // $expression should be in form of [$slug, $context='', $attr=[]]
        $expression = explode( ",", $expression );
        $expression = array_replace( ['','',[] ] , $expression);
        $html = \App\sage()->make('HtmlSchema')->attr($expression[0],$expression[1],$expression[2]);
        return $html;
    },
    /*
    |---------------------------------------------------------------------
    | @istrue / @isfalse
    |---------------------------------------------------------------------
    */

    'istrue' => function ($expression) {
        if (str_contains($expression, ',')) {
            $expression = DirectivesRepository::parseMultipleArgs($expression);

            return  "<?php if (isset({$expression->get(0)}) && (bool) {$expression->get(0)} === true) : ?>".
                    "<?php echo {$expression->get(1)}; ?>".
                    '<?php endif; ?>';
        }

        return "<?php if (isset({$expression}) && (bool) {$expression} === true) : ?>";
    },

    'endistrue' => function ($expression) {
        return '<?php endif; ?>';
    },

    'isfalse' => function ($expression) {
        if (str_contains($expression, ',')) {
            $expression = DirectivesRepository::parseMultipleArgs($expression);

            return  "<?php if (isset({$expression->get(0)}) && (bool) {$expression->get(0)} === false) : ?>".
                "<?php echo {$expression->get(1)}; ?>".
                '<?php endif; ?>';
        }

        return "<?php if (isset({$expression}) && (bool) {$expression} === false) : ?>";
    },

    'endisfalse' => function ($expression) {
        return '<?php endif; ?>';
    },

    /*
    |---------------------------------------------------------------------
    | @mix
    |---------------------------------------------------------------------
    */

    'mix' => function ($expression) {
        if (ends_with($expression, ".css'")) {
            return '<link rel="stylesheet" href="<?php echo mix('.$expression.') ?>">';
        } elseif (ends_with($expression, ".js'")) {
            return '<script src="<?php echo mix('.$expression.') ?>"></script>';
        }

        return "<?php echo mix({$expression}); ?>";
    },

    /*
    |---------------------------------------------------------------------
    | @style
    |---------------------------------------------------------------------
    */

    'style' => function ($expression) {
        if (! empty($expression)) {
            return '<link rel="stylesheet" href="'.DirectivesRepository::stripQuotes($expression).'">';
        }

        return '<style>';
    },

    'endstyle' => function () {
        return '</style>';
    },

    /*
    |---------------------------------------------------------------------
    | @script
    |---------------------------------------------------------------------
    */

    'script' => function ($expression) {
        if (! empty($expression)) {
            return '<script src="'.DirectivesRepository::stripQuotes($expression).'"></script>';
        }

        return '<script>';
    },

    'endscript' => function () {
        return '</script>';
    },

    /*
    |---------------------------------------------------------------------
    | @inline
    |---------------------------------------------------------------------
    */

    'inline' => function ($expression) {
        $include = "//  {$expression}\n".
            "<?php include public_path({$expression}) ?>\n";

        if (ends_with($expression, ".css'")) {
            return "<style>\n".$include.'</style>';
        } elseif (ends_with($expression, ".js'")) {
            return "<script>\n".$include.'</script>';
        }
    },

    /*
    |---------------------------------------------------------------------
    | @js
    |---------------------------------------------------------------------
    */

    'js' => function ($expression) {
        $expression = DirectivesRepository::parseMultipleArgs($expression);

        $variable = DirectivesRepository::stripQuotes($expression->get(0));

        return  "<script>\n".
                "window.{$variable} = <?php echo is_array({$expression->get(1)}) ? json_encode({$expression->get(1)}) : '\''.{$expression->get(1)}.'\''; ?>;\n".
                '</script>';
    },

    /*
    |---------------------------------------------------------------------
    | @dump, @dd
    |---------------------------------------------------------------------
    */

    'dump' => function ($expression) {
        return "<?php dump({$expression}); ?>";
    },

    'dd' => function ($expression) {
        return "<?php dd({$expression}); ?>";
    },


    /*
    |---------------------------------------------------------------------
    | @fa
    |---------------------------------------------------------------------
    */

    'fa' => function ($expression) {
        return '<i class="fa fa-'.DirectivesRepository::stripQuotes($expression).'"></i>';
    },

];

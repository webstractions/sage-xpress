<?php

namespace SageXpress\Schema;

/**
 * Schema Functions
 *
 * Quick and dirty schema.org attribute provider.
 *
 * Based on original work from Justin Tadlock's Hybrid Core.
 * There are no 'class' additions here. Just 'schema.org' attributes.
 *
 */
class SchemaFunctions {


    /**
     * Outputs an HTML schema.org attributes.
     *
     * @param  string  $slug     The slug/ID of the element (e.g., 'sidebar').
     * @param  string  $context  A specific context (e.g., 'primary').
     * @param  array   $attr     Array of attributes to pass in (overwrites filters).
     * @return void
     */
    public function attr( $slug, $context = '', $attr = array()  ) {

        // Trim apostrophes, cuz Blade will pass these through
        $slug = trim(str_replace("'","",$slug));
        $context = trim(str_replace("'","",$context));

        $html =  $this->get_attr( $slug, $context, $attr );
        return $html;
    }

    /**
     * Gets an HTML element's attributes.  This function is actually meant to be filtered by theme authors, plugins,
     * or advanced child theme users.  The purpose is to allow folks to modify, remove, or add any attributes they
     * want without having to edit every template file in the theme.  So, one could support microformats instead
     * of microdata, if desired.
     *
     * @param  string  $slug     The slug/ID of the element (e.g., 'sidebar').
     * @param  string  $context  A specific context (e.g., 'primary').
     * @param  array   $attr     Array of attributes to pass in (overwrites filters).
     * @return string
     */
    function get_attr( $slug, $context = '', $attr = array() ) {

        $out = '';

        // Default attributes.
        $defaults = array( 'class' => $context ? "{$slug} {$slug}-{$context}" : $slug );

        // Filtered attributes.
        $filtered = apply_filters( 'sage_schema', $defaults, $slug, $context  );
        $filtered = apply_filters( "sage_schema_{$slug}", $filtered, $context );
        // var_dump( "sage_attr_{$slug}");die;

        // Merge the attributes with those input.
        $attr = wp_parse_args( $attr, $filtered );

        // Assure there is a  'class' attribute for filtering
        if( ! array_key_exists('class', $attr ) )
            $attr['class'] = '';

        foreach ( $attr as $name => $value ) {

            // Provide a filter hook for the class attribute directly. The classes are
            // split up into an array for easier filtering. Note that theme authors
            // should still utilize the core WP body, post, and comment class filter
            // hooks. This should only be used for custom attributes.
            if ( 'class' === $name && has_filter( "sage_schema_{$slug}_class" ) ) {

                $value = join( ' ', apply_filters( "sage_schema_{$slug}_class", explode( ' ', $value ) ) );
            }

            if ( 'class' === $name && $value === '' ) {
                // Don't pass an empty class
            }
            else {
                $out .= false !== $value ? sprintf( ' %s="%s"', esc_html( $name ), esc_attr( $value ) ) : esc_html( " {$name}" );
            }
        }

        return trim( $out );
    }


    /* === Structural === */

    /**
     * <body> element attributes.
     *
     * @param  array   $attr
     * @return array
     */
    static function schema_body( $attr ) {

        $attr['class']     = join( ' ', get_body_class() );
        $attr['dir']       = is_rtl() ? 'rtl' : 'ltr';
        $attr['itemscope'] = 'itemscope';
        $attr['itemtype']  = 'http://schema.org/WebPage';

        if ( is_singular( 'post' ) || is_home() || is_archive() )
            $attr['itemtype'] = 'http://schema.org/Blog';

        elseif ( is_search() )
            $attr['itemtype'] = 'http://schema.org/SearchResultsPage';

        return $attr;
    }

    /**
     * Page <header> element attributes.
     *
     * @param  array   $attr
     * @return array
     */
    static function schema_header( $attr ) {

        $attr['id']        = 'masthead';
        $attr['class']     = 'site-header';
        $attr['role']      = 'banner';
        $attr['itemscope'] = 'itemscope';
        $attr['itemtype']  = 'http://schema.org/WPHeader';

        return $attr;
    }

    /**
     * Page <footer> element attributes.
     *
     * @param  array   $attr
     * @return array
     */
    static function schema_footer( $attr ) {

        $attr['id']        = 'footer';
        $attr['class']     = 'site-footer';
        $attr['role']      = 'contentinfo';
        $attr['itemscope'] = 'itemscope';
        $attr['itemtype']  = 'http://schema.org/WPFooter';

        return $attr;
    }

    /**
     * Main content container of the page attributes.
     *
     * @param  array   $attr
     * @return array
     */
    static function schema_content( $attr ) {

        $attr['id']       = 'content';
        $attr['class']    = 'content';
        $attr['role']     = 'main';

        if ( ! is_singular( 'post' ) && ! is_home() && ! is_archive() )
            $attr['itemprop'] = 'mainContentOfPage';

        return $attr;
    }

    /**
     * Sidebar attributes.
     *
     * @param  array   $attr
     * @param  string  $context
     * @return array
     */
    static function schema_sidebar( $attr, $context ) {

        $attr['class'] = 'sidebar';
        $attr['role']  = 'complementary';

        if ( $context ) {

            $attr['class'] .= " sidebar-{$context}";
            $attr['id']     = "sidebar-{$context}";

            $sidebar_name = (__CLASS__)::get_sidebar_name( $context );

            if ( $sidebar_name ) {
                // Translators: The %s is the sidebar name. This is used for the 'aria-label' attribute.
                $attr['aria-label'] = esc_attr( sprintf( _x( '%s Sidebar', 'sidebar aria label', 'hybrid-core' ), $sidebar_name ) );
            }
        }

        $attr['itemscope'] = 'itemscope';
        $attr['itemtype']  = 'http://schema.org/WPSideBar';

        return $attr;
    }

    /**
     * Nav menu attributes.
     *
     * @param  array   $attr
     * @param  string  $context
     * @return array
     */
    static function schema_menu( $attr, $context ) {

        $attr['class'] = 'menu';
        $attr['role']  = 'navigation';

        if ( $context ) {


            $attr['class'] .= " menu-{$context}";
            $attr['id']     = "menu-{$context}";

            $menu_name = $this->get_menu_location_name( $context );

            if ( $menu_name ) {
                // Translators: The %s is the menu name. This is used for the 'aria-label' attribute.
                $attr['aria-label'] = esc_attr( sprintf( _x( '%s Menu', 'nav menu aria label', 'hybrid-core' ), $menu_name ) );
            }
        }

        $attr['itemscope']  = 'itemscope';
        $attr['itemtype']   = 'http://schema.org/SiteNavigationElement';

        return $attr;
    }

    /* === header === */

    /**
     * <head> attributes.
     *
     * @param  array   $attr
     * @return array
     */
    static function schema_head( $attr ) {

        $attr['itemscope'] = 'itemscope';
        $attr['itemtype']  = 'http://schema.org/WebSite';

        return $attr;
    }

    /**
     * Branding (usually a wrapper for title and tagline) attributes.
     *
     * @param  array   $attr
     * @return array
     */
    static function schema_branding( $attr ) {

        $attr['id']    = 'branding';
        $attr['class'] = 'site-branding';

        return $attr;
    }

    /**
     * Site title attributes.
     *
     * @param  array   $attr
     * @param  string  $context
     * @return array
     */
    static function schema_site_title( $attr ) {

        $attr['id']       = 'site-title';
        $attr['class']    = 'site-title';
        $attr['itemprop'] = 'headline';

        return $attr;
    }

    /**
     * Site description attributes.
     *
     * @param  array   $attr
     * @param  string  $context
     * @return array
     */
    static function schema_site_description( $attr ) {

        $attr['id']       = 'site-description';
        $attr['class']    = 'site-description';
        $attr['itemprop'] = 'description';

        return $attr;
    }

    /* === loop === */

    /**
     * Archive header attributes.
     *
     * @param  array   $attr
     * @param  string  $context
     * @return array
     */
    static function schema_archive_header( $attr ) {

        $attr['class']     = 'archive-header';
        $attr['itemscope'] = 'itemscope';
        $attr['itemtype']  = 'http://schema.org/WebPageElement';

        return $attr;
    }

    /**
     * Archive title attributes.
     *
     * @param  array   $attr
     * @param  string  $context
     * @return array
     */
    static function schema_archive_title( $attr ) {

        $attr['class']     = 'archive-title';
        $attr['itemprop']  = 'headline';

        return $attr;
    }

    /**
     * Archive description attributes.
     *
     * @param  array   $attr
     * @param  string  $context
     * @return array
     */
    static function schema_archive_description( $attr ) {

        $attr['class']     = 'archive-description';
        $attr['itemprop']  = 'text';

        return $attr;
    }

    /* === posts === */

    /**
     * Post <article> element attributes.
     *
     * @param  array   $attr
     * @return array
     */
    static function schema_post( $attr ) {

        $post = get_post();

        // Make sure we have a real post first.
        if ( ! empty( $post ) ) {

            $attr['id']        = 'post-' . get_the_ID();
            $attr['class']     = join( ' ', get_post_class() );
            $attr['itemscope'] = 'itemscope';

            if ( 'post' === get_post_type() ) {

                $attr['itemtype']  = 'http://schema.org/BlogPosting';

                /* Add itemprop if within the main query. */
                if ( is_main_query() && ! is_search() )
                    $attr['itemprop'] = 'blogPost';
            }

            elseif ( 'attachment' === get_post_type() && wp_attachment_is_image() ) {

                $attr['itemtype'] = 'http://schema.org/ImageObject';
            }

            elseif ( 'attachment' === get_post_type() && $this->attachment_is_audio() ) {

                $attr['itemtype'] = 'http://schema.org/AudioObject';
            }

            elseif ( 'attachment' === get_post_type() && $this->attachment_is_video() ) {

                $attr['itemtype'] = 'http://schema.org/VideoObject';
            }

            else {
                $attr['itemtype']  = 'http://schema.org/CreativeWork';
            }

        } else {

            $attr['id']    = 'post-0';
            $attr['class'] = join( ' ', get_post_class() );
        }

        return $attr;
    }

    /**
     * Post title attributes.
     *
     * @param  array   $attr
     * @return array
     */
    static function schema_entry_title( $attr ) {

        $attr['class']    = 'entry-title';
        $attr['itemprop'] = 'headline';

        return $attr;
    }

    /**
     * Post author attributes.
     *
     * @param  array   $attr
     * @return array
     */
    static function schema_entry_author( $attr ) {

        $attr['class']     = 'entry-author';
        $attr['itemprop']  = 'author';
        $attr['itemscope'] = 'itemscope';
        $attr['itemtype']  = 'http://schema.org/Person';

        return $attr;
    }

    /**
     * Post time/published attributes.
     *
     * @param  array   $attr
     * @return array
     */
    static function schema_entry_published( $attr ) {

        $attr['class']    = 'entry-published updated';
        $attr['datetime'] = get_the_time( 'Y-m-d\TH:i:sP' );
        $attr['itemprop'] = 'datePublished';

        // Translators: Post date/time "title" attribute.
        $attr['title']    = get_the_time( _x( 'l, F j, Y, g:i a', 'post time format', 'hybrid-core' ) );

        return $attr;
    }

    /**
     * Post content (not excerpt) attributes.
     *
     * @param  array   $attr
     * @return array
     */
    static function schema_entry_content( $attr ) {

        $attr['class'] = 'entry-content';

        if ( 'post' === get_post_type() )
            $attr['itemprop'] = 'articleBody';
        else
            $attr['itemprop'] = 'text';

        return $attr;
    }

    /**
     * Post summary/excerpt attributes.
     *
     * @param  array   $attr
     * @return array
     */
    static function schema_entry_summary( $attr ) {

        $attr['class']    = 'entry-summary';
        $attr['itemprop'] = 'description';

        return $attr;
    }

    /**
     * Post terms (tags, categories, etc.) attributes.
     *
     * @param  array   $attr
     * @param  string  $context
     * @return array
     */
    static function schema_entry_terms( $attr, $context ) {

        if ( !empty( $context ) ) {

            $attr['class'] = 'entry-terms ' . sanitize_html_class( $context );

            if ( 'category' === $context )
                $attr['itemprop'] = 'articleSection';

            else if ( 'post_tag' === $context )
                $attr['itemprop'] = 'keywords';
        }

        return $attr;
    }


    /* === Comment elements === */


    /**
     * Comment wrapper attributes.
     *
     * @param  array   $attr
     * @return array
     */
    static function schema_comment( $attr ) {

        $attr['id']    = 'comment-' . get_comment_ID();
        $attr['class'] = join( ' ', get_comment_class() );

        if ( in_array( get_comment_type(), array( '', 'comment' ) ) ) {

            $attr['itemprop']  = 'comment';
            $attr['itemscope'] = 'itemscope';
            $attr['itemtype']  = 'http://schema.org/Comment';
        }

        return $attr;
    }

    /**
     * Comment author attributes.
     *
     * @param  array   $attr
     * @return array
     */
    static function schema_comment_author( $attr ) {

        $attr['class']     = 'comment-author';
        $attr['itemprop']  = 'author';
        $attr['itemscope'] = 'itemscope';
        $attr['itemtype']  = 'http://schema.org/Person';

        return $attr;
    }

    /**
     * Comment time/published attributes.
     *
     * @param  array   $attr
     * @return array
     */
    static function schema_comment_published( $attr ) {

        $attr['class']    = 'comment-published';
        $attr['datetime'] = get_comment_time( 'Y-m-d\TH:i:sP' );

        // Translators: Comment date/time "title" attribute.
        $attr['title']    = get_comment_time( _x( 'l, F j, Y, g:i a', 'comment time format', 'hybrid-core' ) );
        $attr['itemprop'] = 'datePublished';

        return $attr;
    }

    /**
     * Comment permalink attributes.
     *
     * @param  array   $attr
     * @return array
     */
    static function schema_comment_permalink( $attr ) {

        $attr['class']    = 'comment-permalink';
        $attr['href']     = get_comment_link();
        $attr['itemprop'] = 'url';

        return $attr;
    }

    /**
     * Comment content/text attributes.
     *
     * @param  array   $attr
     * @return array
     */
    static function schema_comment_content( $attr ) {

        $attr['class']    = 'comment-content';
        $attr['itemprop'] = 'text';

        return $attr;
    }

    /****************************************
     * Utility Functions
     * @todo These really need to be in another class
     */
    /**

    * Function for grabbing a dynamic sidebar name.
     *
     * @global array   $wp_registered_sidebars
     * @param  string  $sidebar_id
     * @return string
     */
    static function get_sidebar_name( $sidebar_id ) {
        global $wp_registered_sidebars;
        return isset( $wp_registered_sidebars[ $sidebar_id ] ) ? $wp_registered_sidebars[ $sidebar_id ]['name'] : '';
    }

    /**
     * Function for grabbing a WP nav menu theme location name.
     *
     * @param  string  $location
     * @return string
     */
    static function get_menu_location_name( $location ) {

            $locations = get_registered_nav_menus();

            return $locations[ $location ];
    }

    /**
     * Checks if the current post has a mime type of 'audio'.
     *
     * @param  int    $post_id
     * @return bool
     */
    static function attachment_is_audio( $post_id = 0 ) {

        $post_id   = empty( $post_id ) ? get_the_ID() : $post_id;
        $mime_type = get_post_mime_type( $post_id );

        list( $type, $subtype ) = false !== strpos( $mime_type, '/' ) ? explode( '/', $mime_type ) : array( $mime_type, '' );

        return 'audio' === $type ? true : false;
    }

    /**
     * Checks if the current post has a mime type of 'video'.
     *
     * @param  int    $post_id
     * @return bool
     */
    static function attachment_is_video( $post_id = 0 ) {

        $post_id   = empty( $post_id ) ? get_the_ID() : $post_id;
        $mime_type = get_post_mime_type( $post_id );

        list( $type, $subtype ) = false !== strpos( $mime_type, '/' ) ? explode( '/', $mime_type ) : array( $mime_type, '' );

        return 'video' === $type ? true : false;
    }

}


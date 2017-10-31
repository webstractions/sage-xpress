<?php

namespace SageXpress\Schema;

use SageXpress\Providers\AbstractProvider;

class SchemaProvider extends AbstractProvider {


    protected $name='schema';

    /**
     * Gets fired during instantiation of the provider.
     * Use this method for adding actions, filters, registrations
     * or anything else that needs to be setup prior to use.
     *
     * @return void
     */
    public function boot(){

        $this->addFilters();

    }

    /**
     * Register a provider.
     *
     * @return void
     */
    public function register() {
        $this->app->bind('HtmlSchema', \SageXpress\Schema\SchemaFunctions::class);
    }

    /**
     * Add WordPress Filters sorted by context.
     *
     * Devs can filter each filter with an \add_filter().
     *
     * # Schema for major structural elements.
     * SageXpress\Schema\body
     * SageXpress\Schema\header
     * SageXpress\Schema\footer
     * SageXpress\Schema\content
     * SageXpress\Schema\sidebar
     * SageXpress\Schema\menu

     * # Header schema.
     * SageXpress\Schema\head
     * SageXpress\Schema\branding
     * SageXpress\Schema\site-title
     * SageXpress\Schema\site-description

     * # Archive page header schema.
     * SageXpress\Schema\archive-header
     * SageXpress\Schema\archive-title
     * SageXpress\Schema\archive-description

     * # Post-specific schema.
     * SageXpress\Schema\post
     * SageXpress\Schema\entry
     * SageXpress\Schema\entry-title
     * SageXpress\Schema\entry-author
     * SageXpress\Schema\entry-published
     * SageXpress\Schema\entry-content
     * SageXpress\Schema\entry-summary
     * SageXpress\Schema\entry-terms

     * # Comment specific schema.
     * SageXpress\Schema\comment
     * SageXpress\Schema\comment-author
     * SageXpress\Schema\comment-published
     * SageXpress\Schema\comment-permalink
     * SageXpress\Schema\comment-content
     *
     * @return void
     */
    function addFilters() {

        $namespace = "\SageXpress\Schema";
        $class = "\SageXpress\Schema\SchemaFunctions";

        # Schema for major structural elements.
        \add_filter( "sage_schema_body",             [$class,'schema_body'],    5    );
        \add_filter( "sage_schema_header",           [$class,'schema_header'],  5    );
        \add_filter( "sage_schema_footer",           [$class,'schema_footer'],  5    );
        \add_filter( "sage_schema_content",          [$class,'schema_content'], 5    );
        \add_filter( "sage_schema_sidebar",          [$class,'schema_sidebar'], 5, 2 );
        \add_filter( "sage_schema_menu",             [$class,'schema_menu'],    5, 2 );

        # Header schema.
        \add_filter( "sage_schema_head",             [$class,'schema_head'],             5 );
        \add_filter( "sage_schema_branding",         [$class,'schema_branding'],         5 );
        \add_filter( "sage_schema_site-title",       [$class,'schema_site_title'],       5 );
        \add_filter( "sage_schema_site-description", [$class,'schema_site_description'], 5 );

        # Archive page header schema.
        \add_filter( "sage_schema_archive-header",      [$class,'schema_archive_header'],      5 );
        \add_filter( "sage_schema_archive-title",       [$class,'schema_archive_title'],       5 );
        \add_filter( "sage_schema_archive-description", [$class,'schema_archive_description'], 5 );

        # Post-specific schema.
        \add_filter( "sage_schema_post",              [$class,'schema_post'],            5    );
        \add_filter( "sage_schema_entry",             [$class,'schema_post'],            5    ); // Alternate for "post".
        \add_filter( "sage_schema_entry-title",       [$class,'schema_entry_title'],     5    );
        \add_filter( "sage_schema_entry-author",      [$class,'schema_entry_author'],    5    );
        \add_filter( "sage_schema_entry-published",   [$class,'schema_entry_published'], 5    );
        \add_filter( "sage_schema_entry-content",     [$class,'schema_entry_content'],   5    );
        \add_filter( "sage_schema_entry-summary",     [$class,'schema_entry_summary'],   5    );
        \add_filter( "sage_schema_entry-terms",       [$class,'schema_entry_terms'],     5, 2 );

        # Comment specific schema.
        \add_filter( "sage_schema_comment",           [$class,'schema_comment'],           5 );
        \add_filter( "sage_schema_comment-author",    [$class,'schema_comment_author'],    5 );
        \add_filter( "sage_schema_comment-published", [$class,'schema_comment_published'], 5 );
        \add_filter( "sage_schema_comment-permalink", [$class,'schema_comment_permalink'], 5 );
        \add_filter( "sage_schema_comment-content",   [$class,'schema_comment_content'],   5 );
    }
}

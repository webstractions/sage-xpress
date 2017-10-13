## Schema Usage

Based on Justin Tadlock's `hybrid_attr()` functions from older versions of [Hybrid Core](https://github.com/justintadlock/hybrid-core). Justin has since removed the schema.org attributes from the functions and they are resurected here.

This provider is still a work in progress. It is functional, but has quirks. For instance, I am having problems using the `@schema()` directive using `@include` in an already included partial for some reason.

Another quirk is the original `hybrid_attr()` function allowed for a third `$args` parameter array. You are able to pass stuff like `['class'=>'col-med-4 col-sm-12']` and have that rolled into the attributes. Doing something like this using a single Blade string called `$expression` is tough. At any rate, the same thing can be handled via filters.

### Attributes
For the most part, adding schema.org attributes is pretty straight forward. You just add `@schema('slug')` to your Blade files. The slug names can be found in the filters section below.

Some slugs need a little more explanation.

`@schema('body')` for the `<body>` tag automatically joins the `get_body_class()` into the list of classes. It also detects what type of page/post is being displayed and will act accordingly and set `itemtype` to WebPage, Blog, or SearchResultsPage.

Three of the schemas require a second parameter:
- `@schema('sidebar,context')` Where context is the Id of the sidebar
- `@schema('menu,context')` Where context is the Id of the menu
- `@schema('entry-terms,context')` Where context is optional. It can either be `category` or `post_tag` and will add an `itemprop` of 'articleSection' or 'keywords' respectively. If omitted, no itemprop will be defined.

Three of the schemas reveal the fact that the blog is WordPress. If you have any plugins or custom code to hide this fact, you may wish to avoid using them. They are `@schema('header')`, `@schema('footer')`, and `@schema('sidebar')` which adds an `itemstype` of WPHeader, WPFooter, and WPSidebar respectively. Of course, you can add your own filters to change `itemtype` attributes.

### Filters
All filters have a priority of 5 and one argument, except for `sage_schema_sidebar`, `sage_schema_menu`, and `sage_schema_entry-terms`. Those exceptions require a second `$context` argument. For instance `@schema('sidebar, primary')`.

Each filter follows a pattern `sage_schema_{$slug}`. Slugs are hyphenated.

Additionally, there is a second set of matching filters for customizing `class` attributes. They follow a similar pattern `sage_schema_{$slug}_class`

**Schema for major structural elements.**
- `sage_schema_body`
- `sage_schema_header`
- `sage_schema_footer`
- `sage_schema_content`
- `sage_schema_sidebar` (2)
- `sage_schema_menu` (2)

**Header schema.**
- `sage_schema_head`
- `sage_schema_branding`
- `sage_schema_site-title`
- `sage_schema_site-description`

**Archive page header schema.**
- `sage_schema_archive-header`
- `sage_schema_archive-title`
- `sage_schema_archive-description`

**Post-specific schema.**
- `sage_schema_post`
- `sage_schema_entry` (Alias for "post")
- `sage_schema_entry-title`
- `sage_schema_entry-author`
- `sage_schema_entry-published`
- `sage_schema_entry-content`
- `sage_schema_entry-summary`
- `sage_schema_entry-terms` (2)

**Comment specific schema.**
- `sage_schema_comment`
- `sage_schema_comment-author`
- `sage_schema_comment-published`
- `sage_schema_comment-permalink`
- `sage_schema_comment-content`

<?php
namespace SageXpress\Providers;

class CommentsProvider extends AbstractProvider
{
    protected $name = 'comments';

    /**
     * Gets fired during instantiation of the provider.
     * Use this method for adding actions, filters, registrations
     * or anything else that needs to be setup prior to use.
     *
     * @return void
     */
    public function boot() {

        //
    }

    /**
     * Register this provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('sage.comments', function () {
            return new CommentsProvider($this->app);
        });
    }

    /**
     * Register a config path.
     *
     * @return void
     */
    public function registerConfig()
    {
        $this->config = $this->setConfig( $this->name );
    }

    /**
     * Render a registered comment form.
     *
     * @return comment_form()
     */
    public function getCommentFormConfig()
    {
        return $this->config['comment_form'];
    }
}

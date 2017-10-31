<?php
namespace SageXpress\Providers;

use SageXpress\Providers\Traits\ConfigTrait;

class CommentsProvider extends AbstractProvider
{
    protected $name = 'comments';

    use ConfigTrait;

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
     * Get comment form arguments.
     *
     * @return comment_form() $args
     */
    public function getCommentFormConfig()
    {
        return $this->config['comment_form'];
    }
}

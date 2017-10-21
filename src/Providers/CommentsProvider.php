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
    public function renderCommentForm()
    {
        return comment_form( $this->config['comment_form'] );
    }
}

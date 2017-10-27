<?php

namespace SageXpress;

use Roots\Sage\Container;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use SageXpress\Providers\AbstractProvider;

class SageXpress {

    /**
     * The Sage Container instance
     *
     * @var Roots\Sage\Container
     */
    protected $sage;

    /**
     * All of the registered service providers.
     *
     * @var array
     */
    protected $serviceProviders = [];

    /**
     * The names of the loaded service providers.
     *
     * @var array
     */
    protected $loadedProviders = [];

    public function __construct(Container $sage)
    {
        $this->sage = $sage;
    }

    public function bootstrap()
    {
        $this->registerConfiguredProviders();
    }

    /**
     * Register all of the configured providers.
     *
     * @return void
     */
    public function registerConfiguredProviders() {

        $providers = $this->sage->config->get('app.providers');

        foreach($providers as $provider) {
            $this->register($provider);
        }
    }

    /**
     * Register a service provider with the application.
     *
     * @param  \SageXpress\Providers\AbstractProvider|string  $provider
     * @param  array  $options
     * @param  bool   $force
     * @return \SageXpress\Providers\AbstractProvider
     */
    public function register($provider, $options = [], $force = false)
    {
        if (($registered = $this->getProvider($provider)) && ! $force) {
            return $registered;
        }

        // If the given "provider" is a string, we will resolve it, passing in the
        // application instance automatically for the developer. This is simply
        // a more convenient way of specifying your service provider classes.
        if (is_string($provider)) {
            $provider = $this->resolveProvider($provider);
        }

        if (method_exists($provider, 'register')) {
            $provider->register();
        }

        $this->markAsRegistered($provider);

        // If the application has already booted, we will call this boot method on
        // the provider class so it has an opportunity to do its boot logic and
        // will be ready for any usage by this developer's application logic.
        // @todo Determine if the Sage Container has been booted.
        // if ($this->booted) {
            $this->bootProvider($provider);
        // }

        return $provider;
    }

    /**
     * Get the registered service provider instance if it exists.
     *
     * @param  \SageXpress\Providers\AbstractProvider|string  $provider
     * @return \SageXpress\Providers\AbstractProvider|null
     */
    public function getProvider($provider)
    {
        $name = is_string($provider) ? $provider : get_class($provider);

        return Arr::first($this->serviceProviders, function ($value) use ($name) {
            return $value instanceof $name;
        });
    }

    /**
     * Resolve a service provider instance from the class name.
     *
     * @param  string  $provider
     * @return \SageXpress\Providers\AbstractProvider
     */
    public function resolveProvider($provider)
    {
        return new $provider($this->sage);
    }

    /**
     * Mark the given provider as registered.
     *
     * @param  \SageXpress\Providers\AbstractProvider  $provider
     * @return void
     */
    protected function markAsRegistered($provider)
    {
        $this->serviceProviders[] = $provider;

        $this->loadedProviders[get_class($provider)] = true;
    }

    /**
     * Boot the given service provider.
     *
     * @param  \SageXpress\Providers\AbstractProvider  $provider
     * @return mixed
     */
    protected function bootProvider(AbstractProvider $provider)
    {
        if (method_exists($provider, 'boot')) {
            return $this->sage->call([$provider, 'boot']);
        }
    }
}

<?php

namespace Tongues\ServiceProviders;


class Cache extends \tad_DI52_ServiceProvider
{

    /**
     * Binds and sets up implementations.
     */
    public function register()
    {
        $this->container->singleton('Tongues\Interfaces\Cache\ArrayAccessCache', 'Tongues\Cache\Cache');
    }

    /**
     * Binds and sets up implementations at boot time.
     */
    public function boot()
    {
    }
}
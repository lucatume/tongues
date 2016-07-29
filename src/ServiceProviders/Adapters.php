<?php

namespace Tongues\ServiceProviders;


class Adapters extends \tad_DI52_ServiceProvider
{

    /**
     * Binds and sets up implementations.
     */
    public function register()
    {
        $this->container->singleton('wpdb', function () {
            global $wpdb;

            return $wpdb;
        });

        $this->container->singleton('WP_User', function () {
            return wp_get_current_user();
        });

        $this->container->singleton('Tongues\Interfaces\WP\User', 'Tongues\WP\User');
        $this->container->singleton('Tongues\Interfaces\WP\Blogs', 'Tongues\WP\Blogs');
    }

    /**
     * Binds and sets up implementations at boot time.
     */
    public function boot()
    {
    }
}
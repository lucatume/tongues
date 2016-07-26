<?php

namespace Tongues\ServiceProviders;

use Tongues\Interfaces\API\Endpoints\Endpoint;
use Tongues\Interfaces\API\Endpoints\RoutesInformation;

class ApiEndpoints extends \tad_DI52_ServiceProvider
{

    /**
     * Binds and sets up implementations.
     */
    public function register()
    {
        $this->container->bind('Tongues\\Interfaces\\API\\Endpoints\\RoutesInformation', 'Tongues\\API\\Endpoints\\RoutesInformation');

        $this->container->bind('Tongues\\Interfaces\\API\\Handlers\\NetworkSettingsHandler', 'Tongues\\API\\Handlers\\NetworkSettings');
        $this->container->bind('Tongues\\Interfaces\\API\\Endpoints\\NetworkSettingsEndpoint', 'Tongues\\API\\Endpoints\\NetworkSettings');

        $this->container->tag([
            'Tongues\\Interfaces\\API\\Endpoints\\NetworkSettingsEndpoint'
        ], 'endpoints');

        /** @var \Tongues\Interfaces\API\Endpoints\RoutesInformation $routesInformation */
        $routesInformation = $this->container->make('Tongues\\Interfaces\\API\\Endpoints\\RoutesInformation');

        /** @var Endpoint $endpoint */
        foreach ($this->container->tagged('endpoints') as $endpoint) {
            add_action('rest_api_init', function () use ($endpoint) {
                register_rest_route($endpoint->getNamespace(), $endpoint->getRoute(), $endpoint->getArgs());
            });

            $routesInformation->registerEndpoint($endpoint->getSlug(), $endpoint->getRoutePath());
        }
    }

    /**
     * Binds and sets up implementations at boot time.
     */
    public function boot()
    {
    }
}
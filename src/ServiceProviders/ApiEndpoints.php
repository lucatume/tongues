<?php

namespace Tongues\ServiceProviders;

use Tongues\API\Endpoints\EndpointInterface;
use Tongues\API\Endpoints\RoutesInformationInterface;

class ApiEndpoints extends \tad_DI52_ServiceProvider
{

    /**
     * Binds and sets up implementations.
     */
    public function register()
    {
        $this->container->bind('Tongues\\API\\Endpoints\\RoutesInformationInterface', 'Tongues\\API\\Endpoints\\RoutesInformation');

        $this->container->bind('Tongues\\API\\Handlers\\NetworkSettingsHandlerInterface', 'Tongues\\API\\Handlers\\NetworkSettings');
        $this->container->bind('Tongues\\API\\Endpoints\\NetworkSettingsEndpointInterface', 'Tongues\\API\\Endpoints\\NetworkSettings');

        $this->container->tag([
            'Tongues\\API\\Endpoints\\NetworkSettingsEndpointInterface'
        ], 'endpoints');

        /** @var RoutesInformationInterface $routesInformation */
        $routesInformation = $this->container->make('Tongues\\API\\Endpoints\\RoutesInformationInterface');

        /** @var EndpointInterface $endpoint */
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
<?php

namespace Tongues\API\Endpoints;


class RoutesInformation implements RoutesInformationInterface
{

    protected $endpointsInformation = [];

    public function registerEndpoint($slug, $routePath)
    {
        $this->endpointsInformation[$slug] = $routePath;
    }
}
<?php

namespace Tongues\API\Endpoints;

class RoutesInformation implements \Tongues\Interfaces\API\Endpoints\RoutesInformation
{

    protected $endpointsInformation = [];

    public function registerEndpoint($slug, $routePath)
    {
        $this->endpointsInformation[$slug] = $routePath;
    }
}
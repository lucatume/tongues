<?php

namespace Tongues\Interfaces\API\Endpoints;


interface RoutesInformation
{
    public function registerEndpoint($slug, $routePath);
}
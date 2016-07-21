<?php

namespace Tongues\API\Endpoints;


interface RoutesInformationInterface
{

    public function registerEndpoint($slug, $routePath);
}
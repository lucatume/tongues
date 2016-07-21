<?php

namespace Tongues\API\Endpoints;


abstract class AbstractApiV1Endpoint implements EndpointInterface
{

    /**
     * @return string
     */
    public function getNamespace()
    {
        return 'tongues/v1';
    }
}
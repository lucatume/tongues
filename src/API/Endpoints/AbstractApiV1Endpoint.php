<?php

namespace Tongues\API\Endpoints;


use Tongues\Interfaces\API\Endpoints\Endpoint;

abstract class AbstractApiV1Endpoint implements Endpoint
{

    /**
     * @return string
     */
    public function getNamespace()
    {
        return 'tongues/v1';
    }
}
<?php

namespace Tongues\API\Endpoints;


interface EndpointInterface
{

    /**
     * @return string
     */
    public function getNamespace();

    /**
     * @return string
     */
    public function getRoute();

    /**
     * @return array
     */
    public function getArgs();

    /**
     * @return string
     */
    public function getSlug();

    /**
     * @return string
     */
    public function getRoutePath();
}
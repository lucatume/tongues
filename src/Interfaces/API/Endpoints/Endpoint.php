<?php

namespace Tongues\Interfaces\API\Endpoints;


interface Endpoint
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
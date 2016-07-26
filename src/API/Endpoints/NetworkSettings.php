<?php

namespace Tongues\API\Endpoints;

use Tongues\Interfaces\API\Endpoints\NetworkSettingsEndpoint;
use Tongues\Interfaces\API\Handlers\NetworkSettingsHandler;

class NetworkSettings extends AbstractApiV1Endpoint implements NetworkSettingsEndpoint
{

    /**
     * @var NetworkSettingsHandler
     */
    private $handler;

    public function __construct(NetworkSettingsHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return '/network-settings/?';
    }

    /**
     * @return array
     */
    public function getArgs()
    {
        return [
            'methods' => 'POST',
            'callback' => [$this->handler, 'handle']
        ];
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return 'network-settings';
    }

    /**
     * @return string
     */
    public function getRoutePath()
    {
        return $this->getNamespace() . '/network-settings';
    }
}
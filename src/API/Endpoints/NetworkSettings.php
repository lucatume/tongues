<?php

namespace Tongues\API\Endpoints;

use Tongues\API\Handlers\NetworkSettingsHandlerInterface;

class NetworkSettings extends AbstractApiV1Endpoint implements NetworkSettingsEndpointInterface
{

    /**
     * @var NetworkSettingsHandlerInterface
     */
    private $handler;

    public function __construct(NetworkSettingsHandlerInterface $handler)
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
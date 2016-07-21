<?php

namespace Tongues\UI\Admin;


use Tongues\API\Endpoints\RoutesInformationInterface;

class NetworkOptions extends AbstractOptionsPage implements OptionsPageInterface, NetworkOptionsPageInterface
{
    /**
     * @var RoutesInformationInterface
     */
    private $routesInformation;

    public function __construct(RoutesInformationInterface $routesInformation)
    {
        $this->routesInformation = $routesInformation;
    }

    public function render()
    {
        wp_nonce_field($this->getNonceAction(), $this->getNonceField());
    }
}
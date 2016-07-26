<?php

namespace Tongues\UI\Admin;


use Tongues\Interfaces\API\Endpoints\RoutesInformation;
use Tongues\Interfaces\UI\Admin\NetworkOptionsPage;
use Tongues\Interfaces\UI\Admin\OptionsPage;

class NetworkOptions extends AbstractOptionsPage implements OptionsPage, NetworkOptionsPage
{
    /**
     * @var RoutesInformation
     */
    private $routesInformation;

    public function __construct(RoutesInformation $routesInformation)
    {
        $this->routesInformation = $routesInformation;
    }

    public function render()
    {
        wp_nonce_field($this->getNonceAction(), $this->getNonceField());
    }
}
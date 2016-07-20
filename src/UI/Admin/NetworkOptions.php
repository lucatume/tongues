<?php

namespace Tongues\UI\Admin;


class NetworkOptions extends AbstractOptionsPage implements OptionsPageInterface, NetworkOptionsPageInterface {

	protected $nonceAction = 'tongues-network-options';

	public function render() {
		wp_nonce_field( $this->getNonceAction(), $this->getNonceField() );
	}
}
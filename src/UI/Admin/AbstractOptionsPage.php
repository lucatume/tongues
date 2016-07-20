<?php

namespace Tongues\UI\Admin;


abstract class AbstractOptionsPage implements OptionsPageInterface {

	protected $nonceAction = 'tongues';
	protected $nonceField  = 'tongues-nonce';

	abstract public function render();

	public function getNonceAction() {
		return $this->nonceAction;
	}

	public function getNonceField() {
		return $this->nonceField;
	}
}
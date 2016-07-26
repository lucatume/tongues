<?php

namespace Tongues\UI\Admin;


use Tongues\Interfaces\UI\Admin\OptionsPage;

abstract class AbstractOptionsPage implements OptionsPage
{

	protected $nonceAction = 'wp_rest';
	protected $nonceField = 'tongues-nonce';

	abstract public function render();

	public function getNonceAction()
	{
		return $this->nonceAction;
	}

	public function getNonceField()
	{
		return $this->nonceField;
	}
}
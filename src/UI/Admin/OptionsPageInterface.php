<?php

namespace Tongues\UI\Admin;


interface OptionsPageInterface {

	public function render();

	public function getNonceAction();

	public function getNonceField();
}
<?php

namespace Tongues\Interfaces\UI\Admin;


interface OptionsPage
{

	public function render();

	public function getNonceAction();

	public function getNonceField();
}
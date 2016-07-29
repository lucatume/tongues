<?php

namespace Tongues\Interfaces\WP;


interface User
{
    /**
     * @param string $capability
     */
    public function can($capability);
}
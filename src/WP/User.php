<?php

namespace Tongues\WP;


class User implements \Tongues\Interfaces\WP\User
{
    /**
     * @var \WP_User
     */
    protected $user;

    public function __construct(\WP_User $user)
    {
        $this->user = $user;
    }

    /**
     * @param string $capability
     */
    public function can($capability)
    {
        return $this->user->has_cap($capability);
    }
}
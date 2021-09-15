<?php

namespace framework;

use entity\User;

class Session
{
    private ?User $user;

    public function __construct()
    {
        session_start();
        $this->user = isset($_SESSION["user"]) ? unserialize($_SESSION["user"]) : null;
    }

    /**
     * Get the value of user
     */
    public function getUser(): ?User
    {
        return $this->user;
    }
}

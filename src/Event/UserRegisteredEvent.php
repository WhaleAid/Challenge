<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class UserRegisteredEvent extends Event
{
    public const NAME = 'user.registered';

    private $userData;

    public function __construct(array $userData)
    {
        $this->userData = $userData;
    }

    public function getUserData(): array
    {
        return $this->userData;
    }
}
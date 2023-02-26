<?php

namespace App\EventListener;

use App\Event\UserRegisteredEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserRegistrationListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            UserRegisteredEvent::class => 'onUserRegistered',
        ];
    }

    public function onUserRegistered(UserRegisteredEvent $event): void
    {
        // Code à exécuter lorsque l'événement est déclenché
    }
}
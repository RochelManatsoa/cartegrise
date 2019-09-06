<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTAuthenticatedEvent;

class JWTAuthenticatedListener
{
    /**
     * @param JWTAuthenticatedEvent $event
     *
     * @return void
     */
    public function onJWTAuthenticated(JWTAuthenticatedEvent $event)
    {
        $token = $event->getToken();
        $payload = $event->getPayload();

        $token->setAttribute('iat', $payload['iat']);
        $token->setAttribute('exp', $payload['exp']);
    }
}
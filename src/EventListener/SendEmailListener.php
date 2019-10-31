<?php

namespace App\EventListener;

use \Swift_Events_SendListener as base;

class SendEmailListener implements base
{
    /**
     * Invoked immediately before the Message is sent.
     *
     * @param \Swift_Events_SendEvent $evt
     */
    public function beforeSendPerformed(\Swift_Events_SendEvent $evt)
    {
    }

    /**
     * Invoked immediately after the Message is sent.
     *
     * @param \Swift_Events_SendEvent $evt
     */
    public function sendPerformed(\Swift_Events_SendEvent $evt)
    {
        if (\Swift_Events_SendEvent::RESULT_SUCCESS === $evt->getResult()) {
            dump($evt->getMessage());
        }
    }
}
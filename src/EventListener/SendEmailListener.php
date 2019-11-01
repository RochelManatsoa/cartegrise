<?php

namespace App\EventListener;

use \Swift_Events_SendListener as base;
use App\Manager\UserManager;
use App\Entity\EmailHistory;

class SendEmailListener implements base
{
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }
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
            $message = $evt->getMessage();
            $body = $message->getBody();
            $SwiftAdresseTo = $message->getHeaders()->get('To');
            $SwiftAdresseFrom = $message->getHeaders()->get('From');
            $subject = $message->getHeaders()->get('Subject')->getValue();
            $froms = $this->getKeyArray($SwiftAdresseFrom->getNameAddresses());
            $tos = $this->getKeyArray($SwiftAdresseTo->getNameAddresses());
            dump($froms, $tos, $subject, $body);
            foreach($tos as $to){
                $user = $this->userManager->getUserByEmail($to);
                //dump($user);
                $emailHistory = new EmailHistory();
                dump($emailHistory->setSubject($subject)->setBody($body)->setFrom($froms));
                $user->addEmailHistory($emailHistory);
                $this->userManager->save($user);
            }
        }
    }

    private function getKeyArray(array $array){
        $result = [];
        foreach($array as $key=>$value)
            $result[] = $key;
        
        return $result;
    }
}
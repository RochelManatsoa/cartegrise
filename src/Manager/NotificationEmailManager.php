<?php

namespace App\Manager;

use Symfony\Component\HttpFoundation\Session\Session;
use App\Repository\NotificationEmailRepository;
use App\Entity\NotificationEmail;

class NotificationEmailManager
{
    private $repository;

    public function __construct(
        NotificationEmailRepository $repository
    ) {
        $this->repository = $repository;
    }
    
    /**
     * function to get all email of key
     *
     * @param string $key
     * @return array
     */
    public function getAllEmailOf(string $key) :array
    {
        $notificationEmail = $this->repository->findOneBy(['keyConf' => $key]);

        if (!$notificationEmail instanceof NotificationEmail){
            return [];
        }

        return $notificationEmail->getValueConf();
    }

}
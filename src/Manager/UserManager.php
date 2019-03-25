<?php

namespace App\Manager;

use App\Repository\UserRepository;
use App\Entity\User;

class UserManager
{
    private $repository;
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
    public function countDemande(User $user)
    {
        return $this->repository->countDemande($user);
    }
}
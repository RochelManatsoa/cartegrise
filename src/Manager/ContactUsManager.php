<?php

/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-04-17 13:14:01 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-06-22 23:39:49
 */
namespace App\Manager;

use App\Entity\ContactUs as Entity;
use App\Repository\ContactUsRepository as Repository;
use Doctrine\ORM\EntityManagerInterface as EntityManager;

class ContactUsManager
{
    private $repository;
    private $entityManager;
    public function __construct(
        Repository $repository,
        EntityManager $entityManager
    )
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    public function save(Entity $entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
    
}

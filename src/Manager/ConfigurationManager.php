<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-06-12 11:56:04 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-06-12 12:07:57
 */

namespace App\Manager;

use App\Repository\ConfigurationRepository;
use App\Entity\Configuration;
use Doctrine\ORM\EntityManagerInterface;
class ConfigurationManager
{
    private $repository;
    private $entityManagerInterface;
    public function __construct(
        ConfigurationRepository $repository,
        EntityManagerInterface $entityManagerInterface
    )
    {
        $this->repository = $repository;
        $this->entityManagerInterface = $entityManagerInterface;
    }

    public function find(string $key):?Configuration
    {
        return $this->repository->findOneBy(['key'=>$key]);
    }

    public function save(Configuration $configuration)
    {
        $this->entityManagerInterface->persist($configuration);
        $this->entityManagerInterface->flush();
    }

}

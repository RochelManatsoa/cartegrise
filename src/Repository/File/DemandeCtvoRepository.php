<?php

namespace App\Repository\File;

use App\Entity\File\DemandeCtvo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * @method DemandeCtvo|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeCtvo|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeCtvo[]    findAll()
 * @method DemandeCtvo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeCtvoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DemandeCtvo::class);
    }

    // /**
    //  * @return DemandeCtvo[] Returns an array of DemandeCtvo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DemandeCtvo
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

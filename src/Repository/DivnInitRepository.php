<?php

namespace App\Repository;

use App\Entity\DivnInit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * @method DivnInit|null find($id, $lockMode = null, $lockVersion = null)
 * @method DivnInit|null findOneBy(array $criteria, array $orderBy = null)
 * @method DivnInit[]    findAll()
 * @method DivnInit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DivnInitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DivnInit::class);
    }

    // /**
    //  * @return DivnInit[] Returns an array of DivnInit objects
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
    public function findOneBySomeField($value): ?DivnInit
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

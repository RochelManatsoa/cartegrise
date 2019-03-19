<?php

namespace App\Repository;

use App\Entity\InfoSupVeh;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method InfoSupVeh|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfoSupVeh|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfoSupVeh[]    findAll()
 * @method InfoSupVeh[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfoSupVehRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InfoSupVeh::class);
    }

    // /**
    //  * @return InfoSupVeh[] Returns an array of InfoSupVeh objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InfoSupVeh
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

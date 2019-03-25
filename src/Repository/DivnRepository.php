<?php

namespace App\Repository;

use App\Entity\Divn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Divn|null find($id, $lockMode = null, $lockVersion = null)
 * @method Divn|null findOneBy(array $criteria, array $orderBy = null)
 * @method Divn[]    findAll()
 * @method Divn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DivnRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Divn::class);
    }

    // /**
    //  * @return Divn[] Returns an array of Divn objects
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
    public function findOneBySomeField($value): ?Divn
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

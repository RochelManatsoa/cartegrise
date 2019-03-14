<?php

namespace App\Repository;

use App\Entity\TarifsPrestations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TarifsPrestations|null find($id, $lockMode = null, $lockVersion = null)
 * @method TarifsPrestations|null findOneBy(array $criteria, array $orderBy = null)
 * @method TarifsPrestations[]    findAll()
 * @method TarifsPrestations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TarifsPrestationsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TarifsPrestations::class);
    }

    // /**
    //  * @return TarifsPrestations[] Returns an array of TarifsPrestations objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TarifsPrestations
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

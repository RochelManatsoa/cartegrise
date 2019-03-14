<?php

namespace App\Repository;

use App\Entity\Documents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Documents|null find($id, $lockMode = null, $lockVersion = null)
 * @method Documents|null findOneBy(array $criteria, array $orderBy = null)
 * @method Documents[]    findAll()
 * @method Documents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Documents::class);
    }

    public function findByType($value)
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.type','c')
            ->where('c.nom = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findNotMineur($value)
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.type','c')
            ->where('c.nom = :val')
            ->andWhere('a.mineur = true')
            ->andWhere('a.cotitulaire = false')
            ->andWhere('a.societe = false')
            ->andWhere('a.achatProfessionnelAuto = false')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Documents[] Returns an array of Documents objects
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
    public function findOneBySomeField($value): ?Documents
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

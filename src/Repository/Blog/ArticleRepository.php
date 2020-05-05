<?php

namespace App\Repository\Blog;

use App\Entity\Blog\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Manager\Blog\Modele\BlogSearch;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */


    public function findByCatagories($value)
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.categories','c')
            ->where('c.id = :val')
            ->andWhere('a.publication = true')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * blog search
     */
    public function getBlogFilter(BlogSearch $blogSearch)
    {
        if (!$blogSearch->isFilterable())
            return [];
        /**
         * search started
         */
        $builder = $this->createQueryBuilder('a')
        ->where('a.titre like :titre')
        ->andWhere('a.publication = true')
        ->setParameter('titre', '%'.$blogSearch->getTitre().'%');

        return $builder->getQuery()->getResult(); 
    }

}

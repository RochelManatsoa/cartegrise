<?php

namespace App\Manager\Blog;

use App\Entity\Blog\{Article, Categorie, Commentaire};
use App\Repository\Blog\{ArticleRepository, CategorieRepository, CommentaireRepository, FaqRepository};
use Doctrine\Common\Persistence\ObjectManager;

class BlogManager
{
    private $aricle;
    private $categorie;
    private $faq;
    private $em;

    public function __construct(
        ArticleRepository $article,
        CategorieRepository $categorie,
        FaqRepository $faq,
        ObjectManager $em
    )
    {
        $this->article   = $article;
        $this->categorie = $categorie;
        $this->faq       = $faq;
        $this->em        = $em;
    }

    public function getCatAndFaq()
    {
        $recent = $this->article->findBy([], ['id'=>'DESC'], 5);
        $categories = $this->categorie->findAll();
        $faqs = $this->faq->findBy([], ['id'=>'DESC'], 3,rand(0,5));

        return [
            'recent'=>$recent,
            'cat'=>$categories,
            'faqs'=>$faqs
        ];
    }

    public function findArticleSimilaire(Article $article)
    {
        return $this->article->findBy(
            ['auteur'=>$article->getAuteur()],
            ['date'=>'DESC'],
            4,rand(0,50)
        );
    }

    public function findPreviousPost(Article $article)
    {
        return $this->article->findById($article->getId()-1);
    }

    public function findNextPost(Article $article)
    {
        return $this->article->findById($article->getId()+1);
    }

    public function save(Commentaire $comment)
    {
        $this->em->persist($comment);
        $this->em->flush();
    }
}

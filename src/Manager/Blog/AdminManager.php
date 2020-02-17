<?php

namespace App\Manager\Blog;

use App\Entity\Blog\Article;
use App\Repository\Blog\{ArticleRepository, CommentaireRepository, CategorieRepository, FaqRepository, UserRepository};
use Doctrine\Common\Persistence\ObjectManager;

class AdminManager
{
    public function __construct(
        ArticleRepository $article, 
        CommentaireRepository $comment,
        CategorieRepository $category, 
        UserRepository $user,
        FaqRepository $faq,        
        ObjectManager $manager
    )
    {
        $this->article = $article;
        $this->comment = $comment;
        $this->category = $category;
        $this->user = $user;
        $this->faq = $faq;
        $this->manager = $manager;
    }

    public function getParamsWithoutComment()
    {
        $articles = $this->article->findAll();
        $categories = $this->category->findAll();
        $users = $this->user->findAll();
        $faqs = $this->faq->findAll();

        return [
            'categories'=>$categories,
            'articles'=>$articles,
            'users'=>$users,
            'faqs'=>$faqs,
        ];
    }

    public function getParamsWithoutArticle()
    {
        $commentaires = $this->comment->findAll();
        $categories = $this->category->findAll();
        $users = $this->user->findAll();
        $faqs = $this->faq->findAll();

        return [
            'categories'=>$categories,
            'commentaires'=>$commentaires,
            'users'=>$users,
            'faqs'=>$faqs,
        ];
    }

    public function save(Article $article)
    {
        $this->manager->persist($article);
        $this->manager->flush();
    }

    public function delete(Article $article)
    {
        $this->manager->remove($article);
        $this->manager->flush();
    }
}

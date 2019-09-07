<?php

namespace App\Controller\Blog;

use App\Entity\Blog\{Article, Categorie, Commentaire};
use App\Form\Blog\CommentaireType;
use App\Manager\Blog\BlogManager;
use App\Repository\Blog\{ArticleRepository, CategorieRepository, FaqRepository};
use Doctrine\Common\Persistence\ObjectManager;
use http\Env\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends Controller
{
    /**
     * @Route("/", name="blog")
     */
    public function index(
        ArticleRepository $repository,
        BlogManager $blogManager,
        Request $request
    )
    {
        $repo = $repository->findBy(
                ['publication' => true],
                ['date' => 'DESC']
            );
        // @var $paginator \Knp\Component\Pager\Paginator 
        $paginator = $this->get('knp_paginator');
        $articles = $paginator->paginate(
            $repo, $request->query->getInt('page', 1), 4
            );
        $params = $blogManager->getCatAndFaq();
        $params = array_merge(['articles'=>$articles], $params);

        return $this->render('blog/index.html.twig', $params);
    }

    /**
     * @Route("/{slug}", name="blog_show")
     */
    public function show(
        Article $article, 
        Request $request, 
        BlogManager $blogManager
    )
    {
        $post = $blogManager->findArticleSimilaire($article);
        $comment = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $comment);

        $params = $blogManager->getCatAndFaq();
        $params = array_merge(['prev'=>$blogManager->findPreviousPost($article)], $params);
        $params = array_merge(['next'=>$blogManager->findNextPost($article)], $params);
        $params = array_merge(['post'=>$post], $params);
        $params = array_merge(['recentPost'=> 'recentPost'], $params);
        $params = array_merge(['article'=>$article], $params);
        $params = array_merge(['formComment'=>$form->createView()], $params);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comment->setDate(new \DateTime())
                    ->setArticle($article)
                    ->setPublication(false);
            $blogManager->save($comment);
            $this->addFlash('success', 'Votre commentaire à bien été enregistré.');
            $params = array_merge(['slug'=>$article->getSlug()], $params);

            return $this->redirectToRoute('blog_show', $params);
        }
        
        return $this->render('blog/show.html.twig', $params);
    }

    /**
     * @Route("/categorie/{slug}", name="show_cat")
     */
    public function showCat(
        Categorie $categorie, 
        ArticleRepository $repository, 
        Request $request,
        BlogManager $blogManager)
    {
        $repo = $repository->findByCatagories($categorie->getId());
        /* @var $paginator \Knp\Component\Pager\Paginator */
        $paginator = $this->get('knp_paginator');
        $articles = $paginator->paginate(
            $repo, $request->query->getInt('page', 1), 4
        );
        $params = $blogManager->getCatAndFaq();
        $params = array_merge(['articles'=>$articles], $params);
        $params = array_merge(['categorie'=>$categorie], $params);
        
        return $this->render('blog/categorie.html.twig', $params);
    }

}
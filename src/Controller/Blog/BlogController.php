<?php

namespace App\Controller\Blog;

use App\Entity\Blog\{Article, Categorie, Commentaire};
use App\Form\Blog\{CommentaireType, BlogSearchType};
use App\Manager\Blog\{BlogManager, SearchManager};
use App\Manager\Blog\Modele\BlogSearch;
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
            Blogmanager $blogManager,
            Request $request,
            SearchManager $searchManager
        )
    {
        $repo = $repository->findBy(
                ['publication' => true],
                ['date' => 'DESC']
            );
        // @var $paginator \Knp\Component\Pager\Paginator 
        $search = new BlogSearch();
        $formSearch = $this->createForm(BlogSearchType::class, $search);
        $paginator = $this->get('knp_paginator');
        $articles = $paginator->paginate(
            $repo, $request->query->getInt('page', 1), 6
            );
        $params = $blogManager->getCatAndFaq();
        $params = array_merge(['articles'=>$articles], $params);
        $params = array_merge(['formSearch'=>$formSearch->createView()], $params);
        $formSearch->handleRequest($request);
        if($formSearch->isSubmitted() && $formSearch->isValid()){
            $search = $formSearch->getData();
            $results = $searchManager->search($search);
            $params = array_merge(['results'=>$results], $params);

            return $this->render('blog/result.html.twig', $params);
        }

        return $this->render('blog/index.html.twig', $params);
    }

    /**
     * @Route("/{slug}", name="blog_show")
     */
    public function show(
        Article $article, 
        Request $request, 
        BlogManager $blogManager,
        SearchManager $searchManager
    )
    {
        $post = $blogManager->findArticleSimilaire($article);
        $comment = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $comment);
        $search = new BlogSearch();
        $formSearch = $this->createForm(BlogSearchType::class, $search);

        $params = $blogManager->getCatAndFaq();
        $params = array_merge(['prev'=>$blogManager->findPreviousPost($article)], $params);
        $params = array_merge(['next'=>$blogManager->findNextPost($article)], $params);
        $params = array_merge(['post'=>$post], $params);
        $params = array_merge(['recentPost'=> 'recentPost'], $params);
        $params = array_merge(['article'=>$article], $params);
        $params = array_merge(['formComment'=>$form->createView()], $params);
        $params = array_merge(['formSearch'=>$formSearch->createView()], $params);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comment->setDate(new \DateTime())
                    ->setArticle($article)
                    ->setPublication(false);
            $blogManager->save($comment);
            $this->addFlash('success', 'Votre commentaire à bien été enregistré.');
            $params = array_merge(['slug'=>$article->getSlug()], $params);

            return $this->redirectToRoute('blog_show', ['slug'=>$article->getSlug()]);
        }
        $formSearch->handleRequest($request);
        if($formSearch->isSubmitted() && $formSearch->isValid()){
            $search = $formSearch->getData();
            $results = $searchManager->search($search);
            $params = array_merge(['results'=>$results], $params);

            return $this->render('blog/result.html.twig', $params);
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
        BlogManager $blogManager,
        SearchManager $searchManager)
    {
        $repo = $repository->findByCatagories($categorie->getId());
        $search = new BlogSearch();
        $formSearch = $this->createForm(BlogSearchType::class, $search);
        /* @var $paginator \Knp\Component\Pager\Paginator */
        $paginator = $this->get('knp_paginator');
        $articles = $paginator->paginate(
            $repo, $request->query->getInt('page', 1), 6
        );
        $params = $blogManager->getCatAndFaq();
        $params = array_merge(['articles'=>$articles], $params);
        $params = array_merge(['categorie'=>$categorie], $params);
        $params = array_merge(['formSearch'=>$formSearch->createView()], $params);
        $formSearch->handleRequest($request);
        if($formSearch->isSubmitted() && $formSearch->isValid()){
            $search = $formSearch->getData();
            $results = $searchManager->search($search);
            $params = array_merge(['results'=>$results], $params);

            return $this->render('blog/result.html.twig', $params);
        }
        
        return $this->render('blog/categorie.html.twig', $params);
    }
                
}

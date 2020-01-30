<?php

namespace App\Manager\Blog;

use App\Manager\Blog\Modele\BlogSearch;
use App\Repository\Blog\ArticleRepository;

class SearchManager
{
    private $articleRepository;
    public function __construct(
        ArticleRepository $articleRepository
    )
    {
        $this->articleRepository = $articleRepository;
    }

    public function Search(BlogSearch $blogSearch)
    {
        
        return $this->articleRepository->getBlogFilter($blogSearch);
    }
}
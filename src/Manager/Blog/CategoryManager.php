<?php

namespace App\Manager\Blog;

use App\Entity\Blog\{Categorie, Faq};
use App\Repository\Blog\{CategorieRepository, FaqRepository};
use Doctrine\Common\Persistence\ObjectManager;

class CategoryManager
{
    private $em;
    private $categorieRepo;
    private $facRepo;

    public function __construct(
        ObjectManager $em,
        CategorieRepository $categorieRepo,
        FaqRepository $faqRepo
    )
    {
        $this->em            = $em;
        $this->categorieRepo = $categorieRepo;
        $this->faqRepo       = $faqRepo;
    }

    public function getCategory()
    {
        return ['categories'=>$this->categorieRepo->findAll()];
    }

    public function getFaqs()
    {
        return ['faqs'=>$this->faqRepo->findAll()];
    }

    public function save(Category $categorie)
    {
        $this->em->persist($categorie);
        $this->em->flush();
    }

    public function saveFaq(Faq $faq)
    {
        $this->em->persist($faq);
        $this->em->flush();
    }

    public function deleteFaq(Faq $faq)
    {
        $this->em->remove($faq);
        $this->em->flush();
    }

    public function deleteCategory(Categorie $categorie)
    {
        $this->em->remove($categorie);
        $this->em->flush();
    }
}
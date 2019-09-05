<?php

namespace App\Entity\Blog;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Blog\ImageRepository")
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $textAlternatif;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Blog\Article", inversedBy="image", cascade={"persist", "remove"})
     */
    private $article;

    public function __toString() {
        return $this->url;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getTextAlternatif(): ?string
    {
        return $this->textAlternatif;
    }

    public function setTextAlternatif(?string $textAlternatif): self
    {
        $this->textAlternatif = $textAlternatif;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }
}
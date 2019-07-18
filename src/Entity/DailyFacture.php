<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdresseRepository")
 */
class DailyFacture
{
    const DOC_DOWNLOAD = 'document/dailyFacture/';
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull( message="Ce champs est requis")
     */
    private $dateCreate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getDateCreate(): ?string
    {
        return $this->dateCreate;
    }

    public function setDateCreate(string $dateCreate): self
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    public function getDailyFacturePath(): ?string
    {

        return $this::DOC_DOWNLOAD;
    }
    public function getDailyFacturePathFile($now): ?string
    {

        return $this::DOC_DOWNLOAD.'/'.$now->format('Ymd').'.pdf';
    }

}

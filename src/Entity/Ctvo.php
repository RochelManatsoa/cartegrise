<?php

namespace App\Entity;

use App\Entity\File\DemandeCtvo;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class Ctvo
{
    const CI_OK = 0;
    const CI_KO = 1;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Demande", inversedBy="ctvo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $demande;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Ancientitulaire", inversedBy="ctvo", cascade={"persist", "remove"})
     */
    private $ancienTitulaire;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\NewTitulaire", inversedBy="ctvo", cascade={"persist", "remove"})
     */
    private $acquerreur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cotitulaires", mappedBy="ctvo", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $cotitulaire;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\File\DemandeCtvo", inversedBy="ctvo", cascade={"persist", "remove"})
     */
    private $file;

    /**
     * @ORM\Column(type= "string", nullable=true)
     */
    private $ciPresent;

    /**
     * numeroFormule variable
     * @ORM\Column(nullable=true)
     * @var string
     */
    private $numeroFormule;

    /**
     * @ORM\Column(type= "datetime", nullable=true)
     */
    private $dateCi;

    public function __construct()
    {
        $this->cotitulaire = new ArrayCollection();
    }

    public function getCotitulaire()
    {
        return $this->cotitulaire;
    }

    public function getDemande(): ?Demande
    {
        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        $this->demande = $demande;

        return $this;
    }

    public function getAncienTitulaire(): ?Ancientitulaire
    {
        return $this->ancienTitulaire;
    }

    public function setAncienTitulaire(?Ancientitulaire $ancienTitulaire): self
    {
        $this->ancienTitulaire = $ancienTitulaire;

        return $this;
    }

    public function getAcquerreur(): ?NewTitulaire
    {
        return $this->acquerreur;
    }

    public function setAcquerreur(?NewTitulaire $acquerreur): self
    {
        $this->acquerreur = $acquerreur;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function addCotitulaire(Cotitulaires $cotitulaire): self
    {
        if (!$this->cotitulaire->contains($cotitulaire)) {
            $this->cotitulaire[] = $cotitulaire;
            $cotitulaire->setCtvo($this);
        }

        return $this;
    }

    public function removeCotitulaire(Cotitulaires $cotitulaire): self
    {
        if ($this->cotitulaire->contains($cotitulaire)) {
            $this->cotitulaire->removeElement($cotitulaire);
            // set the owning side to null (unless already changed)
            if ($cotitulaire->getCtvo() === $this) {
                $cotitulaire->setCtvo(null);
            }
        }

        return $this;
    }

    public function countCotitulaire()
    {
        return count($this->cotitulaire);
    }

    public function getFile(): ?DemandeCtvo
    {
        return $this->file;
    }

    public function setFile(?DemandeCtvo $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getCiPresent(): ?string
    {
        return $this->ciPresent;
    }

    public function setCiPresent(?string $ciPresent): self
    {
        $this->ciPresent = $ciPresent;

        return $this;
    }

    public function getNumeroFormule(): ?string
    {
        return $this->numeroFormule;
    }

    public function setNumeroFormule(?string $numeroFormule): self
    {
        $this->numeroFormule = $numeroFormule;

        return $this;
    }

    public function getDateCi(): ?\DateTimeInterface
    {
        return $this->dateCi;
    }

    public function setDateCi(?\DateTimeInterface $dateCi): self
    {
        $this->dateCi = $dateCi;

        return $this;
    }

}
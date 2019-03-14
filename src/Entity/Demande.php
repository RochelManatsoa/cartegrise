<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DemandeRepository")
 */
class Demande
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
    private $typeDemande;

    /**
     * @ORM\Column(type="boolean")
     */
    private $opposeDemande;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="demandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=999)
     */
    private $statutDemande;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $paiementDemande;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $TmsIdDemande;

    /**
     * @ORM\Column(type="string", length=999, nullable=true)
     */
    private $progressionDemande;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateDemande;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomfic;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fichier", mappedBy="demande")
     */
    private $fichiers;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\NewTitulaire", inversedBy="demande", cascade={"persist", "remove"})
     */
    private $Acquerreur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeDemande", inversedBy="demandes")
     */
    private $nomDemande;

    public function __toString()
    {
        return $this->typeDemande;
    }

    public function __construct()
    {
        $this->fichiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeDemande(): ?string
    {
        return $this->typeDemande;
    }

    public function setTypeDemande(string $typeDemande): self
    {
        $this->typeDemande = $typeDemande;

        return $this;
    }

    public function getOpposeDemande(): ?bool
    {
        return $this->opposeDemande;
    }

    public function setOpposeDemande(bool $opposeDemande): self
    {
        $this->opposeDemande = $opposeDemande;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getStatutDemande(): ?string
    {
        return $this->statutDemande;
    }

    public function setStatutDemande(string $statutDemande): self
    {
        $this->statutDemande = $statutDemande;

        return $this;
    }

    public function getPaiementDemande(): ?string
    {
        return $this->paiementDemande;
    }

    public function setPaiementDemande(string $paiementDemande): self
    {
        $this->paiementDemande = $paiementDemande;

        return $this;
    }

    public function getTmsIdDemande(): ?int
    {
        return $this->TmsIdDemande;
    }

    public function setTmsIdDemande(?int $TmsIdDemande): self
    {
        $this->TmsIdDemande = $TmsIdDemande;

        return $this;
    }

    public function getProgressionDemande(): ?string
    {
        return $this->progressionDemande;
    }

    public function setProgressionDemande(?string $progressionDemande): self
    {
        $this->progressionDemande = $progressionDemande;

        return $this;
    }

    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->dateDemande;
    }

    public function setDateDemande(?\DateTimeInterface $dateDemande): self
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getNomfic(): ?string
    {
        return $this->nomfic;
    }

    public function setNomfic(?string $nomfic): self
    {
        $this->nomfic = $nomfic;

        return $this;
    }

    /**
     * @return Collection|Fichier[]
     */
    public function getFichiers(): Collection
    {
        return $this->fichiers;
    }

    public function addFichier(Fichier $fichier): self
    {
        if (!$this->fichiers->contains($fichier)) {
            $this->fichiers[] = $fichier;
            $fichier->setDemande($this);
        }

        return $this;
    }

    public function removeFichier(Fichier $fichier): self
    {
        if ($this->fichiers->contains($fichier)) {
            $this->fichiers->removeElement($fichier);
            // set the owning side to null (unless already changed)
            if ($fichier->getDemande() === $this) {
                $fichier->setDemande(null);
            }
        }

        return $this;
    }

    public function getAcquerreur(): ?NewTitulaire
    {
        return $this->Acquerreur;
    }

    public function setAcquerreur(?NewTitulaire $Acquerreur): self
    {
        $this->Acquerreur = $Acquerreur;

        return $this;
    }

    public function getNomDemande(): ?TypeDemande
    {
        return $this->nomDemande;
    }

    public function setNomDemande(?TypeDemande $nomDemande): self
    {
        $this->nomDemande = $nomDemande;

        return $this;
    }
}

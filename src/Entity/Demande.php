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
     * @ORM\Column(type="boolean",nullable=true, options={"default" : true})
     */
    private $opposeDemande;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commande", inversedBy="demandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;

    /**
     * @ORM\Column(type="string", length=999, nullable=true)
     */
    private $statutDemande;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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
     * @ORM\OneToOne(targetEntity="App\Entity\Ctvo", inversedBy="demande", cascade={"persist", "remove"})
     */
    private $ctvo;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Duplicata", inversedBy="demande", cascade={"persist", "remove"})
     */
    private $duplicata;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Divn", mappedBy="demande", cascade={"persist", "remove"})
     */
    private $divn;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Cession", mappedBy="demande", cascade={"persist", "remove"})
     */
    private $cession;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ChangementAdresse", inversedBy="demande", cascade={"persist", "remove"})
     */
    private $changementAdresse;

    public function __toString()
    {
        // return $this->typeDemande;
    }

    public function __construct()
    {
        $this->fichiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
    
    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getCtvo(): ?Ctvo
    {
        return $this->ctvo;
    }

    public function setCtvo(?Ctvo $ctvo): self
    {
        $this->ctvo = $ctvo;

        return $this;
    }

    public function getDuplicata(): ?Duplicata
    {
        return $this->duplicata;
    }

    public function setDuplicata(?Duplicata $duplicata): self
    {
        $this->duplicata = $duplicata;

        return $this;
    }

    public function getDivn(): ?Divn
    {
        return $this->divn;
    }

    public function setDivn(?Divn $divn): self
    {
        $this->divn = $divn;

        // set (or unset) the owning side of the relation if necessary
        $newDemande = $divn === null ? null : $this;
        if ($newDemande !== $divn->getDemande()) {
            $divn->setDemande($newDemande);
        }

        return $this;
    }

    public function getCession(): ?Cession
    {
        return $this->cession;
    }

    public function setCession(?Cession $cession): self
    {
        $this->cession = $cession;

        // set (or unset) the owning side of the relation if necessary
        $newDemande = $cession === null ? null : $this;
        if ($newDemande !== $cession->getDemande()) {
            $cession->setDemande($newDemande);
        }

        return $this;
    }

    public function getChangementAdresse(): ?ChangementAdresse
    {
        return $this->changementAdresse;
    }

    public function setChangementAdresse(?ChangementAdresse $changementAdresse): self
    {
        $this->changementAdresse = $changementAdresse;

        return $this;
    }
}

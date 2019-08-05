<?php

namespace App\Entity;

use App\Entity\File\DemandeImmatriculationVehiculeNeuf;
use App\Entity\File\DemandeIvn;
use App\Entity\Vehicule\VehiculeNeuf;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DivnRepository")
 */
class Divn
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Demande", inversedBy="divn", cascade={"persist", "remove"})
     */
    private $demande;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\NewTitulaire",inversedBy="divn", cascade={"persist", "remove"})
     */
    private $acquerreur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cotitulaires", mappedBy="divn", cascade={"persist"})
     */
    private $cotitulaire;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\File\DemandeIvn", inversedBy="divn", cascade={"persist", "remove"})
     */
    private $file;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Vehicule\VehiculeNeuf", inversedBy="divn", cascade={"persist", "remove"})
     */
    private $vehicule;

    public function __construct()
    {
        $this->cotitulaire = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getAcquerreur(): ?NewTitulaire
    {
        return $this->acquerreur;
    }

    public function setAcquerreur(?NewTitulaire $acquerreur): self
    {
        $this->acquerreur = $acquerreur;

        return $this;
    }

    /**
     * @return Collection|Cotitulaires[]
     */
    public function getCotitulaire(): Collection
    {
        return $this->cotitulaire;
    }

    public function addCotitulaire(Cotitulaires $cotitulaire): self
    {
        if (!$this->cotitulaire->contains($cotitulaire)) {
            $this->cotitulaire[] = $cotitulaire;
            $cotitulaire->setDivn($this);
        }

        return $this;
    }

    public function removeCotitulaire(Cotitulaires $cotitulaire): self
    {
        if ($this->cotitulaire->contains($cotitulaire)) {
            $this->cotitulaire->removeElement($cotitulaire);
            // set the owning side to null (unless already changed)
            if ($cotitulaire->getDivn() === $this) {
                $cotitulaire->setDivn(null);
            }
        }

        return $this;
    }

    public function getFile(): ?DemandeIvn
    {
        return $this->file;
    }

    public function setFile(?DemandeIvn $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getVehicule(): ?VehiculeNeuf
    {
        return $this->vehicule;
    }

    public function setVehicule(?VehiculeNeuf $vehicule): self
    {
        $this->vehicule = $vehicule;

        return $this;
    }
}

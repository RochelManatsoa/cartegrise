<?php

namespace App\Entity;

use App\Entity\File\DemandeImmatriculationVehiculeNeuf;
use App\Entity\File\DemandeIvn;
use App\Entity\Vehicule\CaracteristiqueTechVehiculeNeuf;
use App\Entity\Vehicule\CarrosierVehiculeNeuf;
use App\Entity\Vehicule\VehiculeNeuf;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DivnRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
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
     * @ORM\OneToOne(targetEntity="App\Entity\Vehicule\CarrosierVehiculeNeuf", inversedBy="divn", cascade={"persist", "remove"})
     */
    private $carrosier;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vehicule\CaracteristiqueTechVehiculeNeuf", mappedBy="divn", cascade={"persist"})
     */
    private $caractTech;


    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Demande", inversedBy="divn", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
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

    /**
     * @var \DateTime $deletedAt
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;
    

    public function __construct()
    {
        $this->cotitulaire = new ArrayCollection();
        $this->caracteristiqueTechniquePart = new ArrayCollection();
        $this->caractTech = new ArrayCollection();
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

    public function getCarrosier(): ?CarrosierVehiculeNeuf
    {
        return $this->carrosier;
    }

    public function setCarrosier(?CarrosierVehiculeNeuf $carrosier): self
    {
        $this->carrosier = $carrosier;

        return $this;
    }

    /**
     * @return Collection|CaracteristiqueTechVehiculeNeuf[]
     */
    public function getCaractTech(): Collection
    {
        return $this->caractTech;
    }

    public function addCaractTech(CaracteristiqueTechVehiculeNeuf $caractTech): self
    {
        if (!$this->caractTech->contains($caractTech)) {
            $this->caractTech[] = $caractTech;
            $caractTech->setDivn($this);
        }

        return $this;
    }

    public function removeCaractTech(CaracteristiqueTechVehiculeNeuf $caractTech): self
    {
        if ($this->caractTech->contains($caractTech)) {
            $this->caractTech->removeElement($caractTech);
            // set the owning side to null (unless already changed)
            if ($caractTech->getDivn() === $this) {
                $caractTech->setDivn(null);
            }
        }

        return $this;
    }

    public function countCotitulaire()
    {
        return count($this->cotitulaire);
    }

    public function countCaractTech()
    {
        return count($this->caractTech);
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}

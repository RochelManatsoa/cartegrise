<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartegriseRepository")
 */
class Cartegrise
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typevehicule;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cgdepartement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $modele;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $energie;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cv;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datecirculation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $co2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ptac;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cotitulaires", mappedBy="carteGrise")
     */
    private $cotitulaires;

    public function __construct()
    {
        $this->cotitulaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypevehicule(): ?string
    {
        return $this->typevehicule;
    }

    public function setTypevehicule(string $typevehicule): self
    {
        $this->typevehicule = $typevehicule;

        return $this;
    }

    public function getCgdepartement(): ?string
    {
        return $this->cgdepartement;
    }

    public function setCgdepartement(string $cgdepartement): self
    {
        $this->cgdepartement = $cgdepartement;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getEnergie(): ?string
    {
        return $this->energie;
    }

    public function setEnergie(string $energie): self
    {
        $this->energie = $energie;

        return $this;
    }

    public function getCv(): ?int
    {
        return $this->cv;
    }

    public function setCv(int $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getDatecirculation(): ?\DateTimeInterface
    {
        return $this->datecirculation;
    }

    public function setDatecirculation(\DateTimeInterface $datecirculation): self
    {
        $this->datecirculation = $datecirculation;

        return $this;
    }

    public function getCo2(): ?int
    {
        return $this->co2;
    }

    public function setCo2(int $co2): self
    {
        $this->co2 = $co2;

        return $this;
    }

    public function getPtac(): ?int
    {
        return $this->ptac;
    }

    public function setPtac(int $ptac): self
    {
        $this->ptac = $ptac;

        return $this;
    }

    /**
     * @return Collection|Cotitulaires[]
     */
    public function getCotitulaires(): Collection
    {
        return $this->cotitulaires;
    }

    public function addCotitulaire(Cotitulaires $cotitulaire): self
    {
        if (!$this->cotitulaires->contains($cotitulaire)) {
            $this->cotitulaires[] = $cotitulaire;
            $cotitulaire->setCarteGrise($this);
        }

        return $this;
    }

    public function removeCotitulaire(Cotitulaires $cotitulaire): self
    {
        if ($this->cotitulaires->contains($cotitulaire)) {
            $this->cotitulaires->removeElement($cotitulaire);
            // set the owning side to null (unless already changed)
            if ($cotitulaire->getCarteGrise() === $this) {
                $cotitulaire->setCarteGrise(null);
            }
        }

        return $this;
    }
}

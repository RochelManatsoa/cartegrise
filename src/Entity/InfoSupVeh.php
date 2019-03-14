<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InfoSupVehRepository")
 */
class InfoSupVeh
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
    private $marque;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reception;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $maxtechadmkg;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $maxekatelagekg;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $poidsvide;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $categoriece;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $genrece;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $carrosserie;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pfiscale;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Vehicule", mappedBy="infosup", cascade={"persist", "remove"})
     */
    private $vehicule;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(?string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getReception(): ?string
    {
        return $this->reception;
    }

    public function setReception(?string $reception): self
    {
        $this->reception = $reception;

        return $this;
    }

    public function getMaxtechadmkg(): ?float
    {
        return $this->maxtechadmkg;
    }

    public function setMaxtechadmkg(?float $maxtechadmkg): self
    {
        $this->maxtechadmkg = $maxtechadmkg;

        return $this;
    }

    public function getMaxekatelagekg(): ?float
    {
        return $this->maxekatelagekg;
    }

    public function setMaxekatelagekg(?float $maxekatelagekg): self
    {
        $this->maxekatelagekg = $maxekatelagekg;

        return $this;
    }

    public function getPoidsvide(): ?float
    {
        return $this->poidsvide;
    }

    public function setPoidsvide(?float $poidsvide): self
    {
        $this->poidsvide = $poidsvide;

        return $this;
    }

    public function getCategoriece(): ?string
    {
        return $this->categoriece;
    }

    public function setCategoriece(?string $categoriece): self
    {
        $this->categoriece = $categoriece;

        return $this;
    }

    public function getGenrece(): ?string
    {
        return $this->genrece;
    }

    public function setGenrece(?string $genrece): self
    {
        $this->genrece = $genrece;

        return $this;
    }

    public function getCarrosserie(): ?string
    {
        return $this->carrosserie;
    }

    public function setCarrosserie(?string $carrosserie): self
    {
        $this->carrosserie = $carrosserie;

        return $this;
    }

    public function getPfiscale(): ?int
    {
        return $this->pfiscale;
    }

    public function setPfiscale(?int $pfiscale): self
    {
        $this->pfiscale = $pfiscale;

        return $this;
    }

    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicule $vehicule): self
    {
        $this->vehicule = $vehicule;

        // set (or unset) the owning side of the relation if necessary
        $newInfosup = $vehicule === null ? null : $this;
        if ($newInfosup !== $vehicule->getInfosup()) {
            $vehicule->setInfosup($newInfosup);
        }

        return $this;
    }
}

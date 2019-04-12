<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehiculeInfoRepository")
 */
class VehiculeInfo
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
    private $immatriculation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $carrosserie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $carrosserieCG;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $co2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $consoExurb;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cylindree;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couleur;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateMec;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCG;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $energie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $marque;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $modele;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nSerie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Vehicule", inversedBy="vehiculeInfo", cascade={"persist", "remove"})
     */
    private $vehicule;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(?string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getVin(): ?string
    {
        return $this->vin;
    }

    public function setVin(?string $vin): self
    {
        $this->vin = $vin;

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

    public function getCarrosserieCG(): ?string
    {
        return $this->carrosserieCG;
    }

    public function setCarrosserieCG(?string $carrosserieCG): self
    {
        $this->carrosserieCG = $carrosserieCG;

        return $this;
    }

    public function getCo2(): ?int
    {
        return $this->co2;
    }

    public function setCo2(?int $co2): self
    {
        $this->co2 = $co2;

        return $this;
    }

    public function getConsoExurb(): ?int
    {
        return $this->consoExurb;
    }

    public function setConsoExurb(?int $consoExurb): self
    {
        $this->consoExurb = $consoExurb;

        return $this;
    }

    public function getCylindree(): ?float
    {
        return $this->cylindree;
    }

    public function setCylindree(?float $cylindree): self
    {
        $this->cylindree = $cylindree;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getDateMec(): ?\DateTimeInterface
    {
        return $this->dateMec;
    }

    public function setDateMec(?\DateTimeInterface $dateMec): self
    {
        $this->dateMec = $dateMec;

        return $this;
    }

    public function getDateCG(): ?\DateTimeInterface
    {
        return $this->dateCG;
    }

    public function setDateCG(?\DateTimeInterface $dateCG): self
    {
        $this->dateCG = $dateCG;

        return $this;
    }

    public function getEnergie(): ?string
    {
        return $this->energie;
    }

    public function setEnergie(?string $energie): self
    {
        $this->energie = $energie;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
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

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(?string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getNSerie(): ?string
    {
        return $this->nSerie;
    }

    public function setNSerie(?string $nSerie): self
    {
        $this->nSerie = $nSerie;

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

    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicule $vehicule): self
    {
        $this->vehicule = $vehicule;

        return $this;
    }
}

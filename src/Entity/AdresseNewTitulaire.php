<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdresseNewTitulaireRepository")
 */
class AdresseNewTitulaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numeroRue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $extension;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adprecision;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typevoie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomvoie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $complement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieudit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codepostal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $boitepostal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pays;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\NewTitulaire", inversedBy="adresseNewTitulaire", cascade={"persist", "remove"})
     */
    private $titulaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroRue(): ?int
    {
        return $this->numeroRue;
    }

    public function setNumeroRue(?int $numeroRue): self
    {
        $this->numeroRue = $numeroRue;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(?string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getAdprecision(): ?string
    {
        return $this->adprecision;
    }

    public function setAdprecision(?string $adprecision): self
    {
        $this->adprecision = $adprecision;

        return $this;
    }

    public function getTypevoie(): ?string
    {
        return $this->typevoie;
    }

    public function setTypevoie(?string $typevoie): self
    {
        $this->typevoie = $typevoie;

        return $this;
    }

    public function getNomvoie(): ?string
    {
        return $this->nomvoie;
    }

    public function setNomvoie(?string $nomvoie): self
    {
        $this->nomvoie = $nomvoie;

        return $this;
    }

    public function getComplement(): ?string
    {
        return $this->complement;
    }

    public function setComplement(?string $complement): self
    {
        $this->complement = $complement;

        return $this;
    }

    public function getLieudit(): ?string
    {
        return $this->lieudit;
    }

    public function setLieudit(?string $lieudit): self
    {
        $this->lieudit = $lieudit;

        return $this;
    }

    public function getCodepostal(): ?string
    {
        return $this->codepostal;
    }

    public function setCodepostal(?string $codepostal): self
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getBoitepostal(): ?string
    {
        return $this->boitepostal;
    }

    public function setBoitepostal(?string $boitepostal): self
    {
        $this->boitepostal = $boitepostal;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getTitulaire(): ?NewTitulaire
    {
        return $this->titulaire;
    }

    public function setTitulaire(?NewTitulaire $titulaire): self
    {
        $this->titulaire = $titulaire;

        return $this;
    }
}

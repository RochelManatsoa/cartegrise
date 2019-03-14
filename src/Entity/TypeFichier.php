<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeFichierRepository")
 */
class TypeFichier
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
    private $nom;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ctvo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $dvin;

    /**
     * @ORM\Column(type="boolean")
     */
    private $cdom;

    /**
     * @ORM\Column(type="boolean")
     */
    private $csm;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ddup;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCtvo(): ?bool
    {
        return $this->ctvo;
    }

    public function setCtvo(bool $ctvo): self
    {
        $this->ctvo = $ctvo;

        return $this;
    }

    public function getDvin(): ?bool
    {
        return $this->dvin;
    }

    public function setDvin(bool $dvin): self
    {
        $this->dvin = $dvin;

        return $this;
    }

    public function getCdom(): ?bool
    {
        return $this->cdom;
    }

    public function setCdom(bool $cdom): self
    {
        $this->cdom = $cdom;

        return $this;
    }

    public function getCsm(): ?bool
    {
        return $this->csm;
    }

    public function setCsm(bool $csm): self
    {
        $this->csm = $csm;

        return $this;
    }

    public function getDdup(): ?bool
    {
        return $this->ddup;
    }

    public function setDdup(bool $ddup): self
    {
        $this->ddup = $ddup;

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}

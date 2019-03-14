<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FichierRepository")
 */
class Fichier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Demande", inversedBy="fichiers")
     */
    private $demande;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="fichiers")
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeContenu;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Documents", inversedBy="fichiers")
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $envoyeLe;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $valideLe;

    public function __toString()
    {
        return $this->typeContenu;
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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getTypeContenu(): ?string
    {
        return $this->typeContenu;
    }

    public function setTypeContenu(string $typeContenu): self
    {
        $this->typeContenu = $typeContenu;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?Documents
    {
        return $this->type;
    }

    public function setType(?Documents $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEnvoyeLe(): ?\DateTimeInterface
    {
        return $this->envoyeLe;
    }

    public function setEnvoyeLe(\DateTimeInterface $envoyeLe): self
    {
        $this->envoyeLe = $envoyeLe;

        return $this;
    }

    public function getValideLe(): ?\DateTimeInterface
    {
        return $this->valideLe;
    }

    public function setValideLe(\DateTimeInterface $valideLe): self
    {
        $this->valideLe = $valideLe;

        return $this;
    }
}

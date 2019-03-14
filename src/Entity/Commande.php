<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
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
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $immatriculation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeDemande", inversedBy="commandes")
     */
    private $demarche;

    /**
     * @ORM\Column(type="datetime")
     */
    private $ceerLe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="commande")
     */
    private $client;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getDemarche(): ?TypeDemande
    {
        return $this->demarche;
    }

    public function setDemarche(?TypeDemande $demarche): self
    {
        $this->demarche = $demarche;

        return $this;
    }

    public function getCeerLe(): ?\DateTimeInterface
    {
        return $this->ceerLe;
    }

    public function setCeerLe(\DateTimeInterface $ceerLe): self
    {
        $this->ceerLe = $ceerLe;

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

}

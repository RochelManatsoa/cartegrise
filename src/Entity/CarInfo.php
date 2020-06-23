<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarInfoRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class CarInfo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"api"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api"})
     */
    private $marque;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api"})
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api"})
     */
    private $serialNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api"})
     */
    private $color;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"api"})
     */
    private $nbPlace;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"api"})
     */
    private $horsePower;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"api"})
     */
    private $horsePowerFiscal;


    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"api"})
     */
    private $version;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api"})
     */
    private $vin;

    /**
     * @ORM\OneToOne(targetEntity="Commande", inversedBy="carInfo")
     */
    private $commande;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $data;

    /**
     * @var \DateTime $deletedAt
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

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

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    public function setSerialNumber(?string $serialNumber): self
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getNbPlace(): ?string
    {
        return $this->nbPlace;
    }

    public function setNbPlace(?string $nbPlace): self
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    public function getHorsePower(): ?string
    {
        return $this->horsePower;
    }

    public function setHorsePower(?string $horsePower): self
    {
        $this->horsePower = $horsePower;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): self
    {
        $this->version = $version;

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

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): self
    {
        $this->data = $data;

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

    public function getHorsePowerFiscal(): ?string
    {
        return $this->horsePowerFiscal;
    }

    public function setHorsePowerFiscal(?string $horsePowerFiscal): self
    {
        $this->horsePowerFiscal = $horsePowerFiscal;

        return $this;
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

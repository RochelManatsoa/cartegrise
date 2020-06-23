<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaxesRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Taxes
{
    const ENERGY_VALUES=[
        1 => "Essence ou diesel (gasoil) ‘ES’ / ‘GO’",
        2 => "GPL ou GNV uniquement ‘GP’ / ‘GN’",
        3 => "Electricité uniquement ‘EL’",
        4 => "Hybride",
        5 => "Bioéthanol E85 ‘FE’",
        6 => "Bicarburation",
    ];
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"api"})
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true, options={"default" : 0})
     * @Groups({"api"})
     */
    private $taxeRegionale;

    /**
     * @ORM\Column(type="float", nullable=true, options={"default" : 0})
     * @Groups({"api"})
     */
    private $taxe35cv;

    /**
     * @ORM\Column(type="float", nullable=true, options={"default" : 0})
     * @Groups({"api"})
     */
    private $taxeParafiscale;

    /**
     * @ORM\Column(type="float", nullable=true, options={"default" : 0})
     * @Groups({"api"})
     */
    private $taxeCO2;

    /**
     * @ORM\Column(type="float", nullable=true, options={"default" : 0})
     * @Groups({"api"})
     */
    private $taxeMalus;

    /**
     * @ORM\Column(type="float", nullable=true, options={"default" : 0})
     * @Groups({"api"})
     */
    private $taxeSIV;

    /**
     * @ORM\Column(type="float", nullable=true, options={"default" : 0})
     */
    private $taxeRedevanceSIV;

    /**
     * @ORM\Column(type="float", nullable=true, options={"default" : 0})
     * @Groups({"api"})
     */
    private $taxeTotale;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api"})
     */
    private $VIN;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"api"})
     */
    private $CO2;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"api"})
     */
    private $Puissance;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"api"})
     */
    private $Genre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"api"})
     */
    private $PTAC;

    /**
     * @ORM\Column(type="string")
     * @Groups({"api"})
     */
    private $Energie;

    /**
     * @ORM\Column(type="date")
     * @Groups({"api"})
     */
    private $DateMEC;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Commande", inversedBy="taxes", cascade={"persist", "remove"})
     */
    private $commande;

    /**
     * @var \DateTime $deletedAt
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;


    public function __construct()
    {
        $this->taxeRegionale = 0;
        $this->taxe35cv = 0;
        $this->taxeParafiscale = 0;
        $this->taxeCO2 = 0;
        $this->taxeMalus = 0;
        $this->taxeSIV = 0;
        $this->taxeRedevanceSIV = 0;
        $this->taxeTotale = 0;
        // $this->commande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaxeRegionale(): ?float
    {
        return $this->taxeRegionale;
    }

    public function setTaxeRegionale(float $taxeRegionale): self
    {
        $this->taxeRegionale = $taxeRegionale;

        return $this;
    }

    public function getTaxe35cv(): ?float
    {
        return $this->taxe35cv;
    }

    public function setTaxe35cv(float $taxe35cv): self
    {
        $this->taxe35cv = $taxe35cv;

        return $this;
    }

    public function getTaxeParafiscale(): ?float
    {
        return $this->taxeParafiscale;
    }

    public function setTaxeParafiscale(float $taxeParafiscale): self
    {
        $this->taxeParafiscale = $taxeParafiscale;

        return $this;
    }

    public function getTaxeCO2(): ?float
    {
        return $this->taxeCO2;
    }

    public function setTaxeCO2(float $taxeCO2): self
    {
        $this->taxeCO2 = $taxeCO2;

        return $this;
    }

    public function getTaxeMalus(): ?float
    {
        return $this->taxeMalus;
    }

    public function setTaxeMalus(float $taxeMalus): self
    {
        $this->taxeMalus = $taxeMalus;

        return $this;
    }

    public function getTaxeSIV(): ?float
    {
        return $this->taxeSIV;
    }

    public function setTaxeSIV(float $taxeSIV): self
    {
        $this->taxeSIV = $taxeSIV;

        return $this;
    }

    public function getTaxeRedevanceSIV(): ?float
    {
        return $this->taxeRedevanceSIV;
    }

    public function setTaxeRedevanceSIV(float $taxeRedevanceSIV): self
    {
        $this->taxeRedevanceSIV = $taxeRedevanceSIV;

        return $this;
    }

    public function getTaxeTotale(): ?float
    {
        return $this->taxeTotale;
    }

    public function setTaxeTotale(float $taxeTotale): self
    {
        $this->taxeTotale = $taxeTotale;

        return $this;
    }

    public function getCO2(): ?int
    {
        return $this->CO2;
    }

    public function setCO2(int $CO2): self
    {
        $this->CO2 = $CO2;

        return $this;
    }

    public function getPuissance(): ?int
    {
        return $this->Puissance;
    }

    public function setPuissance(int $Puissance): self
    {
        $this->Puissance = $Puissance;

        return $this;
    }

    public function getGenre(): ?int
    {
        return $this->Genre;
    }

    public function setGenre(int $Genre): self
    {
        $this->Genre = $Genre;

        return $this;
    }

    public function getPTAC(): ?int
    {
        return $this->PTAC;
    }

    public function setPTAC(?int $PTAC): self
    {
        $this->PTAC = $PTAC;

        return $this;
    }

    public function getEnergie(): ?string
    {
        return $this->Energie;
    }

    public function setEnergie(string $Energie): self
    {
        $this->Energie = $Energie;

        return $this;
    }

    public function getDateMEC(): ?\DateTimeInterface
    {
        return $this->DateMEC;
    }

    public function setDateMEC(\DateTimeInterface $DateMEC): self
    {
        $this->DateMEC = $DateMEC;

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

    public function getVIN(): ?string
    {
        return $this->VIN;
    }

    public function setVIN(?string $VIN): self
    {
        $this->VIN = $VIN;

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

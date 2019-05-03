<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DossiersDomicileRecentRepository")
 */
class DossiersDomicileRecent
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
    private $quittanceLoyer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avisImposition;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $quittanceGaz;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $quittanceElec;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $factureTel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $factureInternet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attestFournisseurEnergie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attestAssurHabitat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuittanceLoyer(): ?string
    {
        return $this->quittanceLoyer;
    }

    public function setQuittanceLoyer(?string $quittanceLoyer): self
    {
        $this->quittanceLoyer = $quittanceLoyer;

        return $this;
    }

    public function getAvisImposition(): ?string
    {
        return $this->avisImposition;
    }

    public function setAvisImposition(?string $avisImposition): self
    {
        $this->avisImposition = $avisImposition;

        return $this;
    }

    public function getQuittanceGaz(): ?string
    {
        return $this->quittanceGaz;
    }

    public function setQuittanceGaz(?string $quittanceGaz): self
    {
        $this->quittanceGaz = $quittanceGaz;

        return $this;
    }

    public function getQuittanceElec(): ?string
    {
        return $this->quittanceElec;
    }

    public function setQuittanceElec(?string $quittanceElec): self
    {
        $this->quittanceElec = $quittanceElec;

        return $this;
    }

    public function getFactureTel(): ?string
    {
        return $this->factureTel;
    }

    public function setFactureTel(?string $factureTel): self
    {
        $this->factureTel = $factureTel;

        return $this;
    }

    public function getFactureInternet(): ?string
    {
        return $this->factureInternet;
    }

    public function setFactureInternet(?string $factureInternet): self
    {
        $this->factureInternet = $factureInternet;

        return $this;
    }

    public function getAttestFournisseurEnergie(): ?string
    {
        return $this->attestFournisseurEnergie;
    }

    public function setAttestFournisseurEnergie(?string $attestFournisseurEnergie): self
    {
        $this->attestFournisseurEnergie = $attestFournisseurEnergie;

        return $this;
    }

    public function getAttestAssurHabitat(): ?string
    {
        return $this->attestAssurHabitat;
    }

    public function setAttestAssurHabitat(?string $attestAssurHabitat): self
    {
        $this->attestAssurHabitat = $attestAssurHabitat;

        return $this;
    }
}

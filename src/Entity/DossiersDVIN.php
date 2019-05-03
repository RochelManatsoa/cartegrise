<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DossiersDVINRepository")
 */
class DossiersDVIN
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
    private $certifConformiteEurop;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $certifVenteAchat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pieceIdentite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attestAssurance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $permisConduire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $demCertificImmat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $procurMandat;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Divn", inversedBy="dossiersDVIN", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $divn;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\DossiersDomicileRecent", cascade={"persist", "remove"})
     */
    private $domicile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCertifConformiteEurop(): ?string
    {
        return $this->certifConformiteEurop;
    }

    public function setCertifConformiteEurop(?string $certifConformiteEurop): self
    {
        $this->certifConformiteEurop = $certifConformiteEurop;

        return $this;
    }

    public function getCertifVenteAchat(): ?string
    {
        return $this->certifVenteAchat;
    }

    public function setCertifVenteAchat(?string $certifVenteAchat): self
    {
        $this->certifVenteAchat = $certifVenteAchat;

        return $this;
    }

    public function getPieceIdentite(): ?string
    {
        return $this->pieceIdentite;
    }

    public function setPieceIdentite(?string $pieceIdentite): self
    {
        $this->pieceIdentite = $pieceIdentite;

        return $this;
    }

    public function getAttestAssurance(): ?string
    {
        return $this->attestAssurance;
    }

    public function setAttestAssurance(?string $attestAssurance): self
    {
        $this->attestAssurance = $attestAssurance;

        return $this;
    }

    public function getPermisConduire(): ?string
    {
        return $this->permisConduire;
    }

    public function setPermisConduire(?string $permisConduire): self
    {
        $this->permisConduire = $permisConduire;

        return $this;
    }

    public function getDemCertificImmat(): ?string
    {
        return $this->demCertificImmat;
    }

    public function setDemCertificImmat(?string $demCertificImmat): self
    {
        $this->demCertificImmat = $demCertificImmat;

        return $this;
    }

    public function getProcurMandat(): ?string
    {
        return $this->procurMandat;
    }

    public function setProcurMandat(?string $procurMandat): self
    {
        $this->procurMandat = $procurMandat;

        return $this;
    }

    public function getDivn(): ?Divn
    {
        return $this->divn;
    }

    public function setDivn(Divn $divn): self
    {
        $this->divn = $divn;

        return $this;
    }

    public function getDomicile(): ?DossiersDomicileRecent
    {
        return $this->domicile;
    }

    public function setDomicile(?DossiersDomicileRecent $domicile): self
    {
        $this->domicile = $domicile;

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DossiersDCARepository")
 */
class DossiersDCA
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
    private $carteGrise;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $demCertificImmat;

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
     * @ORM\OneToOne(targetEntity="App\Entity\ChangementAdresse", inversedBy="dossiersDCA", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $dca;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\DossiersDomicileRecent", cascade={"persist", "remove"})
     */
    private $domicile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarteGrise(): ?string
    {
        return $this->carteGrise;
    }

    public function setCarteGrise(?string $carteGrise): self
    {
        $this->carteGrise = $carteGrise;

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

    public function getDca(): ?ChangementAdresse
    {
        return $this->dca;
    }

    public function setDca(ChangementAdresse $dca): self
    {
        $this->dca = $dca;

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

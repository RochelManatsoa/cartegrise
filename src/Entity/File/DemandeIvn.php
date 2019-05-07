<?php

namespace App\Entity\File;

use App\Entity\Divn;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\File\DemandeIvnRepository")
 */
class DemandeIvn
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Divn", mappedBy="file", cascade={"persist", "remove"})
     */
    private $divn;

    /**
    * @ORM\Column(type="string", nullable=true)
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $originalCertificatConformiteEuropeen;

    /**
    * @ORM\Column(type="string", nullable=true)
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $certificatVenteOriginalFactureAchat;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $pieceIdentiteValid;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $copieAttestationAssuranceValide;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $copiePermisConduireTitulaire;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $demandeOriginalCertificatImmatriculation;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $procurationParMandat;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $justificatifDomicileRecent;


    public function getDivn(): ?Divn
    {
        return $this->divn;
    }

    public function setDivn(?Divn $divn): self
    {
        $this->divn = $divn;

        // set (or unset) the owning side of the relation if necessary
        $newFile = $divn === null ? null : $this;
        if ($newFile !== $divn->getFile()) {
            $divn->setFile($newFile);
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalCertificatConformiteEuropeen(): ?string
    {
        return $this->originalCertificatConformiteEuropeen;
    }

    public function setOriginalCertificatConformiteEuropeen(?string $originalCertificatConformiteEuropeen): self
    {
        $this->originalCertificatConformiteEuropeen = $originalCertificatConformiteEuropeen;

        return $this;
    }

    public function getCertificatVenteOriginalFactureAchat(): ?string
    {
        return $this->certificatVenteOriginalFactureAchat;
    }

    public function setCertificatVenteOriginalFactureAchat(?string $certificatVenteOriginalFactureAchat): self
    {
        $this->certificatVenteOriginalFactureAchat = $certificatVenteOriginalFactureAchat;

        return $this;
    }

    public function getPieceIdentiteValid(): ?string
    {
        return $this->pieceIdentiteValid;
    }

    public function setPieceIdentiteValid(?string $pieceIdentiteValid): self
    {
        $this->pieceIdentiteValid = $pieceIdentiteValid;

        return $this;
    }

    public function getCopieAttestationAssuranceValide(): ?string
    {
        return $this->copieAttestationAssuranceValide;
    }

    public function setCopieAttestationAssuranceValide(?string $copieAttestationAssuranceValide): self
    {
        $this->copieAttestationAssuranceValide = $copieAttestationAssuranceValide;

        return $this;
    }

    public function getCopiePermisConduireTitulaire(): ?string
    {
        return $this->copiePermisConduireTitulaire;
    }

    public function setCopiePermisConduireTitulaire(?string $copiePermisConduireTitulaire): self
    {
        $this->copiePermisConduireTitulaire = $copiePermisConduireTitulaire;

        return $this;
    }

    public function getDemandeOriginalCertificatImmatriculation(): ?string
    {
        return $this->demandeOriginalCertificatImmatriculation;
    }

    public function setDemandeOriginalCertificatImmatriculation(?string $demandeOriginalCertificatImmatriculation): self
    {
        $this->demandeOriginalCertificatImmatriculation = $demandeOriginalCertificatImmatriculation;

        return $this;
    }

    public function getProcurationParMandat(): ?string
    {
        return $this->procurationParMandat;
    }

    public function setProcurationParMandat(?string $procurationParMandat): self
    {
        $this->procurationParMandat = $procurationParMandat;

        return $this;
    }

    public function getJustificatifDomicileRecent(): ?string
    {
        return $this->justificatifDomicileRecent;
    }

    public function setJustificatifDomicileRecent(?string $justificatifDomicileRecent): self
    {
        $this->justificatifDomicileRecent = $justificatifDomicileRecent;

        return $this;
    }
}
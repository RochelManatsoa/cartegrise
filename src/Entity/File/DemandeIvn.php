<?php

namespace App\Entity\File;

use App\Entity\Divn;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\File\DemandeIvnRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class DemandeIvn
{
    use FileTrait;
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
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "5120k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    protected $originalCertificatConformiteEuropeen;

    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "5120k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    protected $certificatVenteOriginalFactureAchat;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "5120k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    protected $pieceIdentiteValid;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "5120k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    protected $copieAttestationAssuranceValide;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "5120k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    protected $copiePermisConduireTitulaire;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "5120k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    protected $demandeOriginalCertificatImmatriculation;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "5120k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    protected $procurationParMandat;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "5120k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    protected $justificatifDomicileRecent;

    /**
     * @var \DateTime $deletedAt
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    // don't touch
    public function getParent() : Divn
    {
        return $this->divn;
    }


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
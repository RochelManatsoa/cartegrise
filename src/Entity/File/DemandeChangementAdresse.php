<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-04-29 12:14:35 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-04-29 16:22:44
 */
namespace App\Entity\File;
                                                                           
use App\Entity\ChangementAdresse;
use App\Entity\Duplicata;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

                
/**
 * @ORM\Entity(repositoryClass="App\Repository\File\DemandeChangementAdresseRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class DemandeChangementAdresse
{
    use FileTrait;
    /**
    * @ORM\ID
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    private $id;

    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "5120k",
    *     mimeTypes = {"application/pdf", "application/x-pdf", "image/jpeg", "image/png"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    protected $rectoVersoCarteGrise;

    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "5120k",
    *     mimeTypes = {"application/pdf", "application/x-pdf", "image/jpeg", "image/png"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    protected $demandeCertificatImmatriculation;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "5120k",
    *     mimeTypes = {"application/pdf", "application/x-pdf", "image/jpeg", "image/png"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    protected $pieceIdentiteValid;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "5120k",
    *     mimeTypes = {"application/pdf", "application/x-pdf", "image/jpeg", "image/png"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    protected $copieAttestationAssuranceValide;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "5120k",
    *     mimeTypes = {"application/pdf", "application/x-pdf", "image/jpeg", "image/png"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    protected $copiePermisConduire;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "5120k",
    *     mimeTypes = {"application/pdf", "application/x-pdf", "image/jpeg", "image/png"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    protected $justificatifDomicile;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "5120k",
    *     mimeTypes = {"application/pdf", "application/x-pdf", "image/jpeg", "image/png"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    protected $procurationMandat;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ChangementAdresse", mappedBy="file")
     */
    private $changementAdresse;

    /**
     * @var \DateTime $deletedAt
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    // don't touch
    public function getParent() : ChangementAdresse
    {
        return $this->changementAdresse;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRectoVersoCarteGrise(): ?string
    {
        return $this->rectoVersoCarteGrise;
    }

    public function setRectoVersoCarteGrise(?string $rectoVersoCarteGrise): self
    {
        $this->rectoVersoCarteGrise = $rectoVersoCarteGrise;

        return $this;
    }

    public function getCertificatImmatriculation(): ?string
    {
        return $this->certificatImmatriculation;
    }

    public function setCertificatImmatriculation(?string $certificatImmatriculation): self
    {
        $this->certificatImmatriculation = $certificatImmatriculation;

        return $this;
    }

    public function getDeclarationdePerteOuVol(): ?string
    {
        return $this->declarationdePerteOuVol;
    }

    public function setDeclarationdePerteOuVol(?string $declarationdePerteOuVol): self
    {
        $this->declarationdePerteOuVol = $declarationdePerteOuVol;

        return $this;
    }

    public function getCopieControleTechniqueEnCoursValidite(): ?string
    {
        return $this->copieControleTechniqueEnCoursValidite;
    }

    public function setCopieControleTechniqueEnCoursValidite(?string $copieControleTechniqueEnCoursValidite): self
    {
        $this->copieControleTechniqueEnCoursValidite = $copieControleTechniqueEnCoursValidite;

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

    public function getPermisDeConduireDuTitulaire(): ?string
    {
        return $this->permisDeConduireDuTitulaire;
    }

    public function setPermisDeConduireDuTitulaire(?string $permisDeConduireDuTitulaire): self
    {
        $this->permisDeConduireDuTitulaire = $permisDeConduireDuTitulaire;

        return $this;
    }

    public function getDemandeDuplicata(): ?Duplicata
    {
        return $this->demandeDuplicata;
    }

    public function setDemandeDuplicata(?Duplicata $demandeDuplicata): self
    {
        $this->demandeDuplicata = $demandeDuplicata;

        // set (or unset) the owning side of the relation if necessary
        $newFile = $demandeDuplicata === null ? null : $this;
        if ($newFile !== $demandeDuplicata->getFile()) {
            $demandeDuplicata->setFile($newFile);
        }

        return $this;
    }

    public function getDemandeCertificatImmatriculation(): ?string
    {
        return $this->demandeCertificatImmatriculation;
    }

    public function setDemandeCertificatImmatriculation(?string $demandeCertificatImmatriculation): self
    {
        $this->demandeCertificatImmatriculation = $demandeCertificatImmatriculation;

        return $this;
    }

    public function getCopiePermisConduire(): ?string
    {
        return $this->copiePermisConduire;
    }

    public function setCopiePermisConduire(?string $copiePermisConduire): self
    {
        $this->copiePermisConduire = $copiePermisConduire;

        return $this;
    }

    public function getJustificatifDomicile(): ?string
    {
        return $this->justificatifDomicile;
    }

    public function setJustificatifDomicile(?string $justificatifDomicile): self
    {
        $this->justificatifDomicile = $justificatifDomicile;

        return $this;
    }

    public function getChangementAdresse(): ?ChangementAdresse
    {
        return $this->changementAdresse;
    }

    public function setChangementAdresse(?ChangementAdresse $changementAdresse): self
    {
        $this->changementAdresse = $changementAdresse;

        // set (or unset) the owning side of the relation if necessary
        $newFile = $changementAdresse === null ? null : $this;
        if ($newFile !== $changementAdresse->getFile()) {
            $changementAdresse->setFile($newFile);
        }

        return $this;
    }

    public function getProcurationMandat(): ?string
    {
        return $this->procurationMandat;
    }

    public function setProcurationMandat(?string $procurationMandat): self
    {
        $this->procurationMandat = $procurationMandat;

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
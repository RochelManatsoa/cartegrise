<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-04-29 12:14:35 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-04-29 16:22:44
 */
namespace App\Entity\File;
                                                                           
use App\Entity\Duplicata;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
                
/**
 * @ORM\Entity(repositoryClass="App\Repository\File\DemandeDuplicataRepository")
 */
class DemandeDuplicata
{
    /**
    * @ORM\ID
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    private $id;

    /**
    * @ORM\Column(type="string", nullable=true)
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $rectoVersoCarteGrise;

    /**
    * @ORM\Column(type="string", nullable=true)
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $certificatImmatriculation;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $declarationdePerteOuVol;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $copieControleTechniqueEnCoursValidite;
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
    private $permisDeConduireDuTitulaire;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Duplicata", mappedBy="file")
     */
    private $demandeDuplicata;

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
}
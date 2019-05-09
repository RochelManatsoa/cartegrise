<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-04-29 12:14:35 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-04-29 16:22:44
 */
namespace App\Entity\File;
                                                                           
use App\Entity\Ctvo;
use App\Entity\Duplicata;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
                
/**
 * @ORM\Entity(repositoryClass="App\Repository\File\DemandeCtvoRepository")
 */
class DemandeCtvo
{
    /**
    * @ORM\ID
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    private $id;
    /**
    * @ORM\OneToOne(targetEntity="Files", inversedBy="demandeDuplicata")
    */
    private $files;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $rectoVersoCarteGrise;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $declatationCession;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $demandeCertificat;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $procurationManda;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $pieceIdentite;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $copieControleTechnique;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $recepiseDemandeAchat;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $copieAttestationAssurance;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $copiePermisConduireTitulaire;
    /**
    * @ORM\Column(type="string", nullable=true)
    * @Groups({"file"})
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"application/pdf", "application/x-pdf"},
    *     mimeTypesMessage = "Please upload a valid PDF"
    * )
    */
    private $justificatifDomicile;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Ctvo", mappedBy="file")
     */
    private $ctvo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRectoVerso()
    {
        return $this->rectoVerso;
    }

    public function setRectoVerso($rectoVerso): self
    {
        $this->rectoVerso = $rectoVerso;

        return $this;
    }

    public function getFiles(): ?Files
    {
        return $this->files;
    }

    public function setFiles(?Files $files): self
    {
        $this->files = $files;

        return $this;
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

    public function getDeclatationCession(): ?string
    {
        return $this->declatationCession;
    }

    public function setDeclatationCession(?string $declatationCession): self
    {
        $this->declatationCession = $declatationCession;

        return $this;
    }

    public function getDemandeCertificat(): ?string
    {
        return $this->demandeCertificat;
    }

    public function setDemandeCertificat(?string $demandeCertificat): self
    {
        $this->demandeCertificat = $demandeCertificat;

        return $this;
    }

    public function getProcurationManda(): ?string
    {
        return $this->procurationManda;
    }

    public function setProcurationManda(?string $procurationManda): self
    {
        $this->procurationManda = $procurationManda;

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

    public function getCopieControleTechnique(): ?string
    {
        return $this->copieControleTechnique;
    }

    public function setCopieControleTechnique(?string $copieControleTechnique): self
    {
        $this->copieControleTechnique = $copieControleTechnique;

        return $this;
    }

    public function getRecepiseDemandeAchat(): ?string
    {
        return $this->recepiseDemandeAchat;
    }

    public function setRecepiseDemandeAchat(?string $recepiseDemandeAchat): self
    {
        $this->recepiseDemandeAchat = $recepiseDemandeAchat;

        return $this;
    }

    public function getCopieAttestationAssurance(): ?string
    {
        return $this->copieAttestationAssurance;
    }

    public function setCopieAttestationAssurance(?string $copieAttestationAssurance): self
    {
        $this->copieAttestationAssurance = $copieAttestationAssurance;

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

    public function getJustificatifDomicile(): ?string
    {
        return $this->justificatifDomicile;
    }

    public function setJustificatifDomicile(?string $justificatifDomicile): self
    {
        $this->justificatifDomicile = $justificatifDomicile;

        return $this;
    }

    public function getCtvo(): ?Ctvo
    {
        return $this->ctvo;
    }

    public function setCtvo(?Ctvo $ctvo): self
    {
        $this->ctvo = $ctvo;

        // set (or unset) the owning side of the relation if necessary
        $newFile = $ctvo === null ? null : $this;
        if ($newFile !== $ctvo->getFile()) {
            $ctvo->setFile($newFile);
        }

        return $this;
    }
}
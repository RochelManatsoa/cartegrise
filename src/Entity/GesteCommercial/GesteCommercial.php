<?php

namespace App\Entity\GesteCommercial;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Commande;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\GesteCommercialRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class GesteCommercial
{
    const DOC_DOWNLOAD = 'document/';
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fullPath;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Commande", inversedBy="gesteCommercial", cascade={"persist", "remove"})
     */
    private $commande;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $paied;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $taxeFiscal;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $fraisDossier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullPath(): ?string
    {
        return $this->fullPath;
    }

    public function setFullPath(string $fullPath): self
    {
        $this->fullPath = $fullPath;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPaied(): ?bool
    {
        return $this->paied;
    }

    public function setPaied(?bool $paied): self
    {
        $this->paied = $paied;

        return $this;
    }

    public function getTaxeFiscal(): ?string
    {
        return $this->taxeFiscal;
    }

    public function setTaxeFiscal(?string $taxeFiscal): self
    {
        $this->taxeFiscal = $taxeFiscal;

        return $this;
    }

    public function getFraisDossier(): ?string
    {
        return $this->fraisDossier;
    }

    public function setFraisDossier(?string $fraisDossier): self
    {
        $this->fraisDossier = $fraisDossier;

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

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }


    public function getGeneratedGesteCommercialpdfPath(): ?string
    {
        $path = $this::DOC_DOWNLOAD . $this->id ."gesteCommercial/".
            $this->getId(). '-' .
            $this->getCommande()->getId();

        return $path;
    }

    public function getGeneratedGesteCommercialPathFile(): ?string
    {

        return $this->getGeneratedGesteCommercialpdfPath().'/gesteCommercial.pdf';
    }

    public function getNumeroGesteValue(){
        $num = $this->getId();
        $string = '0';
        $length = 4;
        $numlength = strlen((string)$num);
        $restLength = $length - $numlength;
        for($i= 0; $i < $restLength; $i++) {
            $num =$string . (string)$num;
        }
        $num;
        $dateDemande = $this->getCreatedAt()->format('Ym');
        $type = $this->getCommande()->getDemarche()->getType();
        $id = $this->getCommande()->getId();

        return 'A'.$num . $dateDemande . '/' . $type . $id;
    }
}

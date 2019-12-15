<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\AvoirRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Avoir
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fullPath;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Demande", inversedBy="avoir", cascade={"persist", "remove"})
     */
    private $demande;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $paied;

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

    public function getDemande(): ?Demande
    {
        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        $this->demande = $demande;

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

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }


    public function getNumeroAvoirValue(){
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
        $type = $this->getDemande()->getCommande()->getDemarche()->getType();
        $demandeId = $this->getDemande()->getId();

        return 'A'.$num . $dateDemande . '/' . $type . $demandeId;
    }
}

<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-04-29 13:09:08 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-04-29 13:50:50
 */
namespace App\Entity\File;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\File\FilesRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Files
{
    /**
     * @ORM\ID
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\File\Files", inversedBy="files")
     * @ORM\JoinColumn()
     */
    private $demande;
    /**
     * @ORM\OneToOne(targetEntity="DemandeDuplicata", mappedBy="files")
     * @ORM\JoinColumn()
     */
    private $demandeDuplicata;

    /**
     * @var \DateTime $deletedAt
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDemande(): ?self
    {
        return $this->demande;
    }

    public function setDemande(?self $demande): self
    {
        $this->demande = $demande;

        return $this;
    }

    public function getDemandeDuplicata(): ?DemandeDuplicata
    {
        return $this->demandeDuplicata;
    }

    public function setDemandeDuplicata(?DemandeDuplicata $demandeDuplicata): self
    {
        $this->demandeDuplicata = $demandeDuplicata;

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

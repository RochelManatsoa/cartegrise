<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-04-29 13:09:08 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-04-29 13:50:50
 */
namespace App\Entity\File;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\File\FilesRepository")
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
}

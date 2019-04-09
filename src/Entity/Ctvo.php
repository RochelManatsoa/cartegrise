<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Ctvo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Demande", inversedBy="ctvo", cascade={"persist", "remove"})
     */
    private $demande;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Ancientitulaire", inversedBy="ctvo", cascade={"persist", "remove"})
     */
    private $ancienTitulaire;
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\NewTitulaire", inversedBy="ctvo", cascade={"persist", "remove"})
     */
    private $acquerreur;

    public function getDemande(): ?Demande
    {
        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        $this->demande = $demande;

        return $this;
    }

    public function getAncienTitulaire(): ?Ancientitulaire
    {
        return $this->ancienTitulaire;
    }

    public function setAncienTitulaire(?Ancientitulaire $ancienTitulaire): self
    {
        $this->ancienTitulaire = $ancienTitulaire;

        return $this;
    }

    public function getAcquerreur(): ?NewTitulaire
    {
        return $this->acquerreur;
    }

    public function setAcquerreur(?NewTitulaire $acquerreur): self
    {
        $this->acquerreur = $acquerreur;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

}
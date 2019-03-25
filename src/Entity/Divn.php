<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DivnRepository")
 */
class Divn
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Demande", inversedBy="divn", cascade={"persist", "remove"})
     */
    private $demande;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\NewTitulaire",inversedBy="divn", cascade={"persist", "remove"})
     */
    private $acquerreur;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getAcquerreur(): ?NewTitulaire
    {
        return $this->acquerreur;
    }

    public function setAcquerreur(?NewTitulaire $acquerreur): self
    {
        $this->acquerreur = $acquerreur;

        return $this;
    }
}

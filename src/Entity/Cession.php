<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CessionRepository")
 */
class Cession
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Demande", inversedBy="cession", cascade={"persist", "remove"})
     */
    private $demande;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Ancientitulaire", inversedBy="cession", cascade={"persist", "remove"})
     */
    private $ancienTitulaire;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\NewTitulaire", inversedBy="cession", cascade={"persist", "remove"})
     */
    private $acquerreur;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCession;

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

    public function getDateCession(): ?\DateTimeInterface
    {
        return $this->dateCession;
    }

    public function setDateCession(?\DateTimeInterface $dateCession): self
    {
        $this->dateCession = $dateCession;

        return $this;
    }
}

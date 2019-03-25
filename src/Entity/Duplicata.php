<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DuplicataRepository")
 */
class Duplicata
{
    const VOL = "Vol";
    const PERT = "Perte";
    const DET = "Détérioration";
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Ancientitulaire", cascade={"persist", "remove"})
     */
    private $titulaire;

    // for motif de la demande
    /**
     * @ORM\Column(type= "string")
     */
    private $motifDemande;

    /**
     * Demande effectuée dans le cadre d'un changement de titulaire ou de cession
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $demandeChangementTitulaire;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Demande", inversedBy="duplicata", cascade={"persist", "remove"})
     */
    private $demande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotifDemande(): ?string
    {
        return $this->motifDemande;
    }

    public function setMotifDemande(string $motifDemande): self
    {
        $this->motifDemande = $motifDemande;

        return $this;
    }

    public function getDemandeChangementTitulaire(): ?bool
    {
        return $this->demandeChangementTitulaire;
    }

    public function setDemandeChangementTitulaire(?bool $demandeChangementTitulaire): self
    {
        $this->demandeChangementTitulaire = $demandeChangementTitulaire;

        return $this;
    }

    public function getTitulaire(): ?Ancientitulaire
    {
        return $this->titulaire;
    }

    public function setTitulaire(?Ancientitulaire $titulaire): self
    {
        $this->titulaire = $titulaire;

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
}
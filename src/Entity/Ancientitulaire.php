<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AncientitulaireRepository")
 */
class Ancientitulaire
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
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $raisonsociale;

    /**
     * Opposé à la réutilisation des données à des fins d’enquête et de prospection commerciale
     * ORM\Column(type="boolean", nullable=true)
     */
    private $opposeReuse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomprenom;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Ctvo", mappedBy="ancienTitulaire", cascade={"persist", "remove"})
     */
    private $ctvo;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Cession", mappedBy="ancienTitulaire", cascade={"persist", "remove"})
     */
    private $cession;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getRaisonsociale(): ?string
    {
        return $this->raisonsociale;
    }

    public function setRaisonsociale(string $raisonsociale): self
    {
        $this->raisonsociale = $raisonsociale;

        return $this;
    }

    public function getNomprenom(): ?string
    {
        return $this->nomprenom;
    }

    public function setNomprenom(string $nomprenom): self
    {
        $this->nomprenom = $nomprenom;

        return $this;
    }

    public function getDemande(): ?Demande
    {
        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        $this->demande = $demande;

        // set (or unset) the owning side of the relation if necessary
        $newAncienTitulaire = $demande === null ? null : $this;
        if ($newAncienTitulaire !== $demande->getAncienTitulaire()) {
            $demande->setAncienTitulaire($newAncienTitulaire);
        }

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
        $newAncienTitulaire = $ctvo === null ? null : $this;
        if ($newAncienTitulaire !== $ctvo->getAncienTitulaire()) {
            $ctvo->setAncienTitulaire($newAncienTitulaire);
        }

        return $this;
    }

    public function getCession(): ?Cession
    {
        return $this->cession;
    }

    public function setCession(?Cession $cession): self
    {
        $this->cession = $cession;

        // set (or unset) the owning side of the relation if necessary
        $newAncienTitulaire = $cession === null ? null : $this;
        if ($newAncienTitulaire !== $cession->getAncienTitulaire()) {
            $cession->setAncienTitulaire($newAncienTitulaire);
        }

        return $this;
    }
}

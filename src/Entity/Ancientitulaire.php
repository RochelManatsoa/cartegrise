<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AncientitulaireRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Ancientitulaire
{
    const PERSONE_PHYSIQUE  = "phy";
    const PERSONE_MORALE    = "mor";
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siren;

    /**
     * Opposé à la réutilisation des données à des fins d’enquête et de prospection commerciale
     * ORM\Column(type="boolean", nullable=true)
     */
    private $opposeReuse;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $nomprenom;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Ctvo", mappedBy="ancienTitulaire", cascade={"persist", "remove"})
     */
    private $ctvo;

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

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(?string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

}

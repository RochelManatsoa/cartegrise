<?php

namespace App\Entity;

use App\Entity\File\DemandeChangementAdresse;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChangementAdresseRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class ChangementAdresse
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\NewTitulaire", inversedBy="changementAdresse", cascade={"persist", "remove"})
     */
    private $nouveauxTitulaire;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Adresse", cascade={"persist", "remove"})
     */
    private $ancienAdresse;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\File\DemandeChangementAdresse", inversedBy="changementAdresse", cascade={"persist", "remove"})
     */
    private $file;


    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Demande", inversedBy="changementAdresse", cascade={"all"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $demande;

    /**
     * numeroFormule variable
     * @ORM\Column(nullable=true)
     * @var string
     */
    private $numeroFormule;

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

    public function getNouveauxTitulaire(): ?NewTitulaire
    {
        return $this->nouveauxTitulaire;
    }

    public function setNouveauxTitulaire(?NewTitulaire $nouveauxTitulaire): self
    {
        $this->nouveauxTitulaire = $nouveauxTitulaire;

        return $this;
    }

    public function getAncienAdresse(): ?Adresse
    {
        return $this->ancienAdresse;
    }

    public function setAncienAdresse(?Adresse $ancienAdresse): self
    {
        $this->ancienAdresse = $ancienAdresse;

        return $this;
    }

    public function getNewAdresse(): ?Adresse
    {
        return $this->newAdresse;
    }

    public function setNewAdresse(?Adresse $newAdresse): self
    {
        $this->newAdresse = $newAdresse;

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

    public function getChangementAdresse(): ?self
    {
        return $this->changementAdresse;
    }

    public function setChangementAdresse(?self $changementAdresse): self
    {
        $this->changementAdresse = $changementAdresse;

        // set (or unset) the owning side of the relation if necessary
        $newFile = $changementAdresse === null ? null : $this;
        if ($newFile !== $changementAdresse->getFile()) {
            $changementAdresse->setFile($newFile);
        }

        return $this;
    }

    public function getFile(): ?DemandeChangementAdresse
    {
        return $this->file;
    }

    public function setFile(?DemandeChangementAdresse $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getNumeroFormule(): ?string
    {
        return $this->numeroFormule;
    }

    public function setNumeroFormule(?string $numeroFormule): self
    {
        $this->numeroFormule = $numeroFormule;

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

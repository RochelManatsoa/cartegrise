<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentsRepository")
 */
class Documents
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
    private $nom;

    /**
     * @ORM\Column(type="boolean")
     */
    private $rectoverso;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbDoc;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $texte;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $info;

    /**
     * @ORM\Column(type="boolean")
     */
    private $obligation;

    /**
     * @ORM\Column(type="dateinterval")
     */
    private $dureeValidite;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateHeure;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $repertoire;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $imageEnBD;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\TypeFichier", cascade={"persist", "remove"})
     */
    private $fichier;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TypeDemande", inversedBy="documents")
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     */
    private $mineur;

    /**
     * @ORM\Column(type="boolean")
     */
    private $cotitulaire;

    /**
     * @ORM\Column(type="boolean")
     */
    private $societe;

    /**
     * @ORM\Column(type="boolean")
     */
    private $achatProfessionnelAuto;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeDemande", inversedBy="docs")
     */
    private $typeDemande;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;


    public function __construct()
    {
        $this->type = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nom;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getRectoverso(): ?bool
    {
        return $this->rectoverso;
    }

    public function setRectoverso(bool $rectoverso): self
    {
        $this->rectoverso = $rectoverso;

        return $this;
    }

    public function getNbDoc(): ?int
    {
        return $this->nbDoc;
    }

    public function setNbDoc(int $nbDoc): self
    {
        $this->nbDoc = $nbDoc;

        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(?string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(?string $info): self
    {
        $this->info = $info;

        return $this;
    }

    public function getObligation(): ?bool
    {
        return $this->obligation;
    }

    public function setObligation(bool $obligation): self
    {
        $this->obligation = $obligation;

        return $this;
    }

    public function getDureeValidite(): ?\DateInterval
    {
        return $this->dureeValidite;
    }

    public function setDureeValidite(\DateInterval $dureeValidite): self
    {
        $this->dureeValidite = $dureeValidite;

        return $this;
    }

    public function getDateHeure(): ?\DateTimeInterface
    {
        return $this->dateHeure;
    }

    public function setDateHeure(\DateTimeInterface $dateHeure): self
    {
        $this->dateHeure = $dateHeure;

        return $this;
    }

    public function getRepertoire(): ?string
    {
        return $this->repertoire;
    }

    public function setRepertoire(string $repertoire): self
    {
        $this->repertoire = $repertoire;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getImageEnBD()
    {
        return $this->imageEnBD;
    }

    public function setImageEnBD($imageEnBD): self
    {
        $this->imageEnBD = $imageEnBD;

        return $this;
    }

    public function getFichier(): ?TypeFichier
    {
        return $this->fichier;
    }

    public function setFichier(?TypeFichier $fichier): self
    {
        $this->fichier = $fichier;

        return $this;
    }

    /**
     * @return Collection|TypeDemande[]
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(TypeDemande $type): self
    {
        if (!$this->type->contains($type)) {
            $this->type[] = $type;
        }

        return $this;
    }

    public function removeType(TypeDemande $type): self
    {
        if ($this->type->contains($type)) {
            $this->type->removeElement($type);
        }

        return $this;
    }

    public function getMineur(): ?bool
    {
        return $this->mineur;
    }

    public function setMineur(bool $mineur): self
    {
        $this->mineur = $mineur;

        return $this;
    }

    public function getCotitulaire(): ?bool
    {
        return $this->cotitulaire;
    }

    public function setCotitulaire(bool $cotitulaire): self
    {
        $this->cotitulaire = $cotitulaire;

        return $this;
    }

    public function getSociete(): ?bool
    {
        return $this->societe;
    }

    public function setSociete(bool $societe): self
    {
        $this->societe = $societe;

        return $this;
    }

    public function getAchatProfessionnelAuto(): ?bool
    {
        return $this->achatProfessionnelAuto;
    }

    public function setAchatProfessionnelAuto(bool $achatProfessionnelAuto): self
    {
        $this->achatProfessionnelAuto = $achatProfessionnelAuto;

        return $this;
    }

    public function getTypeDemande(): ?TypeDemande
    {
        return $this->typeDemande;
    }

    public function setTypeDemande(?TypeDemande $typeDemande): self
    {
        $this->typeDemande = $typeDemande;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

}

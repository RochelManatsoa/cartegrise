<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserInfosRepository")
 */
class UserInfos
{
    const GENRE_MALE = "Monsieur";
    const GENRE_FEMAL = "Madame";
    const USER_PARTICULAR = "Particulier";
    const USER_SOCIETY = "Société";
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $particulierOrSociete;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomUsage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Cession", mappedBy="acheteur", cascade={"persist", "remove"})
     * @ORM\JoinColumn()
     */
    private $cessionAcheteur;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Cession", mappedBy="vendeur", cascade={"persist", "remove"})
     * @ORM\JoinColumn()
     */
    private $cessionVendeur;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Adresse", cascade={"persist", "remove"})
     */
    private $adresse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function getNomPrenom()
    {
        return $this->nom . ' ' . $this->prenom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNomUsage(): ?string
    {
        return $this->nomUsage;
    }

    public function setNomUsage(string $nomUsage): self
    {
        $this->nomUsage = $nomUsage;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getParticulierOrSociete(): ?string
    {
        return $this->particulierOrSociete;
    }

    public function setParticulierOrSociete(string $particulierOrSociete): self
    {
        $this->particulierOrSociete = $particulierOrSociete;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getCessionAcheteur(): ?Cession
    {
        return $this->cessionAcheteur;
    }

    public function setCessionAcheteur(?Cession $cessionAcheteur): self
    {
        $this->cessionAcheteur = $cessionAcheteur;

        return $this;
    }

    public function getCessionVendeur(): ?Cession
    {
        return $this->cessionVendeur;
    }

    public function setCessionVendeur(?Cession $cessionVendeur): self
    {
        $this->cessionVendeur = $cessionVendeur;

        return $this;
    }
}

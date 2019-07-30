<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CotitulairesRepository")
 */
class Cotitulaires
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeCotitulaire;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message = "Champs requis")
     */
    private $nomCotitulaires;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message = "Champs requis")
     */
    private $prenomCotitulaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $raisonSocialCotitulaire;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message = "Champs requis")
     */
    private $sexeCotitulaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cartegrise", inversedBy="cotitulaires")
     * @ORM\JoinColumn(nullable=true)
     */
    private $carteGrise;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Divn", inversedBy="cotitulaire")
     */
    private $divn;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ctvo", inversedBy="cotitulaire")
     */
    private $ctvo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeCotitulaire(): ?string
    {
        return $this->typeCotitulaire;
    }

    public function setTypeCotitulaire(string $typeCotitulaire): self
    {
        $this->typeCotitulaire = $typeCotitulaire;

        return $this;
    }

    public function getNomCotitulaires(): ?string
    {
        return $this->nomCotitulaires;
    }

    public function setNomCotitulaires(string $nomCotitulaires): self
    {
        $this->nomCotitulaires = $nomCotitulaires;

        return $this;
    }

    public function getPrenomCotitulaire(): ?string
    {
        return $this->prenomCotitulaire;
    }

    public function setPrenomCotitulaire(string $prenomCotitulaire): self
    {
        $this->prenomCotitulaire = $prenomCotitulaire;

        return $this;
    }

    public function getRaisonSocialCotitulaire(): ?string
    {
        return $this->raisonSocialCotitulaire;
    }

    public function setRaisonSocialCotitulaire(string $raisonSocialCotitulaire): self
    {
        $this->raisonSocialCotitulaire = $raisonSocialCotitulaire;

        return $this;
    }

    public function getSexeCotitulaire(): ?string
    {
        return $this->sexeCotitulaire;
    }

    public function setSexeCotitulaire(string $sexeCotitulaire): self
    {
        $this->sexeCotitulaire = $sexeCotitulaire;

        return $this;
    }

    public function getCarteGrise(): ?Cartegrise
    {
        return $this->carteGrise;
    }

    public function setCarteGrise(?Cartegrise $carteGrise): self
    {
        $this->carteGrise = $carteGrise;

        return $this;
    }

    public function getDivn(): ?Divn
    {
        return $this->divn;
    }

    public function setDivn(?Divn $divn): self
    {
        $this->divn = $divn;

        return $this;
    }

    public function getCtvo(): ?Ctvo
    {
        return $this->ctvo;
    }

    public function setCtvo(?Ctvo $ctvo): self
    {
        $this->ctvo = $ctvo;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Entity\File\DemandeCession;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $demande;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateHeureDeLaVente;

    /**
     * @ORM\Column()
     */
    private $numeroDeLaFormulCarteGrise;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserInfos", inversedBy="cessionVendeur", cascade={"persist", "remove"})
     */
    private $vendeur;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserInfos", inversedBy="cessionAcheteur", cascade={"persist", "remove"})
     */
    private $acheteur;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCession;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\File\DemandeCession", inversedBy="cession", cascade={"persist", "remove"})
     */
    private $file;

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



    public function getDateCession(): ?\DateTimeInterface
    {
        return $this->dateCession;
    }

    public function setDateCession(?\DateTimeInterface $dateCession): self
    {
        $this->dateCession = $dateCession;

        return $this;
    }

    public function getFile(): ?DemandeCession
    {
        return $this->file;
    }

    public function setFile(?DemandeCession $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getDateHeureDeLaVente(): ?\DateTimeInterface
    {
        return $this->dateHeureDeLaVente;
    }

    public function setDateHeureDeLaVente(?\DateTimeInterface $dateHeureDeLaVente): self
    {
        $this->dateHeureDeLaVente = $dateHeureDeLaVente;

        return $this;
    }

    public function getNumeroDeLaFormulCarteGrise(): ?string
    {
        return $this->numeroDeLaFormulCarteGrise;
    }

    public function setNumeroDeLaFormulCarteGrise(string $numeroDeLaFormulCarteGrise): self
    {
        $this->numeroDeLaFormulCarteGrise = $numeroDeLaFormulCarteGrise;

        return $this;
    }

    public function getVendeur(): ?UserInfos
    {
        return $this->vendeur;
    }

    public function setVendeur(?UserInfos $vendeur): self
    {
        $this->vendeur = $vendeur;

        return $this;
    }

    public function getAcheteur(): ?UserInfos
    {
        return $this->acheteur;
    }

    public function setAcheteur(?UserInfos $acheteur): self
    {
        $this->acheteur = $acheteur;

        return $this;
    }
}

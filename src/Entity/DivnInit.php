<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DivnInitRepository")
 */
class DivnInit
{
    const GENDERS = [
        "Véhicule particulier (VP)" => 1,
        "Utilitaire (CTTE, Deriv-VP)" => 2,
        "Camion, Bus, Tracteur non agricole (CAM, TCP, TRR)" => 3,
        "Véhicule spécialisé (VASP)" => 4,
        "Moto (MTL, MTT1, MTT2)" => 5,
        "Cyclomoteur <= 50cm3 (CL)" => 6,
        "Quadricycle à moteur (QM) : voiturette, quad, buggy" => 7,
        "Tracteur agricole, quad agricole (TRA)" => 8,
        "Remorque, semi-remorque et caravane (REM, SREM, RESP)" => 9,
        "Tricycle à moteur (TM)" => 10,
        "Cyclomoteurs carrossés à 3 roues (CYCL)" => 11,
    ];

    const ENERGIES = [
        "Essence ou diesel (gasoil) ‘ES’ / ‘GO’" => 1,
        "GPL ou GNV uniquement ‘GP’ / ’GN’" => 2,
        "Electricité uniquement ‘EL’" => 3,
        "Hybride Electricité – essence ‘EE’" => 4,
        "Hybride Electricité – diesel ‘GE’ / ‘OL’" => 4,
        "Hybride Electricité – GPL ‘PE’" => 4,
        "Hybride Electricité – GNV ‘NE’" => 4,
        "Hybride Electricité – Superéthanol ‘FL" => 4,
        "Bioéthanol E85 ‘FE’"  => 5,
        "Bicarburation Essence – GPL ‘EG’" => 6,
        "Bicarburation Essence – GNV ‘EN’" => 6,
        "Bicarburation Superéthanol – GPL ‘FG’" => 6,
        "Bicarburation Superéthanol – GNV ‘FN’" => 6,
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min=1,
     *      max=3
     * )
     */
    private $department;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $genre;

    /**
     * @ORM\Column(type="integer")
     * @Assert\LessThan(
     *      value=90
     * )
     */
    private $puissanceFiscale;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $energie;

    /**
     * @ORM\Column(type="float", length=255)
     */
    private $tauxDeCo2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Marque;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\commande", inversedBy="divnInit", cascade={"all"})
     * @ORM\JoinColumn()
     */
    private $commande;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartment(): ?int
    {
        return $this->department;
    }

    public function setDepartment(int $department): self
    {
        $this->department = $department;

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

    public function getPuissanceFiscale(): ?string
    {
        return $this->puissanceFiscale;
    }

    public function setPuissanceFiscale(string $puissanceFiscale): self
    {
        $this->puissanceFiscale = $puissanceFiscale;

        return $this;
    }

    public function getEnergie(): ?string
    {
        return $this->energie;
    }

    public function setEnergie(string $energie): self
    {
        $this->energie = $energie;

        return $this;
    }

    public function getTauxDeCo2(): ?string
    {
        return $this->tauxDeCo2;
    }

    public function setTauxDeCo2(string $tauxDeCo2): self
    {
        $this->tauxDeCo2 = $tauxDeCo2;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->Marque;
    }

    public function setMarque(string $Marque): self
    {
        $this->Marque = $Marque;

        return $this;
    }

    public function getCommande(): ?commande
    {
        return $this->commande;
    }

    public function setCommande(?commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }
}

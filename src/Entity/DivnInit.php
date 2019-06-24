<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DivnInitRepository")
 */
class DivnInit
{
    const GENDERS = [
        "(VP) Véhicule de tourisme" => "VP", "(CTTE) Véhicule utilitaire / société" => "CTTE", "(Deriv-VP) Véhicule utilitaire / société" => "Deriv-VP", "(MTL) Motocyclette" => "MTL", "(MTT1) Motocyclette" => "MTT1", "(MTT2) Motocyclette" => "MTT2", "(QM) Quad, Voiturette, Quadricycles à moteur" => "QM", "(CL) Cyclomoteur &lt;= 50 cm3" => "CL", "(TM) Tricycles à moteur" => "TM", "(REM) Remorque" => "REM", "(SREM) Semi-remorques" => "SREM", "(RESP) Caravane" => "RESP", "(VASP) Véhicule spécialisé" => "VASP", "(CAM) Camion &gt; 3.5t" => "CAM", "(TCP) Bus &gt; 3.5t" => "TCP", "(TRR) Tracteur routier &gt; 3.5t" => "TRR", "(TRA) Engin agricole" => "TRA", "(Quad) Engin agricole" => "Quad", "(MAGA) Engin agricole" => "MAGA",
        //"VASP35" =>"Camping-car > 3.5 tonnes (VASP-3.5t)</option!-->",
    ];

    const ENERGIES = [
        "Essence (ES)" => "ES", "Essence + gazogène (GE)" => "GE", "Essence + G.P.L. (EG)" => "EG", "Essence + gaz naturel comprimé (EN)" => "EN", "Gazole (GO)" => "GO", "Fuel-oil (FO)" => "FO", "Gazole + gazogène (GG)" => "GG", "Gazogène (GA)" => "GA", "Carburant gazeux (GZ)" => "GZ", "Gaz naturel véhicule (GN)" => "GN", "Électricité (EL)" => "EL", "Gaz de pétrole liquéfié (GP)" => "GP", "Pétrole lampant (PL)" => "PL", "Électricité-essence (EE)" => "EE", "Électricité-gazole (GL)" => "GL", "Air comprimé (AC)" => "AC", "Hydrogène (H2)" => "H2", "Électricité-monocarburation GPL (PE)" => "PE", "Électricité-gaz-naturel (NE)" => "NE", "Superethanol (FE)" => "FE", "Énergie inconnue (IN)" => "IN", "Autre énergie (AU)" => "AU", "Essence + autre énergie (BI)" => "BI",
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $department;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $genre;

    /**
     * @ORM\Column(type="integer", length=255)
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

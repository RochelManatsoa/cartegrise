<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChangementAdresseRepository")
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
}

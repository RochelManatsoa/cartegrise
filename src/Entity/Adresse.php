<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdresseRepository")
 */
class Adresse
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $extension;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adprecision;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typevoie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $complement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieudit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codepostal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $boitepostale;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pays;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Client", mappedBy="clientAdresse", cascade={"persist", "remove"})
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\NewTitulaire", inversedBy="adresseNewTitulaire", cascade={"persist", "remove"})
     */
    private $titulaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vehicule", mappedBy="vehiculeAdresse")
     */
    private $vehicules;

    public function __construct()
    {
        $this->vehicules = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(?int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(?string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getAdprecision(): ?string
    {
        return $this->adprecision;
    }

    public function setAdprecision(?string $adprecision): self
    {
        $this->adprecision = $adprecision;

        return $this;
    }

    public function getTypevoie(): ?string
    {
        return $this->typevoie;
    }

    public function setTypevoie(?string $typevoie): self
    {
        $this->typevoie = $typevoie;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getComplement(): ?string
    {
        return $this->complement;
    }

    public function setComplement(?string $complement): self
    {
        $this->complement = $complement;

        return $this;
    }

    public function getLieudit(): ?string
    {
        return $this->lieudit;
    }

    public function setLieudit(?string $lieudit): self
    {
        $this->lieudit = $lieudit;

        return $this;
    }

    public function getCodepostal(): ?string
    {
        return $this->codepostal;
    }

    public function setCodepostal(?string $codepostal): self
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getBoitepostale(): ?string
    {
        return $this->boitepostale;
    }

    public function setBoitepostale(?string $boitepostale): self
    {
        $this->boitepostale = $boitepostale;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        // set (or unset) the owning side of the relation if necessary
        $newClientAdresse = $client === null ? null : $this;
        if ($newClientAdresse !== $client->getClientAdresse()) {
            $client->setClientAdresse($newClientAdresse);
        }

        return $this;
    }

    public function getTitulaire(): ?NewTitulaire
    {
        return $this->titulaire;
    }

    public function setTitulaire(?NewTitulaire $titulaire): self
    {
        $this->titulaire = $titulaire;

        return $this;
    }

    /**
     * @return Collection|Vehicule[]
     */
    public function getVehicules(): Collection
    {
        return $this->vehicules;
    }

    public function addVehicule(Vehicule $vehicule): self
    {
        if (!$this->vehicules->contains($vehicule)) {
            $this->vehicules[] = $vehicule;
            $vehicule->setVehiculeAdresse($this);
        }

        return $this;
    }

    public function removeVehicule(Vehicule $vehicule): self
    {
        if ($this->vehicules->contains($vehicule)) {
            $this->vehicules->removeElement($vehicule);
            // set the owning side to null (unless already changed)
            if ($vehicule->getVehiculeAdresse() === $this) {
                $vehicule->setVehiculeAdresse(null);
            }
        }

        return $this;
    }

}

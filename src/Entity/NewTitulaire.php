<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewTitulaireRepository")
 */
class NewTitulaire
{
    const TYPE_PERS_PHYSIQUE = 0;
    const TYPE_PERS_MORALE   = 1;
    const GENRE_M   = "M";
    const GENRE_F   = "F";
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomPrenomTitulaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $birthName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Champs requis")
     */
    private $genre;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateN;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieuN;


    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Adresse", mappedBy="titulaire", cascade={"persist", "remove"})
     */
    private $adresseNewTitulaire;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Ctvo", mappedBy="acquerreur", cascade={"persist", "remove"})
     */
    private $ctvo;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Divn", mappedBy="acquerreur", cascade={"persist", "remove"})
     */
    private $divn;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ChangementAdresse", mappedBy="nouveauxTitulaire", cascade={"persist", "remove"})
     */
    private $changementAdresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $raisonSociale;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $societeCommerciale;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $droitOpposition;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siren;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vehicule", mappedBy="Titulaire")
     */
    private $vehicules;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenomTitulaire;

    public function __construct()
    {
        $this->vehicules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPrenomTitulaire(): ?string
    {
        return $this->nomPrenomTitulaire;
    }

    public function setNomPrenomTitulaire(?string $nomPrenomTitulaire): self
    {
        $this->nomPrenomTitulaire = $nomPrenomTitulaire;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDateN(): ?\DateTimeInterface
    {
        return $this->dateN;
    }

    public function setDateN(?\DateTimeInterface $dateN): self
    {
        $this->dateN = $dateN;

        return $this;
    }

    public function getLieuN(): ?string
    {
        return $this->lieuN;
    }

    public function setLieuN(?string $lieuN): self
    {
        $this->lieuN = $lieuN;

        return $this;
    }


    public function getDemande(): ?Demande
    {
        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        $this->demande = $demande;

        // set (or unset) the owning side of the relation if necessary
        $newAcquerreur = $demande === null ? null : $this;
        if ($newAcquerreur !== $demande->getAcquerreur()) {
            $demande->setAcquerreur($newAcquerreur);
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    public function setRaisonSociale(?string $raisonSociale): self
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    public function getSocieteCommerciale(): ?bool
    {
        return $this->societeCommerciale;
    }

    public function setSocieteCommerciale(?bool $societeCommerciale): self
    {
        $this->societeCommerciale = $societeCommerciale;

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
            $vehicule->setTitulaire($this);
        }

        return $this;
    }

    public function removeVehicule(Vehicule $vehicule): self
    {
        if ($this->vehicules->contains($vehicule)) {
            $this->vehicules->removeElement($vehicule);
            // set the owning side to null (unless already changed)
            if ($vehicule->getTitulaire() === $this) {
                $vehicule->setTitulaire(null);
            }
        }

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
        $newAcquerreur = $ctvo === null ? null : $this;
        if ($newAcquerreur !== $ctvo->getAcquerreur()) {
            $ctvo->setAcquerreur($newAcquerreur);
        }

        return $this;
    }

    public function getChangementAdresse(): ?ChangementAdresse
    {
        return $this->changementAdresse;
    }

    public function setChangementAdresse(?ChangementAdresse $changementAdresse): self
    {
        $this->changementAdresse = $changementAdresse;

        // set (or unset) the owning side of the relation if necessary
        $newNouveauxTitulaire = $changementAdresse === null ? null : $this;
        if ($newNouveauxTitulaire !== $changementAdresse->getNouveauxTitulaire()) {
            $changementAdresse->setNouveauxTitulaire($newNouveauxTitulaire);
        }

        return $this;
    }

    public function getAdresseNewTitulaire(): ?Adresse
    {
        return $this->adresseNewTitulaire;
    }

    public function setAdresseNewTitulaire(?Adresse $adresseNewTitulaire): self
    {
        $this->adresseNewTitulaire = $adresseNewTitulaire;

        // set (or unset) the owning side of the relation if necessary
        $newTitulaire = $adresseNewTitulaire === null ? null : $this;
        if ($newTitulaire !== $adresseNewTitulaire->getTitulaire()) {
            $adresseNewTitulaire->setTitulaire($newTitulaire);
        }

        return $this;
    }

    public function getDivn(): ?Divn
    {
        return $this->divn;
    }

    public function setDivn(?Divn $divn): self
    {
        $this->divn = $divn;

        // set (or unset) the owning side of the relation if necessary
        $newAcquerreur = $divn === null ? null : $this;
        if ($newAcquerreur !== $divn->getAcquerreur()) {
            $divn->setAcquerreur($newAcquerreur);
        }

        return $this;
    }

    public function getPrenomTitulaire(): ?string
    {
        return $this->prenomTitulaire;
    }

    public function setPrenomTitulaire(string $prenomTitulaire): self
    {
        $this->prenomTitulaire = $prenomTitulaire;

        return $this;
    }

    public function getDroitOpposition(): ?bool
    {
        return $this->droitOpposition;
    }

    public function setDroitOpposition(?bool $droitOpposition): self
    {
        $this->droitOpposition = $droitOpposition;

        return $this;
    }

    public function getBirthName(): ?string
    {
        return $this->birthName;
    }

    public function setBirthName(string $birthName): self
    {
        $this->birthName = $birthName;

        return $this;
    }
}

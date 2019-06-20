<?php

namespace App\Entity;

use App\Entity\File\Files;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;


/**
 * @ORM\Entity(repositoryClass="App\Repository\DemandeRepository")
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 */
class Demande
{
    const DOC_DOWNLOAD = 'document/';
    const DOC_VALID = 1;
    const DOC_PENDING = 2;
    const DOC_NONVALID = 3;
    const DOC_INVALID_MESSAGE= "Ce lien n'est plus valide";
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean",nullable=true, options={"default" : true})
     * @Groups({"read"})
     */
    private $opposeDemande;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Commande", inversedBy="demande")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;

    /**
     * @ORM\Column(type="string", length=999, nullable=true)
     */
    private $statutDemande;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paiementDemande;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $TmsIdDemande;

    /**
     * @ORM\Column(type="string", length=999, nullable=true)
     */
    private $progressionDemande;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateDemande;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomfic;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fichier", mappedBy="demande", cascade={"remove"})
     */
    private $fichiers;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Ctvo", mappedBy="demande", cascade={"persist", "remove"})
     * @ORM\JoinColumn()
     */
    private $ctvo;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Duplicata", mappedBy="demande", cascade={"persist", "remove"})
     * @ORM\JoinColumn()
     */
    private $duplicata;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Divn", mappedBy="demande", cascade={"persist", "remove"})
     * @ORM\JoinColumn()
     */
    private $divn;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Cession", mappedBy="demande", cascade={"persist", "remove"})
     * @ORM\JoinColumn()
     */
    private $cession;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ChangementAdresse", mappedBy="demande", cascade={"persist", "remove"})
     * @ORM\JoinColumn()
     */
    private $changementAdresse;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Transaction", cascade={"persist", "remove"})
     * @Groups({"read"})
     */
    private $transaction;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $cerfa64;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $cerfa_path;

    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $checker;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $statusDoc;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $motifDeRejet;

    public function __construct()
    {
        $this->fichiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOpposeDemande(): ?bool
    {
        return $this->opposeDemande;
    }

    public function setOpposeDemande(bool $opposeDemande): self
    {
        $this->opposeDemande = $opposeDemande;

        return $this;
    }

    public function getStatutDemande(): ?string
    {
        return $this->statutDemande;
    }

    public function setStatutDemande(string $statutDemande): self
    {
        $this->statutDemande = $statutDemande;

        return $this;
    }

    public function getPaiementDemande(): ?string
    {
        return $this->paiementDemande;
    }

    public function setPaiementDemande(string $paiementDemande): self
    {
        $this->paiementDemande = $paiementDemande;

        return $this;
    }

    public function getTmsIdDemande(): ?int
    {
        return $this->TmsIdDemande;
    }

    public function setTmsIdDemande(?int $TmsIdDemande): self
    {
        $this->TmsIdDemande = $TmsIdDemande;

        return $this;
    }

    public function getProgressionDemande(): ?string
    {
        return $this->progressionDemande;
    }

    public function setProgressionDemande(?string $progressionDemande): self
    {
        $this->progressionDemande = $progressionDemande;

        return $this;
    }

    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->dateDemande;
    }

    public function setDateDemande(?\DateTimeInterface $dateDemande): self
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getNomfic(): ?string
    {
        return $this->nomfic;
    }

    public function setNomfic(?string $nomfic): self
    {
        $this->nomfic = $nomfic;

        return $this;
    }

    /**
     * @return Collection|Fichier[]
     */
    public function getFichiers(): Collection
    {
        return $this->fichiers;
    }

    public function addFichier(Fichier $fichier): self
    {
        if (!$this->fichiers->contains($fichier)) {
            $this->fichiers[] = $fichier;
            $fichier->setDemande($this);
        }

        return $this;
    }

    public function removeFichier(Fichier $fichier): self
    {
        if ($this->fichiers->contains($fichier)) {
            $this->fichiers->removeElement($fichier);
            // set the owning side to null (unless already changed)
            if ($fichier->getDemande() === $this) {
                $fichier->setDemande(null);
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
        $ctvo->setDemande($this);

        return $this;
    }

    public function getDuplicata(): ?Duplicata
    {
        return $this->duplicata;
    }

    public function setDuplicata(?Duplicata $duplicata): self
    {
        $this->duplicata = $duplicata;

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
        $newDemande = $divn === null ? null : $this;
        if ($newDemande !== $divn->getDemande()) {
            $divn->setDemande($newDemande);
        }

        return $this;
    }

    public function getCession(): ?Cession
    {
        return $this->cession;
    }

    public function setCession(?Cession $cession): self
    {
        $this->cession = $cession;

        // set (or unset) the owning side of the relation if necessary
        $newDemande = $cession === null ? null : $this;
        if ($newDemande !== $cession->getDemande()) {
            $cession->setDemande($newDemande);
        }

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getGeneratedCerfaPath(): ?string
    {
        $path = $this::DOC_DOWNLOAD . $this->id ."/".
            $this->commande->getImmatriculation(). '-' .
            $this->commande->getCodePostal();

        return $path;
    }

    public function getGeneratedCerfaPathFile(): ?string
    {

        return $this->getGeneratedCerfaPath().'/cerfa.pdf';
    }

    public function getUploadPath()
    {
        return $this->getGeneratedCerfaPath();
    }

    public function getCerfa64(): ?string
    {
        return $this->cerfa64;
    }

    public function setCerfa64(?string $cerfa64): self
    {
        $this->cerfa64 = $cerfa64;

        return $this;
    }

    public function getCerfaPath(): ?string
    {
        return $this->cerfa_path;
    }

    public function setCerfaPath(?string $cerfa_path): self
    {
        $this->cerfa_path = $cerfa_path;

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
        $newDemande = $changementAdresse === null ? null : $this;
        if ($newDemande !== $changementAdresse->getDemande()) {
            $changementAdresse->setDemande($newDemande);
        }

        return $this;
    }

    public function getFiles(): ?Files
    {
        return $this->files;
    }

    public function setFiles(?Files $files): self
    {
        $this->files = $files;

        return $this;
    }


    public function getTransaction(): ?Transaction
    {
        return $this->transaction;
    }

    public function setTransaction(?Transaction $transaction): self
    {
        $this->transaction = $transaction;

        // set (or unset) the owning side of the relation if necessary
        $newDemande = $transaction === null ? null : $this;
        if ($newDemande !== $transaction->getDemande()) {
            $transaction->setDemande($newDemande);
        }

        return $this;
    }

    public function getChecker(): ?string
    {
        return $this->checker;
    }

    public function setChecker(?string $checker): self
    {
        $this->checker = $checker;

        return $this;
    }

    public function getStatusDoc(): ?string
    {
        return $this->statusDoc;
    }

    public function setStatusDoc(?string $statusDoc): self
    {
        $this->statusDoc = $statusDoc;

        return $this;
    }

    public function getMotifDeRejet(): ?string
    {
        return $this->motifDeRejet;
    }

    public function setMotifDeRejet(?string $motifDeRejet): self
    {
        $this->motifDeRejet = $motifDeRejet;

        return $this;
    }

    public function getDocInvalidMessage():string
    {
        return $this::DOC_INVALID_MESSAGE;
    }
}

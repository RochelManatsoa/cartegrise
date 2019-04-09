<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
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
    private $clientNom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $clientPrenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $clientGenre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $clientNomUsage;

    /**
     * @ORM\Column(type="date")
     */
    private $clientDateNaissance;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Contact", cascade={"persist", "remove"})
     */
    private $clientContact;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fichier", mappedBy="client")
     */
    private $fichiers;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Adresse", inversedBy="client", cascade={"persist", "remove"})
     */
    private $clientAdresse;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Commande", mappedBy="client")
     */
    private $commandes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $clientLieuNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $clientDptNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $clientPaysNaissance;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="client", cascade={"persist", "remove"})
     */
    private $user;



    public function __construct()
    {
        $this->fichiers = new ArrayCollection();
        $this->commande = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getClientNom();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientNom(): ?string
    {
        return $this->clientNom;
    }

    public function setClientNom(string $clientNom): self
    {
        $this->clientNom = $clientNom;

        return $this;
    }

    public function getClientPrenom(): ?string
    {
        return $this->clientPrenom;
    }

    public function setClientPrenom(string $clientPrenom): self
    {
        $this->clientPrenom = $clientPrenom;

        return $this;
    }

    public function getClientGenre(): ?string
    {
        return $this->clientGenre;
    }

    public function setClientGenre(string $clientGenre): self
    {
        $this->clientGenre = $clientGenre;

        return $this;
    }

    public function getClientNomUsage(): ?string
    {
        return $this->clientNomUsage;
    }

    public function setClientNomUsage(string $clientNomUsage): self
    {
        $this->clientNomUsage = $clientNomUsage;

        return $this;
    }

    public function getClientDateNaissance(): ?\DateTimeInterface
    {
        return $this->clientDateNaissance;
    }

    public function setClientDateNaissance(\DateTimeInterface $clientDateNaissance): self
    {
        $this->clientDateNaissance = $clientDateNaissance;

        return $this;
    }

    public function getClientContact(): ?Contact
    {
        return $this->clientContact;
    }

    public function setClientContact(?Contact $clientContact): self
    {
        $this->clientContact = $clientContact;

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
            $fichier->setClient($this);
        }

        return $this;
    }

    public function removeFichier(Fichier $fichier): self
    {
        if ($this->fichiers->contains($fichier)) {
            $this->fichiers->removeElement($fichier);
            // set the owning side to null (unless already changed)
            if ($fichier->getClient() === $this) {
                $fichier->setClient(null);
            }
        }

        return $this;
    }

    public function getClientAdresse(): ?Adresse
    {
        return $this->clientAdresse;
    }

    public function setClientAdresse(?Adresse $clientAdresse): self
    {
        $this->clientAdresse = $clientAdresse;

        return $this;
    }

    
    public function getClientLieuNaissance(): ?string
    {
        return $this->clientLieuNaissance;
    }

    public function setClientLieuNaissance(string $clientLieuNaissance): self
    {
        $this->clientLieuNaissance = $clientLieuNaissance;

        return $this;
    }

    public function getClientDptNaissance(): ?int
    {
        return $this->clientDptNaissance;
    }

    public function setClientDptNaissance(int $clientDptNaissance): self
    {
        $this->clientDptNaissance = $clientDptNaissance;

        return $this;
    }

    public function getClientPaysNaissance(): ?string
    {
        return $this->clientPaysNaissance;
    }

    public function setClientPaysNaissance(string $clientPaysNaissance): self
    {
        $this->clientPaysNaissance = $clientPaysNaissance;

        return $this;
    }


    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->addClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            $commande->removeClient($this);
        }

        return $this;
    }

    public function getListDemande()
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->gt('clientNom', 20))
            ->orderBy(['clientNom', 'DESC']);
        return $this->getGenusScientists()->matching($criteria);
    }

    public function getCountDem()
    {
        // $criteria = Criteria::create('c')
        // ->join('c.commandes as com')
        // ->andWhere('com.demandes');
        // return $this->getCommandes()->matching($criteria)->count();
        return 4;
    }

    public function getCountCommandes() {

        return 0 < count($this->commandes) ? count($this->commandes) : 0;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        $newClient = $user === null ? null : $this;
        if ($newClient !== $user->getClient()) {
            $user->setClient($newClient);
        }

        return $this;
    }

}

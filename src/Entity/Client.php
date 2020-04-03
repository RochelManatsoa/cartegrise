<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 *  @ApiResource(
 *     forceEager= false,
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write", "register"}}
 * )
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"info_user"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"info_user", "register"})
     */
    private $clientNom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"info_user", "register"})
     */
    private $clientPrenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"info_user", "register"})
     */
    private $clientGenre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"register"})
     */
    private $clientNomUsage;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"info_user", "register"})
     */
    private $clientDateNaissance;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Contact", cascade={"persist", "remove"})
     * @Groups({"register"})
     */
    private $clientContact;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fichier", mappedBy="client")
     */
    private $fichiers;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Adresse", mappedBy="client", cascade={"persist", "remove"})
     * @ORM\JoinColumn()
     * @Groups({"info_user", "register"})
     */
    private $clientAdresse;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commande", mappedBy="client")
     */
    private $commandes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"write"})
     */
    private $clientLieuNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"write"})
     */
    private $clientDptNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"register"})
     */
    private $clientPaysNaissance;

    /**
     * @ORM\Column(type="integer", options={"default":0})
     */
    private $countCommande;

    /**
     * @ORM\Column(type="integer", options={"default":0})
     */
    private $countDemande;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $relanceLevel;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="client", cascade={"persist", "remove"})
     * @Groups({"read"})
     */
    private $user;

    /**
     * @var \DateTime $deletedAt
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;



    public function __construct()
    {
        $this->fichiers = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->countDemande = 0;
        $this->countCommande = 0;
        $this->relanceLevel = 0;
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
        return $this->getRemanance() . $this->clientNom;
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

    public function getTotalCommandes()
    {
        return $this->getCommandes()->count();
    }

    public function addCommande(Commande $commande): self
    {
        if ($commande->getClient() === null){
            if (!$this->commandes->contains($commande)) {
                $this->commandes[] = $commande;
                $commande->setClient($this);
            }
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            $commande->setClient(null);
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

    public function getClientNomPrenom()
    {

        return $this->clientNom . ' ' .$this->clientPrenom;
    }

    public function getCountCommande(): ?int
    {
        return $this->countCommande;
    }

    public function setCountCommande(?int $countCommande): self
    {
        $this->countCommande = $countCommande;

        return $this;
    }

    public function getCountDemande(): ?int
    {
        return $this->countDemande;
    }

    public function setCountDemande(?int $countDemande): self
    {
        $this->countDemande = $countDemande;

        return $this;
    }

    public function getRelanceLevel(): ?int
    {
        return $this->relanceLevel;
    }

    public function setRelanceLevel(?int $relanceLevel): self
    {
        $this->relanceLevel = $relanceLevel;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getRemanance(){
        if (empty($this->getCommandes())) return "";
        $commandes = $this->getCommandes()->filter(function(Commande $commande) {
            return $commande->getFacture() !== null;
        });
        return count($commandes) >= 3 ? "*" : "";
    }

}

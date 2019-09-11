<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdresseRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 *  @ApiResource(
 *     forceEager= false,
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write", "register"}}
 * )
 */
class Adresse
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"info_user"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(min=1, max=4)
     * @Groups({"info_user", "register"})
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"register"})
     */
    private $extension;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"register"})
     */
    private $adprecision;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull( message="Ce champs est requis")
     * @Groups({"info_user", "register"})
     */
    private $typevoie;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull( message="Ce champs est requis")
     * @Groups({"info_user", "register"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"info_user", "register"})
     */
    private $complement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"info_user", "register"})
     */
    private $lieudit;

    /**
     * @Assert\Regex("/^[0-9]{5}$/")
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"info_user", "register"})
     */
    private $codepostal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"info_user", "register"})
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"info_user", "register"})
     */
    private $boitepostale;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"info_user", "register"})
     */
    private $pays;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Client", inversedBy="clientAdresse")
     * @ORM\JoinColumn()
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\NewTitulaire", inversedBy="adresseNewTitulaire", cascade={"persist", "remove"})
     */
    private $titulaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vehicule", inversedBy="adresse")
     */
    private $vehicules;

    /**
     * @var \DateTime $deletedAt
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    public function __construct()
    {
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

    public function getVehicules(): ?Vehicule
    {
        return $this->vehicules;
    }

    public function setVehicules(?Vehicule $vehicules): self
    {
        $this->vehicules = $vehicules;

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


}

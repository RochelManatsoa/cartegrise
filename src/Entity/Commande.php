<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 */
class Commande
{
    use \App\Manager\TraitList\CommandeStatusTrait;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min=1,
     *      max=3
     * )
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $immatriculation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeDemande", inversedBy="commandes")
     * @Groups("read")
     */
    private $demarche;

    /**
     * @ORM\Column(type="datetime")
     */
    private $ceerLe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="commandes")
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity="Taxes", mappedBy="commande", cascade={"all"})
     */
    private $taxes;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Demande", mappedBy="commande", cascade={"all"})
     * @ORM\JoinColumn()
     * @Groups({"read"})
     */
    private $demande;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\DivnInit", mappedBy="commande", cascade={"all"})
     * @ORM\JoinColumn()
     */
    private $divnInit;

    /**
     * @ORM\OneToOne(targetEntity="CarInfo", mappedBy="commande", cascade={"persist", "remove"})
     */
    private $carInfo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $saved;

    /**
     * @ORM\Column(nullable=true)
     */
    private $tmsId;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tmsSaveResponse;


    public function __construct()
    {
        $this->saved = false;
    }

    public function getStatus()
    {
        return $this->getStatusOfCommande($this)['text'];
    }

    public function __tostring(){
        return $this->codePostal . $this->immatriculation;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getDemarche(): ?TypeDemande
    {
        return $this->demarche;
    }

    public function setDemarche(?TypeDemande $demarche): self
    {
        $this->demarche = $demarche;

        return $this;
    }

    public function getCeerLe(): ?\DateTimeInterface
    {
        return $this->ceerLe;
    }

    public function setCeerLe(\DateTimeInterface $ceerLe): self
    {
        $this->ceerLe = $ceerLe;

        return $this;
    }

    public function getClientFacture()
    {
        return $this->getFirstClient();
    }

    public function removeClient(Client $client): self
    {
        if ($this->client->contains($client)) {
            $this->client->removeElement($client);
        }

        return $this;
    }

    public function getTaxes(): ?Taxes
    {
        return $this->taxes;
    }

    public function setTaxes(?Taxes $taxes): self
    {
        $this->taxes = $taxes;

        // set (or unset) the owning side of the relation if necessary
        $newCommande = $taxes === null ? null : $this;
        if ($newCommande !== $taxes->getCommande()) {
            $taxes->setCommande($newCommande);
        }

        return $this;
    }

    public function getCarInfo(): ?CarInfo
    {
        return $this->carInfo;
    }

    public function setCarInfo(?CarInfo $carInfo): self
    {
        $this->carInfo = $carInfo;
        if ($carInfo instanceof CarInfo) {
            $carInfo->setCommande($this);
        }

        return $this;
    }

    public function getDemande(): ?Demande
    {
        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        $this->demande = $demande;

        if ($demande instanceof Demande) {
            $demande->setCommande($this);
        }

        return $this;
    }

    public function getDivnInit(): ?DivnInit
    {
        return $this->divnInit;
    }

    public function setDivnInit(?DivnInit $divnInit): self
    {
        $this->divnInit = $divnInit;
        $divnInit->setCommande($this);

        return $this;
    }

    public function getFirstClient()
    {
        return $this->client;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prepersist()
    {
        $client = $this->getFirstClient();
        if (!is_null($client) && is_object($client))
            $client->setCountCommande($client->getCountCommande() + 1);
    }

    public function getSaved(): ?bool
    {
        return $this->saved;
    }

    public function setSaved(?bool $saved): self
    {
        $this->saved = $saved;

        return $this;
    }

    public function getTmsId(): ?string
    {
        return $this->tmsId;
    }

    public function setTmsId(?string $tmsId): self
    {
        $this->tmsId = $tmsId;

        return $this;
    }

    public function getTmsSaveResponse(): ?string
    {
        return $this->tmsSaveResponse;
    }

    public function setTmsSaveResponse(?string $tmsSaveResponse): self
    {
        $this->tmsSaveResponse = $tmsSaveResponse;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

}

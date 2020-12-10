<?php

namespace App\Entity;

use App\Entity\GesteCommercial\GesteCommercial;
use App\Entity\Systempay\Transaction as SystempayTransaction;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}},
 *     attributes={"force_eager"=false}
 * )
 * @ApiFilter(DateFilter::class, properties={"ceerLe"})
 */
class Commande
{
    use \App\Manager\TraitList\CommandeStatusTrait;

    const DOC_DOWNLOAD = 'document/';
    const RETRACT_DEMAND = 7;
    const RETRACT_REFUND = 8;
    const RETRACT_FORM_WAITTING = 9;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read", "api"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min=1,
     *      max=3
     * )
     * @Groups({"api"})
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api"})
     */
    private $immatriculation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prevClient;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $deletorUser;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeDemande", inversedBy="commandes")
     * @Groups({"read", "api"})
     */
    private $demarche;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read", "api"})
     */
    private $ceerLe;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $fourthChange;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="commandes")
     * @ORM\JoinColumn()
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity="Taxes", mappedBy="commande", cascade={"all"})
     * @Groups({"api"})
     */
    private $taxes;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Demande", mappedBy="commande", cascade={"all"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @Groups({"read"})
     */
    private $demande;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\DivnInit", mappedBy="commande", cascade={"all"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $divnInit;

    /**
     * @ORM\OneToOne(targetEntity="CarInfo", mappedBy="commande", cascade={"persist", "remove"})
     * @Groups({"api"})
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
    
    /**
     * comment about the command variable
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;
    
    /**
     * commision about the command partner
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commission;

    /**
     * @var \DateTime $deletedAt
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Systempay\Transaction", inversedBy="commande", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @Groups({"read"})
     */
    private $systempayTransaction;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Transaction", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @Groups({"read"})
     */
    private $transaction;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Notification", mappedBy="commande", cascade={"persist", "remove"})
     */
    private $notification;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Facture", mappedBy="commande", cascade={"persist", "remove"})
     */
    private $facture;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\InfosFacture", mappedBy="commande", cascade={"persist", "remove"})
     */
    private $infosFacture;

    /**
     * @ORM\Column(type="boolean", nullable=true,  options={"default" : false})
     */
    private $paymentOk;

    /**
     * @ORM\Column(nullable=true,  options={"default" : null})
     */
    private $statusTmp;


    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Avoir", mappedBy="commande", cascade={"persist", "remove"})
     */
    private $avoir;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\GesteCommercial\GesteCommercial", mappedBy="commande", cascade={"persist", "remove"})
     */
    private $gesteCommercial;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $fraisRembourser;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $remindPayment;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $remindFailedTransaction;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $remindDemande;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $remindDocument;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $remindPaymentDate;

    

    /**
     * @ORM\Column(nullable=true)
     */
    private $dayIp;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partner", inversedBy="commande")
     * @ORM\JoinColumn()
     */
    private $partner;



    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->ceerLe = new \DateTime();
    }


    public function __construct()
    {
        $this->saved = false;
    }

    public function getStatus()
    {
        if (array_key_exists("text", $this->getStatusOfCommande($this))){
            return $this->getStatusOfCommande($this)['text'];
        }
        return "";
        
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
        $this->immatriculation = strtoupper($immatriculation);

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
        if ($this->client === null) {
            $this->client = $client;
        }

        return $this;
    }

    public function getFourthChange(): ?bool
    {
        return $this->fourthChange;
    }

    public function setFourthChange(?bool $fourthChange): self
    {
        $this->fourthChange = $fourthChange;

        return $this;
    }

    public function getPrevClient(): ?int
    {
        return $this->prevClient;
    }

    public function setPrevClient(?int $prevClient): self
    {
        $this->prevClient = $prevClient;

        return $this;
    }

    public function getDeletorUser(): ?int
    {
        return $this->deletorUser;
    }

    public function setDeletorUser(?int $deletorUser): self
    {
        $this->deletorUser = $deletorUser;

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

    public function getTransaction(): ?Transaction
    {
        return $this->transaction;
    }

    public function setTransaction(?Transaction $transaction): self
    {
        $this->transaction = $transaction;

        return $this;
    }

    public function getNotification(): ?Notification
    {
        return $this->notification;
    }

    public function setNotification(?Notification $notification): self
    {
        $this->notification = $notification;

        // set (or unset) the owning side of the relation if necessary
        $newCommande = null === $notification ? null : $this;
        if ($notification->getCommande() !== $newCommande) {
            $notification->setCommande($newCommande);
        }

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): self
    {
        $this->facture = $facture;

        // set (or unset) the owning side of the relation if necessary
        $newCommande = null === $facture ? null : $this;
        if ($facture->getCommande() !== $newCommande) {
            $facture->setCommande($newCommande);
        }

        return $this;
    }

    public function getPaymentOk(): ?bool
    {
        return $this->paymentOk;
    }

    public function setPaymentOk(?bool $paymentOk): self
    {
        $this->paymentOk = $paymentOk;

        return $this;
    }

    public function getGeneratedCerfaPath(): ?string
    {
        $path = $this::DOC_DOWNLOAD . $this->id ."/".
            $this->immatriculation. '-' .
            $this->codePostal;

        return $path;
    }

    public function getGeneratedFacturePathFile(): ?string
    {

        return $this->getGeneratedCerfaPath().'/facture.pdf';
    }

    public function getInfosFacture(): ?InfosFacture
    {
        return $this->infosFacture;
    }

    public function setInfosFacture(?InfosFacture $infosFacture): self
    {
        $this->infosFacture = $infosFacture;

        // set (or unset) the owning side of the relation if necessary
        $newCommande = null === $infosFacture ? null : $this;
        if ($infosFacture->getCommande() !== $newCommande) {
            $infosFacture->setCommande($newCommande);
        }

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getStatusTmp()
    {
        return $this->statusTmp ;
    }

    /**
     * function setStatusTmp
     *
     * @param string $status
     * @return void
     */
    public function setStatusTmp(string $status)
    {
        $this->statusTmp = $status;
    }

    public function getAvoir(): ?Avoir
    {
        return $this->avoir;
    }

    public function setAvoir(?Avoir $avoir): self
    {
        $this->avoir = $avoir;

        // set (or unset) the owning side of the relation if necessary
        $newCommande = null === $avoir ? null : $this;
        if ($avoir->getCommande() !== $newCommande) {
            $avoir->setCommande($newCommande);
        }

        return $this;
    }

    public function getGeneratedAvoirCerfaPath(): ?string
    {
        $path = $this::DOC_DOWNLOAD . $this->id ."commande/".
            $this->getImmatriculation(). '-' .
            $this->getCodePostal();

        return $path;
    }

    public function getGeneratedAvoirPathFile(): ?string
    {

        return $this->getGeneratedAvoirCerfaPath().'/avoir.pdf';
    }


    public function getFraisRembourser()
    {
        return $this->fraisRembourser;
    }

    public function setFraisRembourser($fraisRembourser): self
    {
        $this->fraisRembourser = $fraisRembourser;

        return $this;
    }

    public function getSystempayTransaction(): ?SystempayTransaction
    {
        return $this->systempayTransaction;
    }

    public function setSystempayTransaction(?SystempayTransaction $systempayTransaction): self
    {
        $this->systempayTransaction = $systempayTransaction;

        if ($systempayTransaction->getCommande() === null) {
            $systempayTransaction->setCommande($this);
            $systempayTransaction->setCommandeStringId($this->getId());
        }

        return $this;
    }

    public function getReferenceClient(){
        $num = $this->getClient()->getId();
        $string = '0';
        $length = 5;
        $numlength = strlen((string)$num);
        $restLength = $length - $numlength;
        for($i= 0; $i < $restLength; $i++) {
            $num =$string . (string)$num;
        }
        $dateRegister = $this->getClient()->getUser()->getRegisterDate()->format('y');

        return $num . $dateRegister;
    }

    public function getGesteCommercial(): ?GesteCommercial
    {
        return $this->gesteCommercial;
    }

    public function setGesteCommercial(?GesteCommercial $gesteCommercial): self
    {
        $this->gesteCommercial = $gesteCommercial;

        // set (or unset) the owning side of the relation if necessary
        $newCommande = null === $gesteCommercial ? null : $this;
        if ($gesteCommercial->getCommande() !== $newCommande) {
            $gesteCommercial->setCommande($newCommande);
        }

        return $this;
    }

    public function getContentFormatter(){
        return $this->comment;
    }
    public function getRawContent(){
        return $this->comment;
    }

    public function getRemindPayment(): ?int
    {
        return $this->remindPayment;
    }

    public function setRemindPayment(?int $remindPayment): self
    {
        $this->remindPayment = $remindPayment;

        return $this;
    }

    public function getRemindPaymentDate(): ?\DateTimeInterface
    {
        return $this->remindPaymentDate;
    }

    public function setRemindPaymentDate(?\DateTimeInterface $remindPaymentDate): self
    {
        $this->remindPaymentDate = $remindPaymentDate;

        return $this;
    }

    public function getRemindFailedTransaction(): ?int
    {
        return $this->remindFailedTransaction;
    }

    public function setRemindFailedTransaction(?int $remindFailedTransaction): self
    {
        $this->remindFailedTransaction = $remindFailedTransaction;

        return $this;
    }

    public function getRemindDemande(): ?int
    {
        return $this->remindDemande;
    }

    public function setRemindDemande(?int $remindDemande): self
    {
        $this->remindDemande = $remindDemande;

        return $this;
    }

    public function getRemindDocument(): ?int
    {
        return $this->remindDocument;
    }

    public function setRemindDocument(?int $remindDocument): self
    {
        $this->remindDocument = $remindDocument;

        return $this;
    }

    public function getDayIp(): ?string
    {
        return $this->dayIp;
    }

    public function setDayIp(?string $dayIp): self
    {
        $this->dayIp = $dayIp;

        return $this;
    }

    public function getPartner(): ?Partner
    {
        return $this->partner;
    }

    public function setPartner(?Partner $partner): self
    {
        $this->partner = $partner;

        return $this;
    }

    public function getCommission(): ?string
    {
        return $this->commission;
    }

    public function setCommission(?string $commission): self
    {
        $this->commission = $commission;

        return $this;
    }

}

<?php

namespace App\Entity\Systempay;

use App\Entity\Commande;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="systempay_transaction")
 * @ORM\Entity()
 */
class Transaction
{
    const TRANSACTION_SUCCESS = 'AUTHORISED';
    const MULTI_PROPOSE_UP = 135;
    /**
     * @var
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="status_code", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @var int
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var int
     * @ORM\Column(name="currency", type="integer")
     */
    private $currency;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var string
     * @ORM\Column(name="log_response", type="text", nullable=true)
     */
    private $logResponse;

    /**
     * @var bool
     * @ORM\Column(name="paid", type="boolean")
     */
    private $paid;

    /**
     * @var bool
     * @ORM\Column(name="refunded", type="boolean")
     */
    private $refunded;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Commande", mappedBy="systempayTransaction")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @Groups({"read"})
     */
    private $commande;

    /**
     * @ORM\Column(nullable=true)
     * @Groups({"read"})
     */
    private $commandeStringId;

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param int $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLogResponse()
    {
        return $this->logResponse;
    }

    /**
     * @param string $logResponse
     */
    public function setLogResponse($logResponse)
    {
        $this->logResponse = $logResponse;
    }

    /**
     * @return boolean
     */
    public function isPaid()
    {
        return $this->paid;
    }

    /**
     * @param boolean $paid
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;
    }

    /**
     * @return boolean
     */
    public function isRefunded()
    {
        return $this->refunded;
    }

    /**
     * @param boolean $refunded
     */
    public function setRefunded($refunded)
    {
        $this->refunded = $refunded;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function getPaid(): ?bool
    {
        return $this->paid;
    }

    public function getRefunded(): ?bool
    {
        return $this->refunded;
    }

    public function getCommandeStringId(): ?string
    {
        return $this->commandeStringId;
    }

    public function setCommandeStringId(?string $commandeStringId): self
    {
        $this->commandeStringId = $commandeStringId;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }



}

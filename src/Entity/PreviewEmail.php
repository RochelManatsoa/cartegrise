<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PreviewEmailRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class PreviewEmail
{
    // type of email to send
    const MAIL_RELANCE_DEMARCHE = 0;
    const MAIL_RELANCE_PAIEMENT = 1;
    const MAIL_RELANCE_FORMULAIRE = 2;
    const MAIL_RELANCE_UPLOAD = 3;
    const MAIL_RELANCE_DONE = 4;
    // type of status of entity
    const STATUS_PENDING= 0;
    const STATUS_SENT= 1;
    // types of email valid : 
    const TYPES_EMAILS = [
        0 => "Mail Relance Démarche",
        1 => "Mail Relance Paiement",
        2 => "Mail Relance Formulaire",
        3 => "Mail Relance Upload",
        4 => "Mail Relance Ok",
    ];
    // types of email for form : 
    const TYPES_EMAILS_FORM = [
        "Mail Relance Démarche" => 0,
        "Mail Relance Paiement" => 1,
        "Mail Relance Formulaire" => 2,
        "Mail Relance Upload" => 3,
        "Mail Relance Ok" => 4,
    ];
    // types of email valid : 
    const STATUS = [
        0 => "En atttente",
        1 => "Envoyer"
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="string")
     */
    private $immatriculation;

    /**
     * @ORM\Column(type="integer")
     */
    private $typeEmail;

    /**
     * 
     */
    private $typeEmailString;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $commande;

    /**
     * @var \DateTime $deletedAt
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $sendAt;

    public function __construct() {
        $this->createdAt = new \DateTime();
        $this->sendAt = (new \DateTime())->modify("+1 day");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

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

    public function getTypeEmail(): ?int
    {
        return $this->typeEmail;
    }

    public function setTypeEmail(int $typeEmail): self
    {
        $this->typeEmail = $typeEmail;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSendAt(): ?\DateTimeInterface
    {
        return $this->sendAt;
    }

    public function setSendAt(?\DateTimeInterface $sendAt): self
    {
        $this->sendAt = $sendAt;

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


    /**
     * function to return string of type email to send
     *
     * @return void
     */
    public function getTypeEmailString() {
        return self::TYPES_EMAILS[$this->typeEmail];
    }

    /**
     * function to return string of type email to send
     *
     * @return void
     */
    public function getStatusString() {
        return self::STATUS[$this->status];
    }

    
}

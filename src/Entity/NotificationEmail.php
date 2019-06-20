<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificationEmailRepository")
 */
class NotificationEmail
{
    const PAIMENT_NOTIF = "notification de paiement";
    const FILE_NOTIF = "notification de validation dossier ";
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $keyConf;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $valueConf = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKeyConf(): ?string
    {
        return $this->keyConf;
    }

    public function setKeyConf(string $keyConf): self
    {
        $this->keyConf = $keyConf;

        return $this;
    }

    public function getValueConf(): ?array
    {
        return $this->valueConf;
    }

    public function setValueConf(?array $valueConf): self
    {
        $this->valueConf = $valueConf;

        return $this;
    }
}

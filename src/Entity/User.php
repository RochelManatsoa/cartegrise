<?php
// src/AppBundle/Entity/User.php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 *  @ApiResource(
 *     attributes={"filters"={"offer.order_filter"}},
 *     forceEager= false,
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"read"})
     */
    protected $id;

    /**
    * @ORM\Column(type="datetime", nullable=true)
    * @Groups({"read"})
    */
    private $registerDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $franceConnectId;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Client",inversedBy="user", cascade={"persist", "remove"})
     * @Groups({"read"})
     */
    private $client;


    public function __construct()
    {
        parent::__construct();
        // your own logic
        if (empty($this->registerDate)) {
            $this->registerDate = new \DateTime();
        }
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegisterDate(): ?\DateTimeInterface
    {
        return $this->registerDate;
    }

    public function setRegisterDate(?\DateTimeInterface $registerDate): self
    {
        $this->registerDate = $registerDate;

        return $this;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getFranceConnectId(): ?string
    {
        return $this->franceConnectId;
    }

    public function setFranceConnectId(?string $franceConnectId): self
    {
        $this->franceConnectId = $franceConnectId;

        return $this;
    }

}
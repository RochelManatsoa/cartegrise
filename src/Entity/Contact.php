<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 *  @ApiResource(
 *     forceEager= false,
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write", "register"}}
 * )
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read", "register"})
     */
    private $id;

    /**
     * @Assert\Regex("^0[1-68][0-9]{8}$")
     * @ORM\Column(type="string", length=255)
     * @Groups({"read", "register"})
     */
    private $contact_telmobile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read", "register"})
     */
    private $contact_telfixe;

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
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getContactTelmobile(): ?string
    {
        return $this->contact_telmobile;
    }

    public function setContactTelmobile(string $contact_telmobile): self
    {
        $this->contact_telmobile = $contact_telmobile;

        return $this;
    }

    public function getContactTelfixe(): ?string
    {
        return $this->contact_telfixe;
    }

    public function setContactTelfixe(?string $contact_telfixe): self
    {
        $this->contact_telfixe = $contact_telfixe;

        return $this;
    }

}

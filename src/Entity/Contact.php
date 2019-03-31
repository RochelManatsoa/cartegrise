<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
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
    private $contact_telmobile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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

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

    /**
     * @return mixed
     */
    public function getContactTelmobile()
    {
        return $this->contact_telmobile;
    }

    /**
     * @param mixed $contact_telmobile
     */
    public function setContactTelmobile($contact_telmobile): void
    {
        $this->contact_telmobile = $contact_telmobile;
    }

    /**
     * @return mixed
     */
    public function getContactTelfixe()
    {
        return $this->contact_telfixe;
    }

    /**
     * @param mixed $contact_telfixe
     */
    public function setContactTelfixe($contact_telfixe): void
    {
        $this->contact_telfixe = $contact_telfixe;
    }


}

<?php

namespace App\Entity;

use PhpParser\Builder\Property;
use Symfony\Component\Validator\Constraints as Assert;

class ContactForm
{
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2,max=100)
     */
    private $firstname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2,max=100)
     */
    private $lastname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Regex(
     *      pattern=*/[0-9]{10)/*
     * )
     */
    private $phone;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=10)
     */
    private $message;

    /**
     * @return null|Property
     */
    public function getProperty(): ?Property
    {
        return $this->property;
    }

    /**
     * @param null|Property $property
     * @return ContactForm
     */
    public function setProperty(?Property $property): ContactForm
    {
        $this->property = $property;
        return $this;
    }

    /**
     * @var Property|null
     */
    private $property;

    /**
     * @return null|string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param null|string $firstname
     * @return ContactForm
     */
    public function setFirstname(?string $firstname): ContactForm
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param null|string $lastname
     * @return ContactForm
     */
    public function setLastname(?string $lastname): ContactForm
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return ContactForm
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     * @return ContactForm
     */
    public function setEmail(?string $email): ContactForm
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param null|string $message
     * @return ContactForm
     */
    public function setMessage(?string $message): ContactForm
    {
        $this->message = $message;
        return $this;
    }


}

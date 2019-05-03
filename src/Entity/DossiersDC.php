<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DossiersDCRepository")
 */
class DossiersDC
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cerfa;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Cession", inversedBy="dossiersDC", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $dc;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCerfa(): ?string
    {
        return $this->cerfa;
    }

    public function setCerfa(?string $cerfa): self
    {
        $this->cerfa = $cerfa;

        return $this;
    }

    public function getDc(): ?Cession
    {
        return $this->dc;
    }

    public function setDc(Cession $dc): self
    {
        $this->dc = $dc;

        return $this;
    }
}

<?php
namespace App\Entity\Vehicule;

use App\Entity\Divn;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Vehicule\CarrosierVehiculeNeufRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class CarrosierVehiculeNeuf
{
    const PERSONE_PHYSIQUE  = "phy";
    const PERSONE_MORALE    = "mor";
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Divn", mappedBy="corrosier", cascade={"persist", "remove"})
     * @ORM\JoinColumn()
     */
    private $divn;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $agrement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeCarrossier;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomCarrosssier;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenomCarrossier;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $raisonSocialCarrossier;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $justificatifs;

    /**
     * @var \DateTime $deletedAt
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgrement(): ?string
    {
        return $this->agrement;
    }

    public function setAgrement(?string $agrement): self
    {
        $this->agrement = $agrement;

        return $this;
    }

    public function getTypeCarrossier(): ?string
    {
        return $this->typeCarrossier;
    }

    public function setTypeCarrossier(?string $typeCarrossier): self
    {
        $this->typeCarrossier = $typeCarrossier;

        return $this;
    }

    public function getNomCarrosssier(): ?string
    {
        return $this->nomCarrosssier;
    }

    public function setNomCarrosssier(?string $nomCarrosssier): self
    {
        $this->nomCarrosssier = $nomCarrosssier;

        return $this;
    }

    public function getPrenomCarrossier(): ?string
    {
        return $this->prenomCarrossier;
    }

    public function setPrenomCarrossier(?string $prenomCarrossier): self
    {
        $this->prenomCarrossier = $prenomCarrossier;

        return $this;
    }

    public function getRaisonSocialCarrossier(): ?string
    {
        return $this->raisonSocialCarrossier;
    }

    public function setRaisonSocialCarrossier(?string $raisonSocialCarrossier): self
    {
        $this->raisonSocialCarrossier = $raisonSocialCarrossier;

        return $this;
    }

    public function getJustificatifs(): ?bool
    {
        return $this->justificatifs;
    }

    public function setJustificatifs(?bool $justificatifs): self
    {
        $this->justificatifs = $justificatifs;

        return $this;
    }

    public function getDivn(): ?Divn
    {
        return $this->divn;
    }

    public function setDivn(?Divn $divn): self
    {
        $this->divn = $divn;

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
}
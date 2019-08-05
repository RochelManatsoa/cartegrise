<?php
namespace App\Entity\Vehicule;

use App\Entity\Divn;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Vehicule\VehiculeNeufRepository")
 */
class VehiculeNeuf
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Divn", mappedBy="vehicule", cascade={"persist", "remove"})
     */
    private $divn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $vin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $d1Marque;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $d2Version;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $kNumRecepCe;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateReception;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $d21Cenit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $derivVp;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $d3Denomination;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $f2MmaxTechAdm;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $f2MmaxAdmServ;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $f3MmaxAdmEns;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gMmaxAvecAttelage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $g1PoidsVide;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $jCategorieCe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $j1Genre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $j2CarrosserieCe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $j3Carrosserie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $p1Cyl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $p2PuissKw;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $p3Energie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $p6PuissFiscale;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $qRapportPuissMasse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $s1NbPlaceAssise;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $s2NbPlaceDebout;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $u1NiveauSonore;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $u2NbTours;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $v7Co2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $v9ClasseEnvCe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $z1Mention1;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $z1Value;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbMentions;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVin(): ?string
    {
        return $this->vin;
    }

    public function setVin(string $vin): self
    {
        $this->vin = $vin;

        return $this;
    }

    public function getD1Marque(): ?string
    {
        return $this->d1Marque;
    }

    public function setD1Marque(string $d1Marque): self
    {
        $this->d1Marque = $d1Marque;

        return $this;
    }

    public function getD2Version(): ?string
    {
        return $this->d2Version;
    }

    public function setD2Version(string $d2Version): self
    {
        $this->d2Version = $d2Version;

        return $this;
    }

    public function getKNumRecepCe(): ?string
    {
        return $this->kNumRecepCe;
    }

    public function setKNumRecepCe(string $kNumRecepCe): self
    {
        $this->kNumRecepCe = $kNumRecepCe;

        return $this;
    }

    public function getDateReception(): ?\DateTimeInterface
    {
        return $this->dateReception;
    }

    public function setDateReception(?\DateTimeInterface $dateReception): self
    {
        $this->dateReception = $dateReception;

        return $this;
    }

    public function getD21Cenit(): ?string
    {
        return $this->d21Cenit;
    }

    public function setD21Cenit(?string $d21Cenit): self
    {
        $this->d21Cenit = $d21Cenit;

        return $this;
    }

    public function getDerivVp(): ?string
    {
        return $this->derivVp;
    }

    public function setDerivVp(?string $derivVp): self
    {
        $this->derivVp = $derivVp;

        return $this;
    }

    public function getD3Denomination(): ?string
    {
        return $this->d3Denomination;
    }

    public function setD3Denomination(?string $d3Denomination): self
    {
        $this->d3Denomination = $d3Denomination;

        return $this;
    }

    public function getF2MmaxTechAdm(): ?string
    {
        return $this->f2MmaxTechAdm;
    }

    public function setF2MmaxTechAdm(?string $f2MmaxTechAdm): self
    {
        $this->f2MmaxTechAdm = $f2MmaxTechAdm;

        return $this;
    }

    public function getF2MmaxAdmServ(): ?string
    {
        return $this->f2MmaxAdmServ;
    }

    public function setF2MmaxAdmServ(?string $f2MmaxAdmServ): self
    {
        $this->f2MmaxAdmServ = $f2MmaxAdmServ;

        return $this;
    }

    public function getF3MmaxAdmEns(): ?string
    {
        return $this->f3MmaxAdmEns;
    }

    public function setF3MmaxAdmEns(?string $f3MmaxAdmEns): self
    {
        $this->f3MmaxAdmEns = $f3MmaxAdmEns;

        return $this;
    }

    public function getGMmaxAvecAttelage(): ?string
    {
        return $this->gMmaxAvecAttelage;
    }

    public function setGMmaxAvecAttelage(?string $gMmaxAvecAttelage): self
    {
        $this->gMmaxAvecAttelage = $gMmaxAvecAttelage;

        return $this;
    }

    public function getG1PoidsVide(): ?string
    {
        return $this->g1PoidsVide;
    }

    public function setG1PoidsVide(?string $g1PoidsVide): self
    {
        $this->g1PoidsVide = $g1PoidsVide;

        return $this;
    }

    public function getJCategorieCe(): ?string
    {
        return $this->jCategorieCe;
    }

    public function setJCategorieCe(?string $jCategorieCe): self
    {
        $this->jCategorieCe = $jCategorieCe;

        return $this;
    }

    public function getJ1Genre(): ?string
    {
        return $this->j1Genre;
    }

    public function setJ1Genre(?string $j1Genre): self
    {
        $this->j1Genre = $j1Genre;

        return $this;
    }

    public function getJ2CarrosserieCe(): ?string
    {
        return $this->j2CarrosserieCe;
    }

    public function setJ2CarrosserieCe(?string $j2CarrosserieCe): self
    {
        $this->j2CarrosserieCe = $j2CarrosserieCe;

        return $this;
    }

    public function getJ3Carrosserie(): ?string
    {
        return $this->j3Carrosserie;
    }

    public function setJ3Carrosserie(?string $j3Carrosserie): self
    {
        $this->j3Carrosserie = $j3Carrosserie;

        return $this;
    }

    public function getP1Cyl(): ?string
    {
        return $this->p1Cyl;
    }

    public function setP1Cyl(?string $p1Cyl): self
    {
        $this->p1Cyl = $p1Cyl;

        return $this;
    }

    public function getP2PuissKw(): ?string
    {
        return $this->p2PuissKw;
    }

    public function setP2PuissKw(?string $p2PuissKw): self
    {
        $this->p2PuissKw = $p2PuissKw;

        return $this;
    }

    public function getP3Energie(): ?string
    {
        return $this->p3Energie;
    }

    public function setP3Energie(?string $p3Energie): self
    {
        $this->p3Energie = $p3Energie;

        return $this;
    }

    public function getP6PuissFiscale(): ?string
    {
        return $this->p6PuissFiscale;
    }

    public function setP6PuissFiscale(?string $p6PuissFiscale): self
    {
        $this->p6PuissFiscale = $p6PuissFiscale;

        return $this;
    }

    public function getQRapportPuissMasse(): ?string
    {
        return $this->qRapportPuissMasse;
    }

    public function setQRapportPuissMasse(?string $qRapportPuissMasse): self
    {
        $this->qRapportPuissMasse = $qRapportPuissMasse;

        return $this;
    }

    public function getS1NbPlaceAssise(): ?string
    {
        return $this->s1NbPlaceAssise;
    }

    public function setS1NbPlaceAssise(?string $s1NbPlaceAssise): self
    {
        $this->s1NbPlaceAssise = $s1NbPlaceAssise;

        return $this;
    }

    public function getS2NbPlaceDebout(): ?string
    {
        return $this->s2NbPlaceDebout;
    }

    public function setS2NbPlaceDebout(?string $s2NbPlaceDebout): self
    {
        $this->s2NbPlaceDebout = $s2NbPlaceDebout;

        return $this;
    }

    public function getU1NiveauSonore(): ?string
    {
        return $this->u1NiveauSonore;
    }

    public function setU1NiveauSonore(?string $u1NiveauSonore): self
    {
        $this->u1NiveauSonore = $u1NiveauSonore;

        return $this;
    }

    public function getU2NbTours(): ?string
    {
        return $this->u2NbTours;
    }

    public function setU2NbTours(?string $u2NbTours): self
    {
        $this->u2NbTours = $u2NbTours;

        return $this;
    }

    public function getV7Co2(): ?string
    {
        return $this->v7Co2;
    }

    public function setV7Co2(?string $v7Co2): self
    {
        $this->v7Co2 = $v7Co2;

        return $this;
    }

    public function getV9ClasseEnvCe(): ?string
    {
        return $this->v9ClasseEnvCe;
    }

    public function setV9ClasseEnvCe(?string $v9ClasseEnvCe): self
    {
        $this->v9ClasseEnvCe = $v9ClasseEnvCe;

        return $this;
    }

    public function getZ1Mention1(): ?string
    {
        return $this->z1Mention1;
    }

    public function setZ1Mention1(?string $z1Mention1): self
    {
        $this->z1Mention1 = $z1Mention1;

        return $this;
    }

    public function getZ1Value(): ?\DateTimeInterface
    {
        return $this->z1Value;
    }

    public function setZ1Value(?\DateTimeInterface $z1Value): self
    {
        $this->z1Value = $z1Value;

        return $this;
    }

    public function getNbMentions(): ?int
    {
        return $this->nbMentions;
    }

    public function setNbMentions(?int $nbMentions): self
    {
        $this->nbMentions = $nbMentions;

        return $this;
    }

    public function getDivn(): ?Divn
    {
        return $this->divn;
    }

    public function setDivn(?Divn $divn): self
    {
        $this->divn = $divn;

        // set (or unset) the owning side of the relation if necessary
        $newFile = $divn === null ? null : $this;
        if ($newFile !== $divn->getFile()) {
            $divn->setFile($newFile);
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
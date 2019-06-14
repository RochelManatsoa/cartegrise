<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-06-12 11:41:26 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-06-12 14:59:29
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConfigurationRepository")
 */
class Configuration
{
    const TAXE_REGIONAL = 'sansTaxeRegional';
    const TAXE_REGIONAL_WITHOUT_MULTIPLE_POWERFISC= 'taxeRegional/PuissanceFiscal';
    const TAXE_REGIONAL_WITHOUT_TAXES= 'sansTaxes';
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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $DC;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $DCA;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $DUP;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $CTVO;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $DIVN;

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

    public function getDC(): ?bool
    {
        return $this->DC;
    }

    public function setDC(bool $DC): self
    {
        $this->DC = $DC;

        return $this;
    }

    public function getDCA(): ?bool
    {
        return $this->DCA;
    }

    public function setDCA(bool $DCA): self
    {
        $this->DCA = $DCA;

        return $this;
    }

    public function getDUP(): ?bool
    {
        return $this->DUP;
    }

    public function setDUP(bool $DUP): self
    {
        $this->DUP = $DUP;

        return $this;
    }

    public function getCTVO(): ?bool
    {
        return $this->CTVO;
    }

    public function setCTVO(bool $CTVO): self
    {
        $this->CTVO = $CTVO;

        return $this;
    }

    public function getDIVN(): ?bool
    {
        return $this->DIVN;
    }

    public function setDIVN(bool $DIVN): self
    {
        $this->DIVN = $DIVN;

        return $this;
    }

}
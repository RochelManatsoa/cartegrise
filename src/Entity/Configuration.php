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
    const TAXE_REGIONAL = 'taxeRegional';
    const TAXE_REGIONAL_WITHOUT_MULTIPLE_POWERFISC= 'taxeRegional/PuissanceFiscal';
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
     * @ORM\Column(type="string", length=255)
     */
    private $valueConf;

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

    public function getValueConf(): ?string
    {
        return $this->valueConf;
    }

    public function setValueConf(string $valueConf): self
    {
        $this->valueConf = $valueConf;

        return $this;
    }

}
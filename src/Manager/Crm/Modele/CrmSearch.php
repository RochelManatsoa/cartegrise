<?php

namespace App\Manager\Crm\Modele;

class CrmSearch
{
    private $email;
    private $immatriculation;
    private $nom;
    public function setEmail($email):self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setImmatriculation($immatriculation):self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getImmatriculation()
    {
        return $this->immatriculation;
    }

    public function setNom($nom):self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function isFilterable()
    {
        return(
            $this->immatriculation != null ||
            $this->nom != null ||
            $this->email != null
        );
    }
}
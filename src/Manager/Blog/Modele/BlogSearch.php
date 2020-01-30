<?php

namespace App\Manager\Blog\Modele;

class BlogSearch
{
    private $titre;
    private $description;
    public function setTitre($titre):self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function setDescription($description):self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function isFilterable()
    {
        return(
            $this->description != null ||
            $this->titre != null
        );
    }
}
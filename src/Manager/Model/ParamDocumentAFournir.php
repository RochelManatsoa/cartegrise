<?php

namespace App\Manager\Model;

class ParamDocumentAFournir
{
    private $name;
    private $documents;

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name):self
    {
        $this->name = $name;

        return $this;
    }

    public function getDocuments()
    {
        return $this->documents;
    }

    public function setDocuments(array $documents):self
    {
        $this->documents = $documents;

        return $this;
    }
}
<?php

namespace App\Manager\Crm;

use App\Manager\Crm\Modele\CrmSearch;
use App\Repository\{DemandeRepository, CommandeRepository};

class SearchManager
{
    private $demandeRepository;
    public function __construct(
        DemandeRepository $demandeRepository,
        CommandeRepository $commandeRepository
    )
    {
        $this->demandeRepository = $demandeRepository;
        $this->commandeRepository = $commandeRepository;
    }

    public function Search(CrmSearch $crmSearch)
    {
        
        return $this->commandeRepository->getCrmFilter($crmSearch);
        // return $this->demandeRepository->getCrmFilter($crmSearch);
    }
}
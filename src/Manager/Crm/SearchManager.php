<?php

namespace App\Manager\Crm;

use App\Manager\Crm\Modele\CrmSearch;
use App\Repository\DemandeRepository;

class SearchManager
{
    private $demandeRepository;
    public function __construct(
        DemandeRepository $demandeRepository
    )
    {
        $this->demandeRepository = $demandeRepository;
    }

    public function Search(CrmSearch $crmSearch)
    {
        
        return $this->demandeRepository->getCrmFilter($crmSearch);
    }
}
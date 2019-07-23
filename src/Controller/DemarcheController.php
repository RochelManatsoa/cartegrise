<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Demande;
use App\Entity\Fichier;
use App\Entity\TypeFichier;
use App\Form\DemandeType;
use App\Form\FichierType;
use App\Repository\ClientRepository;
use App\Repository\DemandeRepository;
use App\Repository\DocumentsRepository;
use App\Repository\FichierRepository;
use App\Repository\TypeDemandeRepository;
use App\Repository\TypeFichierRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DemarcheController extends AbstractController
{

}

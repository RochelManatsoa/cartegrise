<?php

namespace App\Controller\Export;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\PaiementType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Manager\{CommandeManager, TransactionManager};
use App\Repository\CommandeRepository;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Manager\Export\ExportManager;
use App\Manager\UserManager;

use App\Entity\Commande;

/**
 * @Route("/export")
 */
class ExportController extends AbstractController
{

    /**
     * @Route("/user-without-command", name="export_user_without_command", methods={"GET"})
     */
    public function exportUserWithoutCommande(Request $request, ExportManager $exportManager, UserManager $userManager)
    {
        $usersWithoutEstimation = $userManager->findUserWithoutEstimation();
        $fields = ['email', 'nom','prenom', 'genre', 'telephone'];
        $exportManager->exportXlsx($fields, $usersWithoutEstimation, "usersWithoutEstimation" );
        
        return new Response('done');
    }

    /**
     * @Route("/user-stats-per-month/{month}", name="export_user_payed_form_may", methods={"GET"})
     */
    public function findUserAfterSuccessPaimentInMounth(int $month, Request $request, ExportManager $exportManager, UserManager $userManager){
        $users = $userManager->findUserAfterSuccessPaimentInMounth($month);
        $fields = ['email', 'nom','prenom', 'genre', 'telephone', 'date paiement', 'type'];
        $exportManager->exportXlsx($fields, $users, 'paiementStatFor'.$month.'Month' );

        return new Response('done');
    }
}

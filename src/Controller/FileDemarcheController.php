<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-05-09 21:15:58 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-05-10 03:07:02
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Demande;
use App\Manager\{DocumentAFournirManager, MailManager, DemandeManager};

class FileDemarcheController extends AbstractController
{
    /**
     * @Route("/validate_demande/{demande}/check", name="validate_file")
     */
    public function validateFile(
        Demande $demande,
        DocumentAFournirManager $documentManager,
        MailManager $mailManager
    )
    {
        $infos = $documentManager->getFilesList($demande);
        $response = $mailManager->sendMailDocumentAFournir($demande, $infos);

        
        return new JsonResponse($response, 202);
    }

    /**
     * @Route("/validate/{demande}/document/{checker}", name="demande_document_validate")
     */
    public function validerDocument(Demande $demande, $checker, DemandeManager $demandeManager)
    {
        if ($demande->getChecker() != $checker ) {
            Throw new \Exception("Check lien de l'email non valide");
        }
        $demande->setStatusDoc(Demande::DOC_VALID);
        $demandeManager->saveDemande($demande);

        return new Response('success');
    }
}

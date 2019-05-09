<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-05-09 21:15:58 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-05-09 22:06:44
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Demande;
use App\Manager\DocumentAFournirManager;

class FileDemarcheController extends AbstractController
{
    /**
     * @Route("/validate_demande/{demande}/check", name="validate_file")
     */
    public function validateFile(Demande $demande, DocumentAFournirManager $documentManager)
    {
        dump($documentManager->getFilesList($demande));die;
        dump($fileSerialize);die;
        dump($demande->getDuplicata()->getFile());
        die;
        return null;
    }
}

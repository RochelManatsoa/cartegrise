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
    /**
     * @Route("/ctvo", name="ctvo")
     */
    public function ctvodemande(){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            $user = $this->getUser();
            $client = $user->getClient();
            $idclient = $client->getId();
            $nom = $client->getClientNom();
            $prenom = $client->getClientPrenom();
            $genre = $client->getClientGenre();
            $dateNaissance = $client->getClientDateNaissance();
            $lieuNaissance = $client->getClientLieuNaissance();
            $dpt = $client->getClientDptNaissance();
            $pays = $client->getClientPaysNaissance();

            $contact = $client->getClientContact();
            $idcontact = $contact->getId();
            $mobile = $contact->getContactTelmobile();
            $mail = $user->getEmail();

        return $this->render('demarche/ctvo.html.twig', [
                'idclient' => $idclient,
                'mail' => $mail,
                'mobile' => $mobile,
                'pays' => $pays,
                'genre' => $genre,
                'dateN' => $dateNaissance,
                'lieuN' => $lieuNaissance,
                'dptN' => $dpt,
                'client' => $client
        ]);
    }

    /**
    *@Route("/ctvo/checkout/{tmsId}", name="checkoutctvo")
    */
    public function chekout($tmsId){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $client = $user->getClient();
        $idclient = $client->getId();
        $genre = $client->getClientGenre();
        $demande = $this->getDoctrine()
            ->getRepository(Demande::class)
            ->findOneBy(['client' => $idclient, 'typeDemande' => 'CTVO', 'TmsIdDemande' => $tmsId]);
            if($demande == NULL){
                return $this->redirectToRoute('ctvo');
            }
            else{
                $idDemande = $demande->getId();
                return $this->render('demarche/checkout.html.twig',[
                    'idDemande' => $idDemande,
                    'tmsId' => $tmsId,
                    'type' => 'CTVO',
                    'genre' => $genre,
                    'client' => $client,
                ]);
            }
        

        
    }
    
    
    /**
    * @Route("/divn", name="divn")
    */
    public function divndemande(){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            $user = $this->getUser();
            $client = $user->getClient();
            $idclient = $client->getId();
            $nom = $client->getClientNom();
            $prenom = $client->getClientPrenom();
            $genre = $client->getClientGenre();
            $dateNaissance = $client->getClientDateNaissance();
            $lieuNaissance = $client->getClientLieuNaissance();
            $dpt = $client->getClientDptNaissance();
            $pays = $client->getClientPaysNaissance();

            $contact = $client->getClientContact();
            $idcontact = $contact->getId();
            $mobile = $contact->getContactTelmobile();
            $mail = $user->getEmail();

        return $this->render('demarche/divn.html.twig', [
                'idclient' => $idclient,
                'mail' => $mail,
                'mobile' => $mobile,
                'pays' => $pays,
                'genre' => $genre,
                'dateN' => $dateNaissance,
                'lieuN' => $lieuNaissance,
                'dptN' => $dpt,
                'client' => $client
        ]); 
    }
    
    /**
    *@Route("/divn/checkout/{tmsId}", name="checkoutdivn")
    */
    public function chekoutDIVN($tmsId){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $client = $user->getClient();
        $idclient = $client->getId();
        $genre = $client->getClientGenre();
        $demande = $this->getDoctrine()
            ->getRepository(Demande::class)
            ->findOneBy(['client' => $idclient, 'typeDemande' => 'DIVN', 'TmsIdDemande' => $tmsId]);
            if($demande == NULL){
                return $this->redirectToRoute('divn');
            }
            else{
                $idDemande = $demande->getId();
                return $this->render('demarche/checkoutDIVN.html.twig',[
                    'idDemande' => $idDemande,
                    'tmsId' => $tmsId,
                    'type' => 'DIVN',
                    'genre' => $genre,
                    'client' => $client,
                ]);
            }
               
    }
    
    /**
    * @Route("/dup", name="dup")
    */
    public function dupdemande(){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            $user = $this->getUser();
            $client = $user->getClient();
            $idclient = $client->getId();
            $nom = $client->getClientNom();
            $prenom = $client->getClientPrenom();
            $genre = $client->getClientGenre();
            $dateNaissance = $client->getClientDateNaissance();
            $lieuNaissance = $client->getClientLieuNaissance();
            $dpt = $client->getClientDptNaissance();
            $pays = $client->getClientPaysNaissance();

            $contact = $client->getClientContact();
            $idcontact = $contact->getId();
            $mobile = $contact->getContactTelmobile();
            $mail = $user->getEmail();

        return $this->render('demarche/dup.html.twig', [
                'idclient' => $idclient,
                'mail' => $mail,
                'mobile' => $mobile,
                'pays' => $pays,
                'genre' => $genre,
                'dateN' => $dateNaissance,
                'lieuN' => $lieuNaissance,
                'dptN' => $dpt,
                'client' => $client
        ]); 
    }

    /**
    *@Route("/dup/checkout/{tmsId}", name="checkoutdup")
    */
    public function chekoutDUP($tmsId){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $client = $user->getClient();
        $idclient = $client->getId();
        $genre = $client->getClientGenre();
        $demande = $this->getDoctrine()
            ->getRepository(Demande::class)
            ->findOneBy(['client' => $idclient, 'typeDemande' => 'DUP', 'TmsIdDemande' => $tmsId]);
            if($demande == NULL){
                return $this->redirectToRoute('dup');
            }
            else{
                $idDemande = $demande->getId();
                return $this->render('demarche/checkout.html.twig',[
                    'idDemande' => $idDemande,
                    'tmsId' => $tmsId,
                    'type' => 'DUP',
                    'genre' => $genre,
                    'client' => $client,
                ]);
            }
               
    }

    /**
    * @Route("/dca", name="dca")
    */
    public function dcademande(){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            $user = $this->getUser();
            $client = $user->getClient();
            $idclient = $client->getId();
            $nom = $client->getClientNom();
            $prenom = $client->getClientPrenom();
            $genre = $client->getClientGenre();
            $dateNaissance = $client->getClientDateNaissance();
            $lieuNaissance = $client->getClientLieuNaissance();
            $dpt = $client->getClientDptNaissance();
            $pays = $client->getClientPaysNaissance();

            $contact = $client->getClientContact();
            $idcontact = $contact->getId();
            $mobile = $contact->getContactTelmobile();
            $mail = $user->getEmail();

        return $this->render('demarche/dca.html.twig', [
                'idclient' => $idclient,
                'mail' => $mail,
                'mobile' => $mobile,
                'pays' => $pays,
                'genre' => $genre,
                'dateN' => $dateNaissance,
                'lieuN' => $lieuNaissance,
                'dptN' => $dpt,
                'client' => $client
        ]); 
    }

    /**
    *@Route("/dca/checkout/{tmsId}", name="checkoutdivn")
    */
    public function chekoutDCA($tmsId){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $client = $user->getClient();
        $idclient = $client->getId();
        $genre = $client->getClientGenre();
        $demande = $this->getDoctrine()
            ->getRepository(Demande::class)
            ->findOneBy(['client' => $idclient, 'typeDemande' => 'DCA', 'TmsIdDemande' => $tmsId]);
            if($demande == NULL){
                return $this->redirectToRoute('dca');
            }
            else{
                $idDemande = $demande->getId();
                return $this->render('demarche/checkout.html.twig',[
                    'idDemande' => $idDemande,
                    'tmsId' => $tmsId,
                    'type' => 'DCA',
                    'genre' => $genre,
                    'client' => $client,
                ]);
            }
               
    }

    /**
    *@Route("/dlcerfa", name="dllcerfa")
    *@Method("POST")
    */
    public function dllcerfa(){

        $user = $this->getUser();
        $client = $user->getClient();
        $nom = $client->getClientNom();
        $prenom = $client->getClientPrenom();

        $decoded = base64_decode($_POST['get_fic']);
        $file = 'incphp/CERFA-'.$nom.'-'.$prenom.'.pdf';
        $filefinal = file_put_contents($file, $decoded);

        if(isset($_POST['get_fic'])){
            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header("Content-Transfer-Encoding: Binary"); 
                header('Content-Disposition: attachment; filename="'.basename($file).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                readfile($file);
                unlink($file);
                return 0;
                //exit;
            }
        }
    }


    /**
    *@Route("/dlmandat", name="dllmandat")
    *@Method("POST")
    */
    public function dllmandat(){

        $user = $this->getUser();
        $client = $user->getClient();
        $nom = $client->getClientNom();
        $prenom = $client->getClientPrenom();
        
        $decoded = base64_decode($_POST['get_fic']);
        $file = 'incphp/Mandat-'.$nom.'-'.$prenom.'.pdf';
        $filefinal = file_put_contents($file, $decoded);

        if(isset($_POST['get_fic'])){
            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header("Content-Transfer-Encoding: Binary"); 
                header('Content-Disposition: attachment; filename="'.basename($file).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                readfile($file);
                unlink($file);
                return 0;
                //exit;
            }
        }
    }
}

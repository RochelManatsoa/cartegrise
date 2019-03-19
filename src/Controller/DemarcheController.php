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
     * @Route("/compte", name="compte")
     */
    public function index(Request $request, DemandeRepository $repository, TypeDemandeRepository $nomDemande,
                          ClientRepository $demendeur, ObjectManager $manager, DocumentsRepository $documents,
                          TypeFichierRepository $typeFichierRepository, FichierRepository $fichierRepository
                        )
    {

        if ($this->isGranted('IS_AUTHENTICATED_FULLY')){
            $user = $this->getUser();
            $client = $user->getClient();
            $idclient = $client->getId();
            $civilite = $client->getClientGenre();
            $files = $client->getFichiers();
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

            $demande = $client->getDemandes();
            /*foreach ($demande as $demarche) {
                dump($demarche);
            }*/
            /*foreach ($files as $demarche) {
                dump($demarche->getDemande()->getFichiers()->getTypeContenu());
            }*/
            $demandeRepository = $repository->findby(
                ['client'=>$idclient],
                ['id'=> 'ASC']
            );
//            $repo = $repository->find($idclient);
            $repo = $repository->findby(
                ['client'=>"3"],
                ['id'=> 'ASC']
            );
            /*$repos = $fichierRepository->findall();*/
            $trop = $nomDemande->find($idclient);
            $clientfichier = $fichierRepository->findby(
                ['client'=> $idclient],
                ['id'=> 'ASC']
            );
            $temps = new \DateTime();
            $age = $temps->diff($dateNaissance, true)->y;
            $repofichier = $typeFichierRepository->findall();  
            $tabForm=[];         
            if($demandeRepository == null){
                $docs = null;
            }else{
                $docs = [];
                foreach ($demandeRepository as $reps){
                    $nom_demande = $nomDemande->findOneByType($reps->getTypeDemande());
                    if($age >= 18){
                        $docs[] = [
                            'id' => $reps->getId(),
                            'type' => $reps->getTypeDemande(),
                            'demande' => $nom_demande,
                            'fichiers' => $fichierRepository->findby(
                                ['demande'=>$reps->getId()],
                                ['id'=>'ASC']
                            ),
                            'documents' => $documents->findNotMineur($nom_demande->getNom()),
                            'typeDocument' => $typeFichierRepository->find($nom_demande->getId()),
                            'nombre' => sizeof($documents->findNotMineur($nom_demande->getNom())),
                        ];
                    }else{
                        $docs[] = [
                        'id' => $reps->getId(),
                        'type' => $reps->getTypeDemande(),
                        'demande' => $nom_demande,
                        'fichiers' => $fichierRepository->findby(
                            ['demande'=>$reps->getId()],
                            ['id'=>'ASC']
                        ),
                        'documents' => $documents->findByType($nom_demande->getNom()),
                        'typeDocument' => $typeFichierRepository->findByType($nom_demande->getId()),
                        'nombre' => sizeof($documents->findByType($nom_demande->getNom())),
                        ];
                    }
                }
                /*foreach ($docs as $sipas) {
                    # code...
                    $sipa = $nomDemande->findByType($sipas['type']);
                    foreach ($sipa as $izy) {
                        # code...
                        dump($izy->getNom());
                    }
                }*/

                $time = time();
                $nombre = sizeof($documents->findAll());
                $nbDocs = sizeof($docs);
                for ($j=0;$j<$nbDocs;$j++){
                    $nombre = $nombre + $docs[$j]['nombre'];
                }


                $fichier = new Fichier();
                $tabForm=[];
                $i=1;

                /*dump($docs);*/
                /*dump($defaultDemande);*/

                foreach ($docs as $doc) {
                    foreach($doc['documents'] as $do){
                        $defaultType = $documents->find($do->getId());
                        $defaultDemande = $repository->find($doc['id']);
                        
                        $form = $this->createForm(FichierType::class, $fichier , array(
                            'defaultType'=>$defaultType,
                            'defaultDemande'=>$defaultDemande)
                        );
                        $num = $do->getId().''.$doc['id'];
                        $tabForm[$num]=$form->createView();
                    }
                }

                
                $form->handleRequest($request);

                if($form->isSubmitted() && $form->isValid()){
                    $numeroDemande = $fichier->getDemande();
                    $id_de_la_demande = $numeroDemande->getId();
                    $numeroClient = $idclient;
                    $fichierClient = $fichier->getType();
                   $dossier = '/var/www/html/front/projectCG/public/upload_files/client_'.$numeroClient.'/demande_'.$id_de_la_demande.'-'.$numeroDemande;
                   if(!is_dir($dossier)){
                       $fileSystem = new Filesystem();
                       $fileSystem->mkdir($dossier);
                   }
                   $intable = scandir($dossier);
                   $file = $fichier->getUrl();
                   $type = $fichier->getType()->getCode();
                   $nombre = $fichier->getType()->getNbDoc();
                   $test = $nom.'-'.$prenom.'-'.$type.'.'.$file->guessExtension();
                   if(in_array($test,$intable)){
                       if($nombre > 1 ){
                            $upload_directory = '/var/www/html/front/projectCG/public/upload_files/client_'.$numeroClient.'/demande_'.$id_de_la_demande.'-'.$numeroDemande.'/'.$type;
                           $fileName = $upload_directory.'/'.$nom.'-'.$prenom.'-'.$type.'-'.$time.'.'.$file->guessExtension();
                           $file->move($upload_directory, $fileName);
                           $fichier->setDemande($repository->find($numeroDemande))
                               ->setClient($client)
                               ->setUrl($fileName)
                               ->setTypeContenu($type)
                               ->setStatus("0")
                               ->setType($fichierClient)
                               ->setEnvoyeLe(new \DateTime());
                           $manager->persist($fichier);
                           $manager->flush();
                           $this->addFlash('success', 'Le fichier à bien été enregistrée.  ');
                           return $this->redirectToRoute('compte');
                       }else{
                           $this->addFlash('danger', 'Vous avez déjà envoyé ce document.  ');
                           return $this->redirectToRoute('compte');
                       }
                   }else{
                        $upload_directory = '/var/www/html/front/projectCG/public/upload_files/client_'.$numeroClient.'/demande_'.$id_de_la_demande.'-'.$numeroDemande;
                        $fileName = $upload_directory.'/'.$nom.'-'.$prenom.'-'.$type.'.'.$file->guessExtension();
                       $file->move($upload_directory, $fileName);
                       $fichier->setDemande($repository->find($numeroDemande))
                           ->setClient($client)
                           ->setUrl($fileName)
                           ->setTypeContenu($type)
                           ->setStatus("0")
                           ->setType($fichierClient)
                           ->setEnvoyeLe(new \DateTime());
                       $manager->persist($fichier);
                       $manager->flush();
                       $this->addFlash('success', 'Le fichier à bien été enregistrée.  ');
                       return $this->redirectToRoute('compte');
                   }
                }
            }

            return $this->render('demarche/index.html.twig', [
                'controller_name' => 'DemandeController',
                'idclient' => $idclient,
                'mail' => $mail,
                'mobile' => $mobile,
                'pays' => $pays,
                'genre' => $genre,
                'age' => $age,
                'dateN' => $dateNaissance,
                'lieuN' => $lieuNaissance,
                'dptN' => $dpt,
                'client' => $client,
                'demande' => $demande,
                'files' => $files,
                'clientfichier' => $clientfichier,
                'typefichier' => $repofichier,
                'documents' => $docs,
                'tab' => $tabForm,
            ]);
        }
        
        else{
            return $this->redirectToRoute('home');
        }
        
        /*
        //$client = $this->getDoctrine()->getRepository(Contact::class)->find($id);

        $demande = new Demande();
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

        }
        return $this->render('demarche/index.html.twig', [
            'controller_name' => 'DemandeController',
            'form'=>$form->createView(),
        ]);*/
    }

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

            $demande = new Demande();
            $form = $this->createForm(DemandeType::class, $demande);
            $dupForm = $form->createView();


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

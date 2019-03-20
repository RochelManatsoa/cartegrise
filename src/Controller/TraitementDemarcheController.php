<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\CtvoFormType;
use App\Form\DvinFormType;
use App\Form\DcFormType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TraitementDemarcheController extends AbstractController
{
    /**
     * @Route("/ctvo-demarche", name="ctvo_demarche")
     */
    public function ctvo(
        Request $request,
        ObjectManager $manager
        )
    {
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
            $form = $this->createForm(CtvoFormType::class, $demande);
            $ctvoFrom = $form->createView();

        return $this->render('traitement_demarche/ctvo.html.twig', [
            'form' => $ctvoFrom,
        ]);
    }
    /**
     * @Route("/dc-demarche", name="dc_demarche")
     */
    public function dc(
        Request $request,
        ObjectManager $manager
        )
    {
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
            $form = $this->createForm(DcFormType::class, $demande);
            $dcFrom = $form->createView();

        return $this->render('traitement_demarche/dc.html.twig', [
            'form' => $dcFrom,
        ]);
    }
    /**
     * @Route("/dvin-demarche", name="dvin_demarche")
     */
    public function dvin(
        Request $request,
        ObjectManager $manager
        )
    {
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
            $form = $this->createForm(DvinFormType::class, $demande);
            $dvinFrom = $form->createView();

        return $this->render('traitement_demarche/dvin.html.twig', [
            'form' => $dvinFrom,
        ]);
    }
}

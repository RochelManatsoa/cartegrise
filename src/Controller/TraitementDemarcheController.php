<?php

namespace App\Controller;

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

        return $this->render('traitement_demarche/index.html.twig', [
            'controller_name' => 'TraitementDemarcheController',
        ]);
    }
}

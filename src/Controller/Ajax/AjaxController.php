<?php

namespace App\Controller\Ajax;

use App\Entity\Partner;
use App\Repository\PartnerRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends AbstractController
{
    /**
     * @Route("/ajax/partner/add", name="ajax_partner_add")
     */
    public function index(ObjectManager $manager, PartnerRepository $partnerRepository)
    {
        extract($_POST);
        if($nom == ""){

            return $this->json([
                'nom' => $nom, 
                'description' => $description, 
                'message' => 'Champs "nom" manquant',
                'status' => '403'
            ], 200);
        }

        if($partnerRepository->findOneBy(['name' => $nom])){

            return $this->json([
                'nom' => $nom, 
                'description' => $description, 
                'message' => 'Le partenariat entré exixte dejà, veuillez rafraîchir la page',
                'status' => '403'
            ], 200);
        }

        $partenariat = new Partner();
        $partenariat->setName($nom)->setDescription($description);
        $manager->persist($partenariat);
        $manager->flush();
        $this->addFlash('success', 'La partenariat '.$partenariat->getName().' a bien été enregister');


        return $this->json([
            'nom' => $nom, 
            'description' => $description, 
            'message' => 'parfait!',
            'status' => '200'
        ], 200);
    }
}

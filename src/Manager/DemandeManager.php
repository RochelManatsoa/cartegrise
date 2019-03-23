<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Demande;
use App\Entity\Commande;
use App\Form\Demande\CtvoFormType;
use App\Form\Demande\DivnFormType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactoryInterface;
use Twig_Environment as Twig;

class DemandeManager
{
    private $em;
    private $formFactory;
    private $twig;
    public function __construct
    (
        EntityManagerInterface $em,
        FormFactoryInterface   $formFactory,
        Twig                    $twig
    )
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->twig = $twig;
    }

    private function init()
    {
        return new Demande();
    }

    public function generateForm(Commande $commande)
    {
        $demande = $this->init();
        $commande->addDemande($demande);
        switch ($commande->getDemarche()->getType()) {
            case "CTVO":
                $form = $this->formFactory->create(CtvoFormType::class, $demande);
            break;
            case "DIVN":
                $form = $this->formFactory->create(DivnFormType::class, $demande);
            break;
        }
        
        return $form;
    }

    public function save(Form $form)
    {
        $demande = $form->getData();
        if (!$demande instanceof Demande)
            return;
        $this->em->persist($demande);
        $this->em->flush();
    }

    public function getView(Form $form)
    {
        $demande = $form->getData();
        switch($demande->getCommande()->getDemarche()->getType()) {
            case "CTVO":
                $view = $this->twig->render(
                        "demande/ctvo.html.twig",
                        [
                            'form'     => $form->createView(),
                            'commande' => $demande->getCommande(),
                        ]
                );
            break;
            case "DIVN":
                $view = $this->twig->render(
                        "demande/divn.html.twig",
                        [
                            'form'      => $form->createView(),
                            'commande'  => $demande->getCommande(),
                        ]
                );
            break;
        }

        return $view;
    }

}
<?php

namespace App\Controller\Client;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Form\UpdateUserType;
use App\Manager\UserManager;

/**
 * @Route("/compte")
 */
class AccountController extends AbstractController
{
    /**
     * @Route("/", name="compte")
     */
    public function index(Request $request)
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY'))
            return $this->render('client/account/index.html.twig');

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/update/{user}/acount", name="update_acount")
     */
    public function update(Request $request, User $user, UserManager $userManager)
    {
        $form = $this->createForm(UpdateUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            if ("" != $user->getPlainPassword()) {
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
            }
            
            $userManager->save($user);
            return $this->redirectToRoute('compte');
        }

        return $this->render(
            'client/account/update.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
    
}
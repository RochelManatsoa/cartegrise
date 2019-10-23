<?php

namespace App\Controller\Client;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Form\UpdateUserType;
use App\Form\Registration\PasswordFormType;
use App\Manager\UserManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\FormError;

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
    public function update(
        Request $request, 
        User $user, 
        UserManager $userManager,
        UserPasswordEncoderInterface $passwordEncoder
        )
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

    /**
     * @Route("/update/{user}/password", name="update_password")
     */
    public function updatePassword(
        Request $request, 
        UserPasswordEncoderInterface $passwordEncoder,
        UserManager $userManager,
        TokenStorageInterface  $tokenStorage
        )
    {
            $user = $tokenStorage->getToken()->getUser();
            $form = $this->createForm(PasswordFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $oldPassword = $request->request->get('password_form')['password'];
            if ($passwordEncoder->isPasswordValid($user, $oldPassword, $user->getSalt())) {
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($newEncodedPassword);
            
                $userManager->save($user);

                $this->addFlash('success', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('fos_user_security_login');

            } else {
                $user->setSalt(uniqid());
                $this->addFlash('danger', 'Ancien mot de passe incorrect. Veillez vous reconnecter!');

                return $this->redirectToRoute('fos_user_security_login');             
            }
        }

        return $this->render(
            'client/account/updatePassword.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
    
}
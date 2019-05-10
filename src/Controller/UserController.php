<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\Crm\UserType;
use App\Manager\UserManager;

class UserController extends AbstractController
{

    /**
     * @Route("/logout", name="logout")
     */

    public function logout()
    {

    }

    /**
     * @Route("/register_crm", name="user_register_crm")
     */
    public function registerCrm(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        UserRepository $repository,
        UserManager $userManager
        ) {
        // 1) build the form
        $user = new User();
        $user->addRole("ROLE_CRM");
        $user->setEnabled(true);
        $form = $this->createForm(UserType::class, $user);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $userManager->save($user);

            return new Response('okay');
        }
        // $utilisateurs = $repository->findAll();
        return $this->render('crm/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

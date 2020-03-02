<?php

namespace App\Controller\Client;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\{User, Demande};
use App\Repository\{EmailHistoryRepository, DemandeRepository};
use App\Form\UpdateUserType;
use App\Form\Registration\PasswordFormType;
use App\Manager\{UserManager, DemandeManager, DocumentAFournirManager, TMSSauverManager};
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\FormError;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/account")
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
     * @Route("/update/{user}/member", name="update_acount")
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
        UserManager $userManager
        )
    {
            $user = $this->getUser();
            $form = $this->createForm(PasswordFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $oldPassword = $request->request->get('password_form')['password'];
            if ($passwordEncoder->isPasswordValid($user, $oldPassword, $user->getSalt())) {
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($newEncodedPassword);
            
                $userManager->save($user);

                $this->addFlash('success', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('compte');

            } else {
                $this->addFlash('danger', 'Ancien mot de passe incorrect.');

            }
        }

        return $this->render(
            'client/account/updatePassword.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
    
    /**
     * @Route("/emails", name="email_history")
     */
    public function emailUserHistory(
        Request $request,
        PaginatorInterface $paginator,
        EmailHistoryRepository $emailHistoryRepository
    )
    {
        $user = $this->getUser();
        $queryEmailHystory = $emailHistoryRepository->findEmailHistoryByUser($user);
        $pagination = $paginator->paginate(
            $queryEmailHystory,
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('client/account/emailHistory.html.twig', [
            'emailsHistory' => $pagination,
        ]);
    }

    /**
     * @Route("/espace-client/{demande}", name="espace_client")
     * @Route("/espace-client")
     */
    public function espaceClient(DemandeManager $demandeManager, DocumentAFournirManager $documentAFournirManager, TMSSauverManager $tmsSauverManager, ?Demande $demande=null)
    {
        if (!$demande instanceof Demande) {
            $demande = $demandeManager->getHerLastDemande();
        }
        $fileForm = null;
        $params = ($demande instanceof Demande) ? $tmsSauverManager->getParamsForCommande($demande->getCommande()) : null;
        /*
        info de TMS
        */
        $fileType = ($demande instanceof Demande) ? $documentAFournirManager->getType($demande): null;
        $files = ($demande instanceof Demande) ? $documentAFournirManager->getDaf($demande) : null;
        if (!null == $fileType) {
            $fileForm = $this->createForm($fileType, $files);
        }
        

        return $this->render(
            'client/espaceClient.html.twig',
            [
                'demande' => $demande,
                'params' => $params,
                'client' => $this->getUser()->getClient(),
                'form'      => is_null($fileForm) ? null :$fileForm->createView(),
                "files"     => $files,
            ]
        );
    }


    /**
     * @Route("/demande/history", name="demande_history")
     */
    public function history(DemandeRepository $demandeRepository, Request $request, PaginatorInterface $paginator)
    {
        $user = $this->getUser();
        $demandesOfUserQuery = $demandeRepository->getQueryDemandeForUser($user);
        $pagination = $paginator->paginate(
            $demandesOfUserQuery,
            $request->query->getInt('page', 1),
            8
        );
        return $this->render(
            'client/account/demandeHistory.html.twig',
            [
                'demandes' => $pagination,
                'client' => $this->getUser()->getClient(),
            ]
        );
    }
}
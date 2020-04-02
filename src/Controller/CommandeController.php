<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\PaiementType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Manager\{CommandeManager, TransactionManager};
use App\Repository\CommandeRepository;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Commande;

/**
 * @Route("/commande")
 */
class CommandeController extends AbstractController
{
    public function __construct(
        CsrfTokenManagerInterface $tokenManager = null
    )
    {
        $this->tokenManager = $tokenManager;
    }
    /**
     * @Route("/list", name="commande_list")
     */
    public function listAction(Request $request, CommandeRepository $repository, PaginatorInterface $paginator)
    {
        $client = $this->getUser()->getClient();
        $commandesOfUserQuery = $repository->queryAllCommandeByClient($client);
        $pagination = $paginator->paginate(
            $commandesOfUserQuery,
            $request->query->getInt('page', 1),
            8
        );
        return $this->render('commande/list.html.twig', [
            "commandes" => $pagination,
        ]);
    }

    /**
     * @route("/{id}/annuler", name="commande_annuler")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function annuler(Request $request, Commande $commande, EntityManagerInterface $em)
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->query->get('_token'))) {
            $client = $this->getUser()->getClient();
            $commande->setDeletedAt(new \ DateTime());
            // $client->removeCommande($commande);
            // $em->remove($commande);
            $em->persist($commande);
            $em->flush();
            $this->addFlash('success', "Commande annulée avec succès !");
        }

        return $this->redirectToRoute('commande_list');
    }

    /**
     * @Route("/{commande}/recap", name="commande_recap")
     */
    public function recap(Commande $commande, Request $request, CommandeManager $commandeManager)
    {
        $commandeManager->checkIfTransactionSuccess($commande);
        $formCGV = $this->createForm(PaiementType::class, $commande);
        $formCGV->handleRequest($request);
        if($formCGV->isSubmitted() && $formCGV->isValid()){
            $commandeManager->save($commande);
            return $this->redirectToRoute('payment_commande', ['commande' => $commande->getId()]);
        }
        return $this->render(
            'commande/resum.html.twig',
            [
                'commande' => $commande,
                'formCGV'    => $formCGV->createView(),
                'user_csrf' => $this->getTokenAction()
            ]
        );
    }

    /**
     * @Route("/{commande}/paiement", name="commande_recap_paiement")
     */
    public function paiement(Commande $commande)
    {
        return $this->render('commande/paiement.html.twig', [
            'commande' => $commande,
        ]);
    }

    public function getTokenAction()  
    {
        $csrf = $this->tokenManager
            ? $this->tokenManager->getToken('authenticate')->getValue()
            : null;
        return $csrf;
    }

    /**
     * @Route("/suivi-demarche/{commande}", name="suivi_commande")
     * @IsGranted(\App\Security\Voter\SuiviVoter::VIEW, subject="commande", message="Suivi de commande indisponible")
     */
    public function suiviDemarche(Commande $commande)
    {
        return $this->render('commande/suivi.html.twig', [
            'commande'=>$commande,
        ]);
    }

    /**
     * @Route("/", name="api_store_comment", methods={"POST"})
     */
    public function storeComment(Request $request, CommandeManager $commandeManager)
    {
        $id = $request->get('id');
        $comment = $request->get('comment');

        $commande = $commandeManager->find($id);
        if(!$commande instanceof Commande)
            return;
        $commande->setComment($comment); 
        $commandeManager->save($commande);
        
        $match = str_replace($request->server->get('HTTP_ORIGIN'), '', $request->headers->get('referer'));
        $router = $this->get('router'); 
        $route = $router->match($match);
        // dd($request->headers->get('referer'), $match, $request->server->get('HTTP_HOST'), $route);

        return $this->redirectToRoute($route['_route'], [
            "id" => $route['id']
        ]);
    }
}

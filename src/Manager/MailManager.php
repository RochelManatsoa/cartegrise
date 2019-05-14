<?php

namespace App\Manager;

use Swift_Mailer;
use Swift_Attachment;
use App\Entity\Demande;
use App\Manager\Model\ParamDocumentAFournir;
use App\Manager\DemandeManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MailManager
{
    private $tokenStorage;
    private $template;
    private $mailer;
    private $demandeManager;
    private $parameterBagInterface;
    public function __construct
    (
        TokenStorageInterface $tokenStorage,
        DemandeManager $demandeManager,
        \Twig_Environment $template,
        Swift_Mailer $mailer,
        ParameterBagInterface $parameterBagInterface
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->template = $template;
        $this->mailer = $mailer;
        $this->demandeManager = $demandeManager;
        $this->parameterBagInterface = $parameterBagInterface;
    }
    public function sendMailDocumentAFournir(Demande $demande, ParamDocumentAFournir $infos)
    {
        $daf = $this->demandeManager->getDossiersAFournir($demande);
        $now = (new \DateTime())->getTimestamp();
        $encoder = hash('sha256', $now);
        $demande->setChecker($encoder)->setStatusDoc(Demande::DOC_PENDING);
        $this->demandeManager->saveDemande($demande);
        $emailDests = $this->parameterBagInterface->get("admin_doc_validator");
        if (\is_iterable($emailDests) && 0 < count($emailDests)){
            $message = (new \Swift_Message($infos->getName() . ' ' . $this->tokenStorage->getToken()->getUser()->getEmail()))
            // ->setFrom($this->tokenStorage->getToken()->getUser()->getEmail());
            ->setFrom('no-reply@cgofficiel.fr', 'cgofficiel.fr');
            foreach ($emailDests as $key => $emailDest) {
                if (0 == $key) {
                    $message->setTo($emailDest);
                } else {
                    $message->addCc($emailDest);
                }
            }
            $message
            ->setBody(
                $this->template->render(
                    // templates/emails/registration.html.twig
                    'email/dossierAFournir.mail.twig', 
                    [
                        'demande' => $demande,
                        'daf'     => $daf,
                        'client'  => $this->tokenStorage->getToken()->getUser()->getClient(),
                    ]
                ),
                'text/html'
            );
            foreach ($infos->getDocuments() as $data) {
                if (null != $data) {
                    $message->attach(Swift_Attachment::fromPath($data));
                }
            }
            
            $this->mailer->send($message);
        }
        

        return 'success';
    }
}
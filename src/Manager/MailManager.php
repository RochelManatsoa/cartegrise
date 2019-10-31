<?php

namespace App\Manager;

use Swift_Mailer;
use Swift_Attachment;
use App\Entity\Demande;
use App\Manager\Model\ParamDocumentAFournir;
use App\Manager\{DemandeManager, NotificationEmailManager};
use App\Entity\NotificationEmail;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MailManager
{
    private $tokenStorage;
    private $template;
    private $mailer;
    private $demandeManager;
    private $parameterBagInterface;
    const SENDER_MAIL = "no-reply@cgofficiel.fr";
    public function __construct
    (
        TokenStorageInterface $tokenStorage,
        DemandeManager $demandeManager,
        \Twig_Environment $template,
        Swift_Mailer $mailer,
        ParameterBagInterface $parameterBagInterface,
        NotificationEmailManager $notificationManager
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->template = $template;
        $this->mailer = $mailer;
        $this->demandeManager = $demandeManager;
        $this->notificationManager = $notificationManager;
        $this->parameterBagInterface = $parameterBagInterface;
        $this->notificationManager = $notificationManager;
    }
    public function sendMailDocumentAFournir(Demande $demande, ParamDocumentAFournir $infos)
    {
        $daf = $this->demandeManager->getDossiersAFournir($demande);
        $owner = $demande->getCommande()->getClient()->getUser();
        $now = (new \DateTime())->getTimestamp();
        $encoder = hash('sha256', $now);
        $demande->setChecker($encoder)->setStatusDoc(Demande::DOC_PENDING);
        $this->demandeManager->saveDemande($demande);
        $emailDests = $this->notificationManager->getAllEmailOf(NotificationEmail::FILE_NOTIF);
        if (\is_iterable($emailDests) && 0 < count($emailDests)){
            $message = (new \Swift_Message($infos->getName() . ' ' . $owner->getEmail()))
            // ->setFrom($this->tokenStorage->getToken()->getUser()->getEmail());
            ->setFrom('no-reply@cgofficiel.fr');
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
                        'client'  => $owner->getClient(),
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

    public function sendEmail($emails=[], $template,string $object="", $params, $attachments=[], $cc=[], $from='no-reply@cgofficiel.fr')
    {
        if (\is_iterable($emails) && 0 < count($emails)){
            $message = (new \Swift_Message($object))
            ->setFrom($from);
            foreach ($emails as $key => $emailDest) {
                if (0 == $key) {
                    $message->setTo($emailDest);
                } else {
                    $message->addCc($emailDest);
                }
            }
            $message
            ->setBody(
                $this->template->render(
                    $template, 
                    $params
                ),
                'text/html'
            );
            foreach ($attachments as $data) {
                if (null != $data) {
                    $message->attach(Swift_Attachment::fromPath($data));
                }
            }
            
            $this->mailer->send($message);
        }
        

        return 'success';
    }
}
<?php

namespace App\Manager;

use Swift_Mailer;
use Swift_Attachment;
use App\Entity\{Demande, Client};
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
        $now = (new \DateTime())->getTimestamp();
        $encoder = hash('sha256', $now);
        $demande->setChecker($encoder);
        if ($demande->getStatusDoc() != Demande::DOC_VALID_SEND_TMS) {
            if ($demande->getStatusDoc() == Demande::WILL_BE_UNCOMPLETED) {
                $demande->setStatusDoc(Demande::DOC_UNCOMPLETED);
            } else {
                $demande->setStatusDoc(Demande::DOC_PENDING);
            }
        }
        
        $this->demandeManager->saveDemande($demande);
        if (!$demande->getCommande()->getClient() instanceof Client)
            return;
        $owner = $demande->getCommande()->getClient()->getUser();
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


    /**
     * send email when admins change statusDoc
     */
    public function sendEmailStatusDoc($mailer, $mail, $responses, $index)
    {
        $message = (new \Swift_Message('Statut de vos dossiers sur CGOfficiel.fr'))
        ->setFrom('no-reply@cgofficiel.fr');
        $message->setTo($mail);
        $message
        ->setBody(
            $this->template->render(
                'email/status/doc'.$index.'.mail.twig',
                array('demande' => $responses)
            ),
            'text/html'
        );
        $mailer->send($message);
    }
}
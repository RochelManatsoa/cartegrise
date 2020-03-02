<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\{PaymentUtils, PaymentResponseTreatment, StatusTreatment};
use App\Entity\Commande;
use App\Entity\Demande;
use App\Entity\NotificationEmail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Manager\SessionManager;
use App\Manager\{DemandeManager, CommandeManager};
use App\Manager\FraisTreatmentManager;
use App\Manager\TransactionManager;
use App\Manager\HistoryTransactionManager;
use App\Manager\NotificationEmailManager;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Manager\Systempay\SystemPayManager;
use App\Entity\Systempay\Transaction as SystempayTransaction;


class PaymentController extends AbstractController
{
    private $systempay;

    public function __construct(SystemPayManager $systempay)
    {
        $this->systempay = $systempay;
    }
    /**
     * @Route("/commande/{commande}/payment", name="payment_commande")
     */
    public function index(Commande $commande, FraisTreatmentManager $fraisTreatmentManager)
    {
        $amount = (integer) $fraisTreatmentManager->fraisTotalOfCommande($commande);
        dd(((float)$amount) . 0.03);
        
        return $this->render(
            "payment/index.html.twig", 
            [
                'commande' => $commande,
                'amount' => $amount,
                'amount3fois' => (($amount . 1.03) / 3),
                'amount4fois' => (($amount . 1.035) / 4)
            ]
        );
    }

    /**
     * @Route("/payment/request/{commande}", name="payment_request")
     */
    public function request(
        Commande $commande, 
        PaymentUtils $paymentUtils, 
        ParameterBagInterface $parameterBag, 
        CommandeManager $commandeManager, 
        TransactionManager $transactionManager,
        FraisTreatmentManager $fraisTreatmentManager
    )
    {
        $amount = $fraisTreatmentManager->fraisTotalOfCommande($commande);
        $email = $this->getUser()->getEmail();
        $commandeManager->checkPayment($commande);
        $idTransaction = $transactionManager->generateIdTransaction($commande->getTransaction());
        $amount *=100;
        $paramDynamical = [
            'amount' => $amount,
            'customer_email' => $email,
        ];
        $param = $parameterBag->get('payment_params');
        $bin   = $parameterBag->get('payment_binary');
        $param = array_merge($param, $paramDynamical);
        $response = $paymentUtils->request($param, $bin);
        $commande->getTransaction()->setTransactionId($response['transactionId']);
        $transactionManager->save($commande->getTransaction());
        
        return new Response($response['template']);
    }

    /**
     * @Route("/payment/ipn", name="instant_payment_notification")
     */
    public function notification(
        Request $request, 
        SessionManager $sessionManager, 
        \Swift_Mailer $mailer,
        PaymentUtils $paymentUtils,
        ParameterBagInterface $parameterBag, 
        PaymentResponseTreatment $responseTreatment, 
        StatusTreatment $statusTreatment,
        HistoryTransactionManager $historyTransactionManager,
        TransactionManager $transactionManager,
        DemandeManager $demandeManager,
        NotificationEmailManager $notificationManager,
        CommandeManager $commandeManager
    )
    {
        $response = $request->request->get('DATA');
        $responses = $this->getResponse($response, $paymentUtils, $parameterBag, $responseTreatment);
        $adminEmails = $notificationManager->getAllEmailOf(NotificationEmail::PAIMENT_NOTIF);
        // send mail
            $this->addHistoryTransaction($responses, $historyTransactionManager);
            $transaction = $transactionManager->findByTransactionId($responses["transaction_id"]);
            $commande = $transaction->getCommande() == null ? $transaction->getDemande()->getCommande() : $transaction->getCommande();
            $files = [];
            if ($transaction->getStatus() === '00') {
                $commande->setPaymentOk(true);
                $commandeManager->migrateFacture($commande);
                $commandeManager->save($commande);
                $transaction->setFacture($transactionManager->generateNumFacture());
                $transactionManager->save($transaction);
                $file = $commandeManager->generateFacture($commande);
                $files = [$file];
            }
            $this->sendMail($mailer, $responses, $responses["customer_email"], $adminEmails, $files);
        // end send mail

        return new Response('ok');
    }

    /**
     * @Route("/payment/success", name="payment_success")
     */
    public function success(
        Request $request,
        PaymentUtils $paymentUtils,
        ParameterBagInterface $parameterBag,
        PaymentResponseTreatment $responseTreatment,
        TransactionManager $transactionManager
    )
    {
        $response = $request->request->get('DATA');
        // dd($response);
        $responses = $this->getResponse($response, $paymentUtils, $parameterBag, $responseTreatment);
        $transaction = $transactionManager->findByTransactionId($responses["transaction_id"]);
        $transactionManager->save($transaction);

        return $this->render(
                'transaction/transactionResponse.html.twig',
                [
                    'responses' => $responses,
                    'transaction' => $transaction,
                ]
        );
    }

    /**
     * @Route("/payment/cancel", name="payment_cancel")
     */
    public function cancel(
        Request $request,
        PaymentUtils $paymentUtils,
        ParameterBagInterface $parameterBag, 
        PaymentResponseTreatment $responseTreatment
    )
    {
        $response = $request->request->get('DATA');
        $responses = $this->getResponse($response, $paymentUtils, $parameterBag, $responseTreatment);

        return $this->render(
                'transaction/transactionResponse.html.twig',
                [
                    'responses' => $responses,
                    'transaction' => null,
                ]
        );
    }

    /**
     * @Route("/payment/{demande}/facture", name="payment_facture")
     */
    public function facture(Demande $demande, FraisTreatmentManager $fraisTreatmentManager, DemandeManager $demandeManager)
    {
        $file = $demandeManager->generateFacture($demande);

        return new BinaryFileResponse($file);
    }

    /**
     * @Route("/payment-commande/{commande}/facture", name="payment_facture_commande")
     */
    public function factureCommande(Commande $commande, FraisTreatmentManager $fraisTreatmentManager, CommandeManager $commandeManager)
    {
        $file = $commandeManager->generateFacture($commande);

        return new BinaryFileResponse($file);
    }

    /**
     * @Route("/payment/{demande}/avoir", name="payment_avoir")
     */
    public function avoir(Demande $demande, FraisTreatmentManager $fraisTreatmentManager, DemandeManager $demandeManager)
    {
        $file = $demandeManager->generateAvoir($demande);

        return new BinaryFileResponse($file);
    }

    /**
     * @Route("/payment/{commande}/command-avoir", name="payment_avoir_commande")
     */
    public function avoirCommande(Commande $commande, FraisTreatmentManager $fraisTreatmentManager, CommandeManager $commandeManager)
    {
        $file = $commandeManager->generateAvoir($commande);

        return new BinaryFileResponse($file);
    }

    // to get response
    private function getResponse($response, $paymentUtils, $parameterBag, $responseTreatment)
    {
        $param = $parameterBag->get('payment_params');
        $bin   = $parameterBag->get('payment_binary');
        $return = $paymentUtils->decode($bin['response'], $param['pathfile'], $response);
    
        return $responses = $responseTreatment->getResponse($return);
    }

    //function to send email with response in sherlock treatment
    public function sendMail($mailer, $responses, $mail , $admins = [], $attachments=[])
    {
        $this->send($mailer, $mail, $responses, '', $attachments);
        $this->send($mailer, $admins, $responses, "chère Admin, ", $attachments);
    }
    //function to send email unit
    public function send($mailer, $mail, $responses, $adminPrepend='', $attachments)
    {
        $message = (new \Swift_Message($adminPrepend.'Transaction  n°: ' .$responses["transaction_id"]. ' de ' . $responses["customer_email"] ))
        ->setFrom('no-reply@cgofficiel.fr');
        if ($adminPrepend != '' && is_iterable($mail) && count($mail)>0) {
            $message->setTo(array_shift($mail))
            ->setBcc($mail);
        } else {
            $message->setTo($mail);
        }
        $message
        ->setBody(
            $this->renderView(
                'email/registration.mail.twig',[
                    'responses' => $responses,
                    // 'transaction' => $this->transactionManager->findByTransactionId($responses["transaction_id"])
                ]
            ),
            'text/html'
        );
        foreach ($attachments as $attachment){
            $message->attach(\Swift_Attachment::fromPath($attachment));
        }
        $mailer->send($message);
    }

    public function addHistoryTransaction($responses, HistoryTransactionManager $historyTransactionManager)
    {
        $historyTransactionManager->saveResponseTransaction($responses);
    }

    /**
     * @Route("{commande}/initiate-payment/{multiple?}", name="pay_online")
     */
    public function payOnlineAction(Commande $commande, $multiple = null, CommandeManager $commandeManager, FraisTreatmentManager $fraisTreatmentManager)
    {
        

        $amount = (integer) 100 * $fraisTreatmentManager->fraisTotalOfCommande($commande);
        
        $email = $this->getUser()->getEmail();

        // additional feld 
        $fields = [
            'cust_email' => $email,
            'cust_first_name' => $this->getUser()->getClient()->getClientNom(),
            'cust_last_name' => $this->getUser()->getClient()->getClientPrenom(),
            'cust_phone' => $this->getUser()->getClient()->getClientContact()->getContactTelmobile(),
        ];
        // for multiple paiement
        if ($multiple == 3){
            $amount = ceil($amount * 1.03 );
            $montant = $amount / 3;
        } elseif ($multiple == 4) {
            $amount = ceil($amount * 1.035 );
            $montant = $amount / 4;
        }


        if (SystempayTransaction::MULTI_PROPOSE_UP < $amount){
            if ($multiple !== null){
                $fields['payment_config'] = 'MULTI:first='.ceil($montant).';count='.$multiple.';period=30';
            }
        }
        

        $systempay = $this->systempay
            ->init($currency = 978, $amount)
            ->setOptionnalFields($fields)
        ;

        $commandeManager->saveSystempay($commande, $systempay->getTransaction());
        
        

        return $this->render('payment/systempay.html.twig',[
                'paymentUrl' => $systempay->getPaymentUrl(),
                'fields' => $systempay->getResponse(),
            ]
        );
    }

    /**
     * @Route("/payment/verification")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function paymentVerificationAction(Request $request)
    {
        // dd($request->request->all(), $request->query->all());
        // ...
        $this->systempay
            ->responseHandler($request)
        ;

        return new Response('paiement ok ');
    }
}


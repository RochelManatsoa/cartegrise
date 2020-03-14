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
use Doctrine\Common\Collections\ArrayCollection;


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
        $amount = (integer) 100 * $fraisTreatmentManager->fraisTotalOfCommande($commande);
        $amount3fois = round($amount * 1.036);
        $amount3fois = $amount3fois/100;
        $amount4fois = round($amount * 1.042);
        $amount4fois = $amount4fois/100;
        
        return $this->render(
            "payment/index.html.twig", 
            [
                'commande' => $commande,
                'amount' => $amount,
                'amount1fois' => round($amount/100),
                'amount3fois' => $amount3fois,
                'amount4fois' => $amount4fois,
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
    public function sendMail($mailer, $responses, $mail , $admins = [], $attachments=[], $commande=null)
    {
        $this->send($mailer, $mail, $responses, '', $attachments, $commande);
        $this->send($mailer, $admins, $responses, "chère Admin, ", $attachments, $commande);
    }
    //function to send email unit
    public function send($mailer, $mail, $responses, $adminPrepend='', $attachments, $commande)
    {
        $message = (new \Swift_Message($adminPrepend.'Transaction  n°: ' .$responses["vads_trans_id"]. ' de ' . $responses["vads_cust_email"] ))
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
                    'commande' => $commande
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
        
        $user = $this->getUser();
        $email = $user->getEmail();

        // additional feld 
        $fields = [
            'order_id' => $commande->getId(),
            'cust_email' => $email,
            'cust_first_name' => $this->getUser()->getClient()->getClientNom(),
            'cust_last_name' => $this->getUser()->getClient()->getClientPrenom(),
            'cust_phone' => $this->getUser()->getClient()->getClientContact()->getContactTelmobile(),
        ];
        // for multiple paiement
        if ($multiple == 3){
            $amount = round($amount * 1.036 );
            $montant = $amount / 3;
        } elseif ($multiple == 4) {
            $amount = round($amount * 1.042 );
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
        $transaction = $systempay->getTransaction();
        $transaction->setUser($user);
        $transaction->setMultiple($multiple);
        $user->addTransaction($transaction);

        $commandeManager->saveSystempay($commande, $transaction);
        
        

        return $this->render('payment/systempay.html.twig',[
                'paymentUrl' => $systempay->getPaymentUrl(),
                'fields' => $systempay->getResponse(),
            ]
        );
    }

    /**
     * @Route("/payment/verification", name="paiement_systempay_verification")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function paymentVerificationAction(
        Request $request,
        CommandeManager $commandeManager,
        \Swift_Mailer $mailer,
        NotificationEmailManager $notificationManager
        )
    {
        $responses = $request->request->all();
        $this->systempay
            ->responseHandler($request)
        ;
        $requestCollection = new ArrayCollection($responses);
        $requestCollection = clone $requestCollection;
        $adminEmails = $notificationManager->getAllEmailOf(NotificationEmail::PAIMENT_NOTIF);
        $id = $requestCollection->get('vads_order_id');
        $commande = $commandeManager->find($id);
        if ($requestCollection->get('signature')){
            if ($requestCollection->get('vads_trans_status') == "AUTHORISED"){
                $commande->setPaymentOk(true);
                $commandeManager->migrateFacture($commande);
                $commandeManager->simulateTransaction($commande);
                $commandeManager->save($commande);
            }
            $files = [];
            if ($requestCollection->get('vads_trans_status') == "AUTHORISED") {
                $file = $commandeManager->generateFacture($commande);
                $files = [$file];
            }
            $this->sendMail($mailer, $responses, $responses["vads_cust_email"], $adminEmails, $files, $commande);
        }
        
        


        return new Response('paiement ok ');
    }

    /**
     * @Route("/payment/return")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function paymentReturn(
                Request $request,
        CommandeManager $commandeManager,
        \Swift_Mailer $mailer,
        NotificationEmailManager $notificationManager
    )
    {
        // // simulator
        // $responses = [
        //     "vads_amount"=>"22119",
        //     "vads_auth_mode"=>"FULL",
        //     "vads_auth_number"=>"3fd8dd",
        //     "vads_auth_result"=>"00",
        //     "vads_capture_delay"=>"0",
        //     "vads_card_brand"=>"E-CARTEBLEUE",
        //     "vads_card_number"=>"415056XXXXXX0011",
        //     "vads_payment_certificate"=>"3393ccd8aac9acb3483be60edb540ecd6a51aa9b",
        //     "vads_ctx_mode"=>"TEST",
        //     "vads_currency"=>"978",
        //     "vads_effective_amount"=>"7373",
        //     "vads_effective_currency"=>"978",
        //     "vads_site_id"=>"21275319",
        //     "vads_trans_date"=>"20200311100142",
        //     "vads_trans_id"=>"000065",
        //     "vads_trans_uuid"=>"dc4900afa4da45368a8f38ae1d464bda",
        //     "vads_validation_mode"=>"0",
        //     "vads_version"=>"V2",
        //     "vads_warranty_result"=>"NO",
        //     "vads_payment_src"=>"EC",
        //     "vads_order_id"=>"421",
        //     "vads_cust_email"=>"johancgo2@yopmail.com",
        //     "vads_cust_name"=>"Leduc Johan",
        //     "vads_cust_first_name"=>"Leduc",
        //     "vads_cust_last_name"=>"Johan",
        //     "vads_cust_phone"=>"0787006257",
        //     "vads_sequence_number"=>"1",
        //     "vads_contract_used"=>"5057229",
        //     "vads_trans_status"=>"AUTHORISED",
        //     "vads_expiry_month"=>"6",
        //     "vads_expiry_year"=>"2021",
        //     "vads_bank_code"=>"30003",
        //     "vads_bank_label"=>"Soci\u00e9t\u00e9 g\u00e9n\u00e9rale",
        //     "vads_bank_product"=>"A",
        //     "vads_pays_ip"=>"FR",
        //     "vads_presentation_date"=>"20200311100142",
        //     "vads_effective_creation_date"=>"20200311100142",
        //     "vads_operation_type"=>"DEBIT",
        //     "vads_threeds_enrolled"=>"U",
        //     "vads_threeds_auth_type"=>"",
        //     "vads_threeds_cavv"=>"",
        //     "vads_threeds_eci"=>"",
        //     "vads_threeds_xid"=>"",
        //     "vads_threeds_cavvAlgorithm"=>"",
        //     "vads_threeds_status"=>"",
        //     "vads_threeds_sign_valid"=>"",
        //     "vads_threeds_error_code"=>"6",
        //     "vads_threeds_exit_status"=>"6",
        //     "vads_result"=>"00",
        //     "vads_extra_result"=>"",
        //     "vads_card_country"=>"FR",
        //     "vads_language"=>"fr",
        //     "vads_hash"=>"97c55de1bfaf984e8943beaddfd90e3d7b0e92e8d3686ce9a95a125d67eb1fc3",
        //     "vads_url_check_src"=>"PAY",
        //     "vads_action_mode"=>"INTERACTIVE",
        //     "vads_payment_config"=>"MULTI:first=7373;count=3;period=30",
        //     "vads_page_action"=>"PAYMENT",
        //     "signature" => "mfjkqmlkjfsqd"
        // ];
        // $request->request->replace($responses);
        // $requestCollection = new ArrayCollection($responses);
        // $requestCollection = clone $requestCollection;
        // $adminEmails = $notificationManager->getAllEmailOf(NotificationEmail::PAIMENT_NOTIF);
        // $this->systempay
        //     ->responseHandler($request)
        // ;
        // $id = $requestCollection->get('vads_order_id');
        // $commande = $commandeManager->find($id);
        // if ($requestCollection->get('signature')){
        //     if ($requestCollection->get('vads_trans_status') == "AUTHORISED"){
        //         $commande->setPaymentOk(true);
        //         $commandeManager->migrateFacture($commande);
        //         $commandeManager->simulateTransaction($commande);
        //         $commandeManager->save($commande);
        //     }
        //     $files = [];
        //     if ($requestCollection->get('vads_trans_status') == "AUTHORISED") {
        //         $file = $commandeManager->generateFacture($commande);
        //         $files = [$file];
        //     }
        //     $this->sendMail($mailer, $responses, $responses["vads_cust_email"], $adminEmails, $files, $commande);
        // }
        // end simulator
        $user = $this->getUser();
        $transaction = $user->getTransactions()->last();
        
        $systempayTransaction = $transaction->getCommande()->getSystempayTransaction();
        $logs = $systempayTransaction->getLogResponse();
        $logs = \json_decode($logs);

            // dd($logs);
        return $this->render(
                'transaction/transactionResponseSystempay.html.twig',
                [
                    'transaction' => $systempayTransaction,
                    'logs' => $logs
                ]
        );
    }
}


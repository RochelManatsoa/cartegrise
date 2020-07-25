<?php

namespace App\Manager\Systempay;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Systempay\Transaction;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class SystemPay
 * @package Tlconseil\SystempayBundle\Service
 */
class SystempayManager
{
    /**
     * @var string
     */
    private $paymentUrl = 'https://systempay.cyberpluspaiement.com/vads-payment/';

    /**
     * @var array
     */
    private $mandatoryFields = array(
        'action_mode' => null,
        'ctx_mode' => null,
        'page_action' => null,
        'payment_config' => null,
        'site_id' => null,
        'version' => null,
        'redirect_success_message' => null,
        'redirect_error_message' => null,
        'url_return' => null,
    );

    /**
     * @var string
     */
    private $key;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Transaction
     */
    private $transaction;

    public function __construct(EntityManager $entityManager, Container $container)
    {
        $this->entityManager = $entityManager;
        $systempayParam = $container->getParameterBag()->get('tlconseil_systempay');
        $systempayCollection = new ArrayCollection($systempayParam);
        foreach ($this->mandatoryFields as $field => $value)
            $this->mandatoryFields[$field] = $systempayCollection->get($field);
        if ($this->mandatoryFields['ctx_mode'] == "TEST")
            $this->key = $systempayCollection->get("key_dev");
        else
            $this->key = $systempayCollection->get("key_prod");

    }

    /**
     * @param $currency
     * @param $amount
     * @return Transaction
     */
    private function newTransaction($currency, $amount)
    {
        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setCurrency($currency);
        $transaction->setCreatedAt(new \DateTime());
        $transaction->setUpdatedAt(new \DateTime());
        $transaction->setPaid(false);
        $transaction->setRefunded(false);
        $transaction->setStatus("");
        $this->entityManager->persist($transaction);
        $this->entityManager->flush();
        return $transaction;
    }

    /**
     * @param int $currency
     * Euro => 978
     * US Dollar => 840
     * @param int $amount
     * Use int :
     * 10,28 € = 1028
     * 95 € = 9500
     * @return $this
     */
    public function init($currency = 978, $amount = 1000)
    {
        $this->transaction = $this->newTransaction($currency, $amount);
        $this->mandatoryFields['amount'] = $amount;
        $this->mandatoryFields['currency'] = $currency;
        $this->mandatoryFields['trans_id'] = sprintf('%06d', $this->transaction->getId());
        $this->mandatoryFields['trans_date'] = gmdate('YmdHis');
        return $this;
    }

    /**
     * @param $fields
     * remove "vads_" prefix and form an array that will looks like :
     * trans_id => x
     * cust_email => xxxxxx@xx.xx
     * @return $this
     */
    public function setOptionnalFields($fields)
    {
        foreach ($fields as $field => $value)
            if (empty($this->mandatoryFields[$field]) || $field == 'payment_config')
                $this->mandatoryFields[$field] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        $this->mandatoryFields['signature'] = $this->getSignature();
        return $this->mandatoryFields;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function responseHandler(Request $request)
    {
        $query = $request->request->all();
        

        // Check signature
        if (!empty($query['signature']))
        {
            $signature = $query['signature'];
            unset ($query['signature']);
            if ($signature == $this->getSignature($query))
            {
                $transaction = $this->findTransaction($request);
                $transaction->setStatus($query['vads_trans_status']);
                if ($query['vads_trans_status'] == "AUTHORISED") {
                    $transaction->setPaid(true);
                }  
                $transaction->setUpdatedAt(new \DateTime());
                $transaction->setLogResponse(json_encode($query));
                $this->entityManager->flush();
                return true;
            }
        }
        return false;
    }
    
    /**
     * @return Transaction
     */
    public function findTransaction(Request $request)
    {
        $query = $request->request->all();
        $this->transaction = $this->entityManager->getRepository(Transaction::class)->find($query['vads_trans_id']);
        
        return $this->transaction;
    }

    /**
     * @return string
     */
    public function getPaymentUrl()
    {
        return $this->paymentUrl;
    }

    /**
     * @return Transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param array $fields
     * @return array
     */
    private function setPrefixToFields(array $fields)
    {
        $newTab = array();
        foreach ($fields as $field => $value)
            $newTab[sprintf('vads_%s', $field)] = $value;
        return $newTab;
    }

    /**
     * @param null $fields
     * @return string
     */
    private function getSignature($fields = null)
    {
        if (!$fields)
            $fields = $this->mandatoryFields = $this->setPrefixToFields($this->mandatoryFields);
        ksort($fields);
        $contenu_signature = "";
        foreach ($fields as $field => $value)
                $contenu_signature .= $value."+";
        $contenu_signature .= $this->key;
        $signature = sha1($contenu_signature);
        return $signature;
    }

    public function similateResponse()
    {
        return [
            "signature"=>"mfdskqjmkfqsjy",
            "vads_amount"=>"3174",
            "vads_auth_mode"=>"FULL",
            "vads_auth_number"=>"3fec68",
            "vads_auth_result"=>"00",
            "vads_capture_delay"=>"0",
            "vads_card_brand"=>"CB",
            "vads_card_number"=>"497010XXXXXX0014",
            "vads_payment_certificate"=>"c800e07839d0eae3c8198fa395fc89b206e8576b",
            "vads_ctx_mode"=>"TEST",
            "vads_currency"=>"978",
            "vads_effective_amount"=>"3174",
            "vads_effective_currency"=>"978",
            "vads_site_id"=>"21275319",
            "vads_trans_date"=>"20200725143612",
            "vads_trans_id"=>"000016",
            "vads_trans_uuid"=>"5d4b401773724d8880b219e9be5d5173",
            "vads_validation_mode"=>"0",
            "vads_version"=>"V2",
            "vads_warranty_result"=>"YES",
            "vads_payment_src"=>"EC",
            "vads_cust_email"=>"rapaelec@gmail.com",
            "vads_cust_name"=>"RAKOTOARIVELO patrick",
            "vads_cust_first_name"=>"RAKOTOARIVELO",
            "vads_cust_last_name"=>"patrick",
            "vads_cust_phone"=>"0326770277",
            "vads_sequence_number"=>"1",
            "vads_contract_used"=>"5057229",
            "vads_trans_status"=>"AUTHORISED",
            "vads_expiry_month"=>"6",
            "vads_expiry_year"=>"2021",
            "vads_bank_label"=>"Banque de d\u00e9mo et de l'innovation",
            "vads_bank_product"=>"F",
            "vads_pays_ip"=>"ZA",
            "vads_presentation_date"=>"20200725143613",
            "vads_effective_creation_date"=>"20200725143613",
            "vads_operation_type"=>"DEBIT",
            "vads_threeds_enrolled"=>"Y",
            "vads_threeds_auth_type"=>"CHALLENGE",
            "vads_threeds_cavv"=>"Q2F2dkNhdnZDYXZ2Q2F2dkNhdnY=",
            "vads_threeds_eci"=>"05",
            "vads_threeds_xid"=>"NWJRdmVsdDRnRmdLendSQVlFN3o=",
            "vads_threeds_cavvAlgorithm"=>"2",
            "vads_threeds_status"=>"Y",
            "vads_threeds_sign_valid"=>"1",
            "vads_threeds_error_code"=>"",
            "vads_threeds_exit_status"=>"10",
            "vads_result"=>"00",
            "vads_extra_result"=>"",
            "vads_card_country"=>"FR",
            "vads_language"=>"en",
            "vads_brand_management"=>"{\"userChoice\":false,\"brandList\":\"CB|VISA\",\"brand\":\"CB\"}",
            "vads_hash"=>"7ece0ee83e6881cec95ee7efc89008f8e3b29514fb12e2ce41745841216dab75",
            "vads_url_check_src"=>"PAY",
            "vads_action_mode"=>"INTERACTIVE",
            "vads_payment_config"=>"SINGLE",
            "vads_page_action"=>"PAYMENT",
            "vads_order_id"=>"490",
        ];
    }
}

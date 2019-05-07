<?php

namespace App\Utils;

class PaymentResponseTreatment
{
    public function getResponse($value)
    {
        return $this->serialize($value);
    }
    private function serialize($value)
    {
        $array = explode("!", $value);
        $return = 
        [
            "code" => $array[1], "error" => $array[2] , "merchant_id" => $array[3], "merchant_country" => $array[4],
            "amount" => $array[5], "transaction_id" => $array[6], "payment_means" => $array[7], "transmission_date"=>$array[8],
            "payment_time" => $array[9], "payment_date" => $array[10], "response_code" => $array[11], "payment_certificate" => $array[12],
            "authorisation_id" => $array[13], "currency_code" => $array[14], "card_number" => $array[15], "cvv_flag" => $array[16],
            "cvv_response_code" => $array[17], "bank_response_code" => $array[18], "complementary_code" => $array[1 ], "complementary_info" => $array[20],
            "return_context" => $array[21], "caddie" => $array[22], "receipt_complement" => $array[23], "merchant_language" => $array[24],
            "language" => $array[25], "customer_id" => $array[26], "order_id" => $array[27], "customer_email" => $array[28],
            "customer_ip_address" => $array[29], "capture_day" => $array[30], "capture_mode" => $array[31], "data" => $array[32], "order_validity" => $array[33],
            "transaction_condition" => $array[34], "statement_reference" => $array[35], "card_validity" => $array[36], "score_value" => $array[37],
            "score_color" => $array[38], "score_info" => $array[39], "score_threshold" => $array[40], "score_profile" => $array[41],
            "threed_ls_code" => $array[43], "threed_relegation_code" => $array[44]
        ];
        
        return $return;
    }

}

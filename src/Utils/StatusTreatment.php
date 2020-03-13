<?php

namespace App\Utils;

class StatusTreatment
{
    private $message =
        [
            "AUTHORISED" => "Transaction approuvée"
        ];
    
    public function getMessageStatus($code)
    {
        
        return isset($this->message[$code]) ? $this->message[$code] : 'Erreur de Transaction';
    }
}

<?php

namespace App\Utils;

use App\Entity\Bank;

class PaymentUtils
{
    /**
     * the param must contain : 
     * amount : in Euro and convert percent
     * email: the customer email
     */
    public function request($parameters, $bin)
    {
        $parm = "";
        foreach($parameters as $key=>$param)
            $parm .= (strlen($parm) === 0) ? "".$key."=".$param : " ".$key."=".$param;
        
        $path_bin = $bin['request'];
        $path_bin_decode = $bin['response'];
        $parm = escapeshellcmd($parm);	
        $result=exec("$path_bin $parm");
        $tableau = explode ("!", "$result");
        //	r�cup�ration des param�tres
        $code = isset($tableau[1]) ? $tableau[1] : '';
        $error = isset($tableau[2]) ? $tableau[2] : '';
        $message = isset($tableau[3]) ? $tableau[3] : '';
        //  analyse du code retour
        $response = "";

        if (( $code == "" ) && ( $error == "" ) )
        {
        $response.="<BR><CENTER>erreur appel request</CENTER><BR>";
        $response.="executable request non trouve $path_bin";
        }
        //	Erreur, affiche le message d'erreur
        else if ($code != 0){
            $response.="<center><b><h2>Erreur appel API de paiement.</h2></center></b>";
            $response.="<br><br><br>";
            $response.=" message erreur : $error <br>";
        }
        //	OK, affiche le formulaire HTML
        else {
            $response.="<br><br>";
            
            # OK, affichage du mode DEBUG si activ�
            $response.=" $error <br>";
            
            $response.="  $message <br>";
        }
    //get TransactionId
        $transactionId = "";
        $transIdTreatment = explode('VALUE="', $message);
        if (isset($transIdTreatment[1])){
            $transIdTreatment = explode('"', $transIdTreatment[1]);
            $transIdTreatment = 'message='.$transIdTreatment[0];
            $pathfile = "pathfile=".$parameters['pathfile'];
            $transParams=exec("$path_bin_decode $pathfile  $transIdTreatment");
            $transactionInfos = explode('!', $transParams);
            if (isset($transactionInfos[6]))
                $transactionId = explode('!', $transParams)[6];
        }
    //end transactionId
        
        return [
            'template'      => $response,
            'transactionId' => $transactionId
        ];
    }
}
<?php

namespace App\Utils;

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
        
        return $response;
    }
}
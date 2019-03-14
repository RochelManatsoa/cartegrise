<?php
$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
$TMS_CodeTMS = "31-000100";
$TMS_Login = "JE@n-Y100";
$TMS_Password = "GY-31@mLA";

$TMS_Immatriculation = "BL-726-DJ";

$client = new SoapClient($TMS_URL);

$Ident = array("CodeTMS"=>$TMS_CodeTMS, "Login"=>$TMS_Login, "Password"=>$TMS_Password);

$servername = "localhost";
$username = "root";
$password = "KrS7gj72";
//$password = "";
$database = "cgdatabaseoff";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 



if(isset($_POST)){
    $Immatriculation = $_POST['Immatriculation'];
    $Departement = $_POST['Departement'];
    /*$Demarche = $_POST['Demarche'];*/

    $sqlfetchcommande = "SELECT * FROM `commande` WHERE `immatriculation` = ".$_POST['Immatriculation']." AND `code_postal` = ".$_POST['Departement']."";
    $res = $conn->query($sqlfetchcommande);

    $currentclientdemandenumrows = mysqli_num_rows($res);

    if($currentclientdemandenumrows == 0 ){

         $Vehicule = array("Immatriculation" => "$Immatriculation", "Departement" =>"$Departement");

        //-------------------------------------------------------------------------------------------------

        $DateDemarche = date('Y-m-d H:i:s');

        $ECG = array("ID" => "", "TypeDemarche" => "ECGAUTO", "DateDemarche" => $DateDemarche, "Vehicule" => $Vehicule);

        $Demarche = array("ECGAUTO" => $ECG);
        $Lot = array("Demarche" => $Demarche);


        $params = array("Identification"=>$Ident, "Lot" => $Lot);

        $Immat = array("Immatriculation"=>$TMS_Immatriculation);

        $params = array("Identification"=>$Ident, "Lot" => $Lot);

        //$value = $client->InfoImmat($params);
        $value = $client->Envoyer($params);
        //echo $value->InfoVehicule->Reponse->Positive->Immatriculation;
        //var_dump( $value->InfoVehicule->Reponse->Positive);
        //var_dump( $value->Lot->Demarche->ECGAUTO->Reponse->Positive); //OK
        //file_put_contents("/tmp/toto", $value->InfoVehicule->Reponse->Positive->Immatriculation);

        echo '<table class="table table-bordered table-striped mx-auto">';
        echo '<h2>CARACTÉRISTIQUES DU VÉHICULE</h2>';

        echo "<tr><th>Immatriculation</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->VIN."</td></tr>";
        echo "<tr><th>CO2</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->CO2."</td></tr>";
        echo "<tr><th>Genre</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->Genre."</td></tr>";
        echo "<tr><th>PTAC</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->PTAC."</td></tr>";
        echo "<tr><th>Energie</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->Energie."</td></tr>";
        echo "<tr><th>Date de mise en ciruclation</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->DateMEC."</td></tr>";

        echo '</table><br>';

        echo '<table class="table table-bordered table-striped mx-auto">';
        echo '<h2>DÉTAIL DES TAXES</h2>';
        echo "<tr><th>Taxe Regionale</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeRegionale."€</td></tr>";
        echo "<tr><th>Taxe > 35CV</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->Taxe35cv."€</td></tr>";
        echo "<tr><th>Taxe Parafiscale</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeParafiscale."€</td></tr>";
        echo "<tr><th>Taxe CO2</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeCO2."€</td></tr>";
        echo "<tr><th>Taxe Malus</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeMalus."€</td></tr>";
        echo "<tr><th>Taxe SIV</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeSIV."€</td></tr>";
        echo "<tr><th>Taxe RedevanceSIV</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeRedevanceSIV."€</td></tr>";
        echo "<tr><th>Frais de traitement du dossier</th><td> Nos Prix </td></tr>";
        echo "<tr><th>Taxe Totale</th><td><strong>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeTotale."€</strong></td></tr>";

        echo '</table><br>';

     /*   $sqlinsertcommande = "INSERT INTO `commande`(`demarche_id`, `code_postal`, `immatriculation`) VALUES (1,'$Departement','$Immatriculation')";     

        if($conn->query($sqlinsertcommande)){
            echo "<br>New Titulaire recorded";
        }
        else{
            echo "<br>Error NEW TITULAIRE: " .  $sqlinsertcommande . "<br>" . $conn->error;
        }*/

        echo '<a class="btn btn-success" href="/register?price='.$value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeTotale.'">VALIDER</a>';
    }
    else{
        //echo "Display demande";

        echo "<br><hr><h3>Vous avez déja effectué ".$currentclientdemandenumrows." demandes CTVO</h3>";


    }
}else{
    echo "Veuillez remplir les informations correctement";
}



/*echo var_dump($value);

echo "\r\n";*/

/*
    if($_POST){
    	
		$pricetotal = $client->calculerECGAuto($_POST);

		echo '<a class="btn btn-success" href="/register?price='.$pricetotal.'">LINK</a>';

    }else{

		echo "Veuillez remplir les informations correctement";
	}*/
/*
	} else {
	    $errors = $resp->getErrorCodes();
	}
*/



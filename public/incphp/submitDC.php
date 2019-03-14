<?php

include('client.class.php');
$client = new Client();

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


if(isset($_POST))
{

	$currentID = $_POST['currentID'];
	if( $_POST['personne2'] == "mor"){
        $raisonSociale2 = $_POST['RaisonSociale2'];
        $societeCommerciale2 = $_POST['SocieteCommerciale'];
        if(isset($_POST['SIREN'])){
            $siren = $_POST['SIREN'];
        }
        else{
            $siren = "";
        }
    }
    else{
        $nomacqu = $_POST['Nom'];
        $prenomacqu = $_POST['Prenom'];
        $genreacqu = $_POST['sexe'];
        if(isset($_POST['NomUsage'])){
            $nomusage = $_POST['NomUsage'];
            $acquphys = $nomusage.' '.$prenomacqu;

        }
        else{
            $nomusage = "";
            $acquphys = $nomacqu.' '.$prenomacqu;
        }
        $dateNacqu = $_POST['DateNaissance'];
        $villeN = $_POST['LieuNaissance'];
    }

	$opposition = $_POST['DroitOpposition'];
	$numeroRue= $_POST['Numero'];
	$extension = $_POST['ExtensionIndice'];
	$precision = $_POST['EtageEscAppt'];
	$typevoie = $_POST['TypeVoie'];
	$nomvoie = $_POST['NomVoie'];
	$complement = $_POST['Complement'];
	$lieudit = $_POST['LieuDit'];
	$codepostal = $_POST['CodePostal'];
	$ville = $_POST['Ville'];
	$boitepostale = $_POST['BoitePostale'];
	$pays = $_POST['Pays'];
	$cgpresent = $_POST['CIPresent'];
    $immatric = $_POST['Immatriculation'];
    $vin = $_POST['VIN'];
    if(isset($_POST['NumFormule'])){
		if(!empty($_POST['DateCI'])){
			$numformule = $_POST['NumFormule'];
		}
		else{
			$numformule = 0;
		}
    }
    else{
        $numformule = 0;
    }
    
    if(isset($_POST['DateCI']) ){
        if(empty($_POST['DateCI'])){
            $datecg = 'NULL';
        }
        else{
            $datecg = $_POST['DateCI'];
        }
        
    }
    else{
        $datecg = 'NULL';
    }




	$datetimedemande = date('Y-m-d H:i:s', time());


	//var_dump($_POST);

	$idtmsdivn = $client->sauverDC($_POST);
	$client->findParamsById($idtmsdivn,"DC");

	$sqlAcquereur = "SELECT client_id FROM fos_user WHERE id = ".$currentID;


	$result9 = $conn->query($sqlAcquereur);
	$rowacqu = mysqli_fetch_assoc($result9);
	$idclient = $rowacqu['client_id'];


	$sqlclientarray = "SELECT * FROM `client` WHERE `id` = ".$idclient;
	$resultaclientarray = $conn->query($sqlclientarray);
	$rowclient = mysqli_fetch_assoc($resultaclientarray);

	$adresseidclient = $rowclient['client_adresse_id'];

	//echo "<hr>";
	//var_dump($adresseidclient);

	//----get max id new titulaire-----------
                $sqlmaxidtitulaire = "SELECT max(id) FROM `new_titulaire`";
                $querymaxidtitulaire = $conn->query($sqlmaxidtitulaire);
                if($querymaxidtitulaire){
                    $rowmaxidtitulaire = $querymaxidtitulaire->fetch_assoc();
                    $maxidtitulaire = $rowmaxidtitulaire['max(id)'] + 1;
                }
                else{
                    $maxidtitulaire = 1;
                }

	//--------------------------------------new titulaire------------------------------------//

				if( $_POST['personne2'] == "phy"){
                    $sqlinsertnewtitulaire = "INSERT INTO `new_titulaire`(`id`, `nom_prenom_titulaire`, `genre`, `date_n`, `lieu_n`, `type`, `raison_sociale`, `societe_commerciale`, `siren`) VALUES ($maxidtitulaire,'$acquphys','$genreacqu','$dateNacqu','$villeN','physique','',0,'')";     
                }
                else{
                    $sqlinsertnewtitulaire = "INSERT INTO `new_titulaire`(`id`, `nom_prenom_titulaire`, `genre`, `date_n`, `lieu_n`, `type`, `raison_sociale`, `societe_commerciale`, `siren`) VALUES ($maxidtitulaire,'','',NULL,'','morale', '$raisonSociale2', $societeCommerciale2, '$siren')";     
                }
                echo '<hr>'.$sqlinsertnewtitulaire.'<hr>';


                //insert vehicule query
                if($conn->query($sqlinsertnewtitulaire)){
                    echo "<br>New Titulaire recorded";
                }
                else{
                    echo "<br>Error NEW TITULAIRE: " .  $sqlinsertnewtitulaire . "<br>" . $conn->error;
                }



	//----get max id ancien titulaire------
                $sqlmaxidancient = "SELECT max(id) FROM ancientitulaire";
                $querymaxidancient = $conn->query($sqlmaxidancient);
                $rowmaxidancient = $querymaxidancient->fetch_assoc();
                $maxidancient = $rowmaxidancient['max(id)'] + 1;

                //insertion ancient titulaire---------

                if($_POST['personne'] == "phy"){

                    //Ancien Titulaire physique
                    $ancienTitulaire = $_POST['NomPrenom'];  
                    $sqlinsertancientitulaire = "INSERT INTO ancientitulaire VALUES ( $maxidancient, 'physique', '', '$ancienTitulaire' )";
                }
                else{
                    //Ancien titulaire Morale
                    $ancienTitulaire = $_POST['RaisonSociale1'];
                    $sqlinsertancientitulaire = "INSERT INTO ancientitulaire VALUES ( $maxidancient, 'morale', '$ancienTitulaire', '' )";
                }
                
                //echo '<br>'.$sqlinsertancientitulaire;


                //insert ancient titulaire query
                if($conn->query($sqlinsertancientitulaire)){
                    echo "<br>ancient titulaire recorded";
                }
                else{
                    echo "<br>Error ANCIENT TITULAIRE: " . $sqlinsertancientitulaire . "<br>" . $conn->error;
                }


    //-----------------------------------------adressenewtitulaire---------------------------//
                $sqlmaxidadresse = "SELECT max(id) FROM `adresse_new_titulaire`";
                $querymaxidadresse = $conn->query($sqlmaxidadresse);
                if($querymaxidadresse){
                    $rowmaxidadresse = $querymaxidadresse->fetch_assoc();
                    $maxidadresse = $rowmaxidadresse['max(id)'] + 1;
                }
                else{
                    $maxidadresse = 1;
                }
                
                $nomvoie2 = utf8_encode($nomvoie);


                $sqlinsertadresse = "INSERT INTO `adresse_new_titulaire`(`id`, `numero_rue`, `extension`, `adprecision`, `typevoie`, `nomvoie`, `complement`, `lieudit`, `codepostal`, `ville`, `boitepostal`, `pays`, `titulaire_id`) VALUES ( $maxidadresse, $numeroRue, '$extension', '$precision', '$typevoie', '$nomvoie', '$complement', '$lieudit', '$codepostal', '$ville', '$boitepostale', '$pays', $maxidtitulaire )";

                        if($conn->query($sqlinsertadresse)){
                            echo "<br>adresse recorded";
                        }
                        else{
                            echo "<br>Error ADRESSE: " . $sqlinsertadresse . "<br>" . $conn->error;
                        }



	

	//--------------------------------------carte grise---------------------------------------//

	$sqlmaxidcartegrise = "SELECT max(id) FROM cartegrise";
	$querymaxidcartegrise = $conn->query($sqlmaxidcartegrise);
	$rowmaxidcartegrise = $querymaxidcartegrise->fetch_assoc();
	$maxidcartegrise = $rowmaxidcartegrise['max(id)'] + 1;

	$sqlinsertcginfo = "INSERT INTO cartegrise VALUES ( $maxidcartegrise, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL )";


	//$sqlinsertcg = "INSERT INTO `cartegrise`(`id`, `typevehicule`, `cgdepartement`, `modele`, `energie`, `cv`, `datecirculation`, `co2`, `ptac`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9])";
	//echo "<hr>".$sqlinsertcginfo;

	if($conn->query($sqlinsertcginfo)){
	    echo "<br>carte grise info recorded";
	}
	else{
	    echo "<br>Error Carte Grise: " .  $sqlinsertcginfo . "<br>" . $conn->error;
	}







	//---------------------------------------demande------------------------------------------------------------------------------

	$sqlmaxiddemande = "SELECT max(id) FROM demande";
	$querymaxiddemande = $conn->query($sqlmaxiddemande);
	$rowmaxiddemande = $querymaxiddemande->fetch_assoc();
	$maxiddemande = $rowmaxiddemande['max(id)'] + 1;



	//$sqlinsertdemande = "INSERT INTO demande VALUES ( $maxiddemande, $idtmsdivn, $idclient, 'DIVN', $opposition, 'demande effectue en attente de paiement', 'KO', 'progression test', '$datetimedemande', NULL, NULL )";
	$sqlinsertdemande = "INSERT INTO `demande`(`id`, `client_id`, `type_demande`, `oppose_demande`, `statut_demande`, `paiement_demande`, `tms_id_demande`, `progression_demande`, `date_demande`, `prix`, `nomfic`, `acquerreur_id`, `nom_demande_id`) VALUES ( $maxiddemande, $idclient, 'DC', $opposition, 'demande effectue en attente de paiement', 'KO', $idtmsdivn, 'progression test', '$datetimedemande', NULL, NULL, $maxidtitulaire, 5)";
	//echo $sqlinsertdemande;

	//$sqlinsertdemande = "INSERT INTO `demande`(`id`, `tms_id_demande`, `client_id`, `type_demande`, `oppose_demande`, `statut_demande`, `paiement_demande`, `progression_demande`, `date_demande`, `prix`, `nomfic`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11])";
	//echo "<hr>".$sqlinsertdemande;


	if($conn->query($sqlinsertdemande)){
	    echo "<br>Demande recorded";
	}
	else{
	    echo "<br>Error Demande: " .  $sqlinsertdemande . "<br>" . $conn->error;
	}


	//------------------------------------------vehicule-----------------------------------------------------------------------------


	 $sqlmaxidvehicule = "SELECT max(id) FROM vehicule";
	$querymaxidvehicule = $conn->query($sqlmaxidvehicule);
	$rowmaxidvehicule = $querymaxidvehicule->fetch_assoc();
	$maxidvehicule = $rowmaxidvehicule['max(id)'] + 1;

	 $sqlinsertvehicule = "INSERT INTO vehicule VALUES ( $maxidvehicule, NULL, $maxidcartegrise, $maxiddemande, $idclient, $idclient, NULL, $maxidtitulaire, 0, 'inconnue', '$vin', 'aucun', NULL )";


	//$sqlinsertvehicule = "INSERT INTO `vehicule`(`id`, `vehicule_ancientitulaire_id`, `vehicule_adresse_id`, `vehicule_cartegrise_id`, `vehicule_demande_id`, `vehicule_client_id`, `client_id`, `cgpresent`, `immatriculation`, `vin`, `numformule`, `datecg`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],$vin,[value-11],[value-12])";
	//echo "<hr>".$sqlinsertvehicule;
	//$sqlinsertvehicule = "INSERT INTO `vehicule`(`id`, `vehicule_ancientitulaire_id`, `titulaire_id`, `vehicule_cartegrise_id`, `vehicule_demande_id`, `vehicule_client_id`, `client_id`, `cgpresent`, `immatriculation`, `vin`, `numformule`, `datecg`, `infosup_id`) VALUES ($maxidvehicule, NULL, $maxidtitulaire, $maxidcartegrise, $maxiddemande, $idclient, $idclient, 0, '$immatric', '$vin', $numformule, $datecg, NULL )";

	if(empty($_POST['DateCI'])){
			$sqlinsertvehicule = "INSERT INTO `vehicule`(`id`, `vehicule_ancientitulaire_id`, `titulaire_id`, `vehicule_cartegrise_id`, `vehicule_demande_id`, `vehicule_client_id`, `client_id`, `cgpresent`, `immatriculation`, `vin`, `numformule`, `datecg`, `infosup_id`) VALUES ($maxidvehicule, NULL, $maxidtitulaire, $maxidcartegrise, $maxiddemande, $idclient, $idclient, 0, '$immatric', '$vin', $numformule, NULL, NULL )";

        }
        else{
			$sqlinsertvehicule = "INSERT INTO `vehicule`(`id`, `vehicule_ancientitulaire_id`, `titulaire_id`, `vehicule_cartegrise_id`, `vehicule_demande_id`, `vehicule_client_id`, `client_id`, `cgpresent`, `immatriculation`, `vin`, `numformule`, `datecg`, `infosup_id`) VALUES ($maxidvehicule, NULL, $maxidtitulaire, $maxidcartegrise, $maxiddemande, $idclient, $idclient, 0, '$immatric', '$vin', $numformule, $datecg, NULL )";

        }

		

		if($conn->query($sqlinsertvehicule)){
	        echo "<br>vehicule info recorded";
	        ?>
<script>
	function myFunction() {
	    //location.reload();

	    var url = window.location.href;
	    var url2 = url+"/checkout/<?php echo $idtmsdivn ?>";
	    console.log(url);
	    console.log(url2);
	    window.location.href = url2;

	}

	myFunction();
</script>

<?php
	    }
	    else{
	        echo "<br>Error VEHICULE: " .  $sqlinsertvehicule . "<br>" . $conn->error;
	    }




}
else{
		echo "veuillez entrer vos information correctement";
}

?>

	


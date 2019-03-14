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
	//$vin = $_POST["VIN"];

	if($_POST['personne'] == 'phy'){
		$acquphys = $_POST['NomPrenom'];
	}
	else{
		$acquphys = $_POST['RaisonSociale1'];
	}
	$opposition = $_POST['DroitOpposition'];

	if(isset($_POST['Immatriculation'])){
		$immatriculation = $_POST['Immatriculation'];
	}
	else{
		$immatriculation = NULL;
	}

	if(isset($_POST['VIN'])){
		$vin = $_POST["VIN"];
	}
	else{
		$vin = NULL;
	}

	if(isset($_POST['NumFormule'])){
		$numformule = $_POST["NumFormule"];
	}
	else{
		$numformule = NULL;
	}

	if(isset($_POST['DateCI'])){
		$datecg = $_POST["DateCI"];
	}
	else{
		$datecg = NULL;
	}


	


	$datetimedemande = date('Y-m-d H:i:s', time());


	//var_dump($_POST);

	$idtmsdup = $client->envoyerDUP($_POST);
	var_dump($idtmsdup);
	echo "<hr><hr><hr>";
	$client->findParamsById($idtmsdup,"DUP");
	//$idtmsdup = 1;

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


                

				if( $_POST['personne'] == "phy"){


	                	$sqlinsertnewtitulaire = "INSERT INTO `new_titulaire`(`id`, `nom_prenom_titulaire`, `genre`, `date_n`, `lieu_n`, `type`, `raison_sociale`, `societe_commerciale`, `siren`) VALUES ($maxidtitulaire,'$acquphys',NULL,NULL,NULL,'physique',NULL,0,NULL)";
	                	//echo "<br>".$sqlinsertnewtitulaire;

                        
                }
                else{



	                	$sqlinsertnewtitulaire = "INSERT INTO `new_titulaire`(`id`, `nom_prenom_titulaire`, `genre`, `date_n`, `lieu_n`, `type`, `raison_sociale`, `societe_commerciale`, `siren`) VALUES ($maxidtitulaire,NULL,NULL,NULL,NULL,'morale', '$acquphys', 0, NULL)";
	                	//echo "<br>".$sqlinsertnewtitulaire;

                     
                }
                //echo '<hr>'.$sqlinsertnewtitulaire.'<hr>';


                //insert vehicule query
                if($conn->query($sqlinsertnewtitulaire)){
                    echo "<br>New Titulaire recorded";
                }
                else{
                    echo "<br>Error NEW TITULAIRE: " .  $sqlinsertnewtitulaire . "<br>" . $conn->error;
                }


	//--------------------------------------carte grise---------------------------------------//

	$sqlmaxidcartegrise = "SELECT max(id) FROM cartegrise";
	$querymaxidcartegrise = $conn->query($sqlmaxidcartegrise);
	$rowmaxidcartegrise = $querymaxidcartegrise->fetch_assoc();
	$maxidcartegrise = $rowmaxidcartegrise['max(id)'] + 1;

	$sqlinsertcginfo = "INSERT INTO `cartegrise`(`id`, `typevehicule`, `cgdepartement`, `modele`, `energie`, `cv`, `datecirculation`, `co2`, `ptac`) VALUES ( $maxidcartegrise, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL )";


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
	$sqlinsertdemande = "INSERT INTO `demande`(`id`, `client_id`, `type_demande`, `oppose_demande`, `statut_demande`, `paiement_demande`, `tms_id_demande`, `progression_demande`, `date_demande`, `prix`, `nomfic`, `acquerreur_id`) VALUES ( $maxiddemande, $idclient, 'DUP', $opposition, 'demande de duplicata effectue en attente de paiement', 'KO', $idtmsdup, 'progression test', '$datetimedemande', NULL, NULL, $maxidtitulaire)";
	//echo '<br>'.$sqlinsertdemande;

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

	 

	 if(isset($_POST['DateCI'])){
		$datecg = $_POST["DateCI"];
		$sqlinsertvehicule = "INSERT INTO `vehicule`(`id`, `vehicule_ancientitulaire_id`, `vehicule_cartegrise_id`, `vehicule_demande_id`, `vehicule_client_id`, `client_id`, `infosup_id`, `titulaire_id`, `cgpresent`, `immatriculation`, `vin`, `numformule`, `datecg`) VALUES ( $maxidvehicule, NULL, $maxidcartegrise, $maxiddemande, $idclient, $idclient, NULL, $maxidtitulaire, 0, '$immatriculation', '$vin', '$numformule', '$datecg' )";
	 //echo '<br>'.$sqlinsertvehicule;
	}
	else{
		$datecg = NULL;
		$sqlinsertvehicule = "INSERT INTO `vehicule`(`id`, `vehicule_ancientitulaire_id`, `vehicule_cartegrise_id`, `vehicule_demande_id`, `vehicule_client_id`, `client_id`, `infosup_id`, `titulaire_id`, `cgpresent`, `immatriculation`, `vin`, `numformule`, `datecg`) VALUES ( $maxidvehicule, NULL, $maxidcartegrise, $maxiddemande, $idclient, $idclient, NULL, $maxidtitulaire, 0, '$immatriculation', '$vin', '$numformule', NULL )";
	 //echo '<br>'.$sqlinsertvehicule;
	}


	//$sqlinsertvehicule = "INSERT INTO `vehicule`(`id`, `vehicule_ancientitulaire_id`, `vehicule_adresse_id`, `vehicule_cartegrise_id`, `vehicule_demande_id`, `vehicule_client_id`, `client_id`, `cgpresent`, `immatriculation`, `vin`, `numformule`, `datecg`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],$vin,[value-11],[value-12])";
	//echo "<hr>".$sqlinsertvehicule;

		

		

		if($conn->query($sqlinsertvehicule)){
	        echo "<br>vehicule info recorded";
	       ?>
<script>
	function myFunction() {
	    //location.reload();

	    var url = window.location.href;
	    var url2 = url+"/checkout/<?php echo $idtmsdup ?>";
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

	


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

	if($_POST['personne2'] == 'phy'){
		
		$genretitulaire = $_POST['sexe'];
		if($genretitulaire == 'F'){
			//$nomusage = $_POST['NomUsage'];
			$acquphys = $_POST['NomUsage'].' '.$_POST['Prenom'];
		}
		else{
			$acquphys = $_POST['Nom'].' '.$_POST['Prenom'];
		}
		$dateN = $_POST['DateNaissance'];
		$villeN = $_POST['LieuNaissance'];

	}
	else{
		$acquphys = $_POST['RaisonSociale2'];
		$societecommerciale = $_POST['SocieteCommerciale'];
		if(isset($_POST['SIREN'])){
			$siren = $_POST['SIREN'];
		}
		else{
			$siren = NULL;
		}
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

    $numeroRue2= $_POST['Numero2'];
    $extension2 = $_POST['ExtensionIndice2'];
    $precision2 = $_POST['EtageEscAppt2'];
    $typevoie2 = $_POST['TypeVoie2'];
    $nomvoie2 = $_POST['NomVoie2'];
    $complement2 = $_POST['Complement2'];
    $lieudit2 = $_POST['LieuDit2'];
    $codepostal2 = $_POST['CodePostal2'];
    $ville2 = $_POST['Ville2'];
    $boitepostale2 = $_POST['BoitePostale2'];



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

	$idtmsdca = $client->sauverDCA($_POST);
	var_dump($idtmsdca);
	//echo "<hr><hr><hr>";
	$client->findParamsById($idtmsdca,"DCA");
	$idtmsdca = 1;

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


	                	$sqlinsertnewtitulaire = "INSERT INTO `new_titulaire`(`id`, `nom_prenom_titulaire`, `genre`, `date_n`, `lieu_n`, `type`, `raison_sociale`, `societe_commerciale`, `siren`) VALUES ($maxidtitulaire,'$acquphys','$genretitulaire','$dateN','$villeN','physique',NULL,0,NULL)";
	                	//echo "<br>".$sqlinsertnewtitulaire;

	                	echo '<hr>'.$sqlinsertnewtitulaire.'<hr>';


		                //insert vehicule query
		                if($conn->query($sqlinsertnewtitulaire)){
		                    echo "<br>New Titulaire recorded";
		                }
		                else{
		                    echo "<br>Error NEW TITULAIRE: " .  $sqlinsertnewtitulaire . "<br>" . $conn->error;
		                }

	                
                        
                }
                else{


	                	$sqlinsertnewtitulaire = "INSERT INTO `new_titulaire`(`id`, `nom_prenom_titulaire`, `genre`, `date_n`, `lieu_n`, `type`, `raison_sociale`, `societe_commerciale`, `siren`) VALUES ($maxidtitulaire,NULL,NULL,NULL,NULL,'morale', '$acquphys', $societecommerciale, $siren)";
	                	//echo "<br>".$sqlinsertnewtitulaire;

	                	echo '<hr>'.$sqlinsertnewtitulaire.'<hr>';


		                //insert vehicule query
		                if($conn->query($sqlinsertnewtitulaire)){
		                    echo "<br>New Titulaire recorded";
		                }
		                else{
		                    echo "<br>Error NEW TITULAIRE: " .  $sqlinsertnewtitulaire . "<br>" . $conn->error;
		                }

	                
                     
                }
                

	//--------------------------------------carte grise---------------------------------------//

	$sqlmaxidcartegrise = "SELECT max(id) FROM cartegrise";
	$querymaxidcartegrise = $conn->query($sqlmaxidcartegrise);
	$rowmaxidcartegrise = $querymaxidcartegrise->fetch_assoc();
	$maxidcartegrise = $rowmaxidcartegrise['max(id)'] + 1;

	$sqlinsertcginfo = "INSERT INTO `cartegrise`(`id`, `typevehicule`, `cgdepartement`, `modele`, `energie`, `cv`, `datecirculation`, `co2`, `ptac`) VALUES ( $maxidcartegrise, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL )";


	//$sqlinsertcg = "INSERT INTO `cartegrise`(`id`, `typevehicule`, `cgdepartement`, `modele`, `energie`, `cv`, `datecirculation`, `co2`, `ptac`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9])";
	echo "<hr>".$sqlinsertcginfo;

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
	$sqlinsertdemande = "INSERT INTO `demande`(`id`, `client_id`, `type_demande`, `oppose_demande`, `statut_demande`, `paiement_demande`, `tms_id_demande`, `progression_demande`, `date_demande`, `prix`, `nomfic`, `acquerreur_id`) VALUES ( $maxiddemande, $idclient, 'DCA', $opposition, 'demande de changement d\'adresse effectué en attente de paiement', 'KO', $idtmsdca, 'progression test', '$datetimedemande', NULL, NULL, $maxidtitulaire)";
	echo '<hr>'.$sqlinsertdemande;

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

	 $sqlinsertvehicule = "INSERT INTO `vehicule`(`id`, `vehicule_ancientitulaire_id`, `vehicule_cartegrise_id`, `vehicule_demande_id`, `vehicule_client_id`, `client_id`, `infosup_id`, `titulaire_id`, `cgpresent`, `immatriculation`, `vin`, `numformule`, `datecg`) VALUES ( $maxidvehicule, NULL, $maxidcartegrise, $maxiddemande, $idclient, $idclient, NULL, $maxidtitulaire, 0, '$immatriculation', '$vin', '$numformule', '$datecg' )";
	 echo '<hr>'.$sqlinsertvehicule;


	//$sqlinsertvehicule = "INSERT INTO `vehicule`(`id`, `vehicule_ancientitulaire_id`, `vehicule_adresse_id`, `vehicule_cartegrise_id`, `vehicule_demande_id`, `vehicule_client_id`, `client_id`, `cgpresent`, `immatriculation`, `vin`, `numformule`, `datecg`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],$vin,[value-11],[value-12])";
	//echo "<hr>".$sqlinsertvehicule;

		

		

		if($conn->query($sqlinsertvehicule)){
	        echo "<br>vehicule info recorded";
	       ?>
<script>
	function myFunction() {
	    //location.reload();

	    var url = window.location.href;
	    var url2 = url+"/checkout/<?php echo $idtmsdca ?>";
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

	


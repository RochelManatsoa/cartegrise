<?php 
include('client.class.php');
$client = new Client();

$servername2 = "localhost";
$username2 = "root";
$password2 = "KrS7gj72";
//$password2 = "";
$database2 = "cgdatabaseoff";

// Create connection
$conn2 = new mysqli($servername2, $username2, $password2, $database2);

// Check connection
if ($conn2->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$idtms = $_POST['tmsId'];
$type = $_POST['type'];

$sqltestfic = "SELECT `nomfic` FROM `demande` WHERE `demande`.`tms_id_demande` = ".$idtms." AND `demande`.`type_demande` = '".$type."' AND `nomfic` IS NOT NULL";
//echo $sqltestfic;

$restestfic = $conn2->query($sqltestfic);

$numberoffic = mysqli_num_rows($restestfic);
//var_dump($restestfic);

if($numberoffic == 0 ){

	$nomfichier = $client->getNomFic($idtms,$type);

    $sqlupdatefic = "UPDATE `demande` SET `nomfic` = '".$nomfichier."' WHERE `demande`.`tms_id_demande` = ".$idtms." AND `demande`.`type_demande` = '".$type."'";
    if($conn2->query($sqlupdatefic)){
            //echo "<br>Fichier inseré";
    		$client->findParamsById($idtms,$type);
        }
        else{
            echo "<br>Error Fichier: " .  $sqlupdatefic . "<br>" . $conn2->error;
        }

}
else{
	//echo "<br><hr><br><h3> Nom de fichier deja inséré</h3>";
	$nomfichier = $client->getNomFic($idtms,$type);
	$client->findParamsById($idtms,$type);
	$demande = $client->getDemande($idtms, $type);
	echo '<div class="row">';
	$client->editer("Cerfa",$demande,$type);
	$client->editer("Mandat", $demande, $type);
	echo '</div>';


}




//echo 'TEST';
?>




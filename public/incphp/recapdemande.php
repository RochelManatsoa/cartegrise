<meta charset="utf-8"/>
<?php
include('client.class.php');
$client = new Client();

$servername2 = "localhost";
$username2 = "root";
$password2 = "root";
//$password2 = "";
$database2 = "cgrise";

// Create connection
$conn2 = new mysqli($servername2, $username2, $password2, $database2);

// Check connection
if ($conn2->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sqlfetchdemande = "SELECT * FROM `demande` 
                    WHERE demande.client_id = (SELECT client_id FROM fos_user WHERE id = ".$_POST['currentid']." )";
$res = $conn2->query($sqlfetchdemande);

$currentclientdemandenumrows = mysqli_num_rows($res);

if($currentclientdemandenumrows == 0 ){

    echo "<br><hr><br><h3>Aucune Demandes n'a été effectué</h3>";

}
else{
    //echo "Display demande";
    echo "<br><hr><br><h3>Récapitulatif de vos Demandes</h3>"

    ?>
    <div class="table-responsive">
    <table class="table table-bordered">
        <tr>
            <th>Type de demande</th>
            <th>Statut de vos demande</th>
            <th>Demande Payé</th>
            <th>Date à laquel vos demandes ont été effectué</th>
            <th>Paiement</th>
            <th>Fichiers</th>
        </tr>

    <?php

    while ($row = $res->fetch_assoc()) {

        //echo '<th>'.$row['id'].'</th>';
        echo '<tr><td>'.$row['type_demande'].'</td>';
        echo '<td>'.$row['statut_demande'].'</td>';
        echo '<td>'.$row['paiement_demande'].'</td>';
        echo '<td>'.$row['date_demande'].'</td>';
        echo "<td><button class=\"btn btn-outline-success\" onclick=\"redirectPay('".$row['type_demande']."', ".$row['tms_id_demande'].")\">Effectuer votre paiement</button></td>";

        $idtms = $row['tms_id_demande'];
        $type = $row['type_demande'];

            //echo "<br><hr><br><h3> Nom de fichier deja inséré</h3>";
        echo "<td>";
            $nomfichier = $client->getNomFic($idtms,$type);
            //$client->findParamsById($idtms,$type);
            $demande = $client->getDemande($idtms, $type);
            //echo '<div class="row">';
            $client->editer("Cerfa",$demande,$type);
            $client->editer("Mandat", $demande, $type);
            //echo '</div>';
            echo "</td></tr>";

        
    }
    ?>
</table>
</div>






<?php

//--------------------------------------------------fichier download-------------------------------
/*
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
*/
//----------------------------------------------end download---------------------------------
?>


<script>
    function redirectPay(typed, tmsid){
        //var hostname = window.location.hostname;
        var url = '/'+ typed.toLowerCase() + '/checkout/' + tmsid ;
        console.log(url);
        window.location.href = url;
    }
</script>

<?php


}
?>
<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "cgdatabaseoff";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 



$currentID = $_POST['currentID'];

if(isset($_POST['NomPrenom'])){
    echo $_POST['NomPrenom'];
}

if(isset($_POST['envoyer'])){
    echo "<hr><h1>Envoyé</h1>";
    echo "<hr>";
}

if(isset($_POST['sauver'])){
    echo "<hr><h1>Enregistré</h1>";
    echo "<hr>";
    try{

        //$client->sauverCTVO($_POST);
        var_dump($_POST);
    }
    catch (Exception $e){
        echo  $e->getMessage(), "\n";
    }
}

if(isset($_POST)){
    //var_dump($_POST);
    if(isset($_POST['personne'])){
        if($_POST['personne'] == "phy"){
            //Ancien Titulaire physique
            $ancienTitulaire = $_POST['NomPrenom'];

            //fetch client info id
            $sqlAcquereur = "SELECT client_id FROM fos_user WHERE id = ".$currentID;
            //echo $sqlAcquereur;

            $result = $conn->query($sqlAcquereur);
            $row = $result->fetch_array(MYSQLI_NUM);
            $idclient = $row[0];

            //fetch all
            $sqljoin = "SELECT * FROM `client` JOIN contact WHERE client.client_contact_id = contact.id AND client.id= ".$idclient;
            echo $sqljoin.'<br>';

            $result2 = $conn->query($sqljoin);
            $row2 = $result2->fetch_assoc();
            //echo $row2['client_nom'];
            var_dump($row2);


            //var_dump($result);


            
        }
        else{
            //Ancien titulaire Morale
            $ancienTitulaire = $_POST['RaisonSociale'];
        }
    }
}


$conn->close();

?>

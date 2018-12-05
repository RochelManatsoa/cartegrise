<?php

include('client.class.php');
$client = new Client();

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
    $nbcotitulaires = $_POST['NbCotitulaires'];




    //var_dump($_POST);
    if(isset($_POST['personne'])){
        if($_POST['personne'] == "phy"){
            //Ancien Titulaire physique
            $ancienTitulaire = $_POST['NomPrenom'];
            /*

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
            var_dump($row2);*/

            //


            //var_dump($result);

            try{

                //record into tms and fetch id 

                //$idtmsctvo = $client->sauverCTVO($_POST);
                //var_dump($idtmsctvo);
                $idtmsctvo = 19;

                //----get max id demande--------------
                $sqlmaxiddemande = "SELECT max(id) FROM demande";
                $querymaxiddemande = $conn->query($sqlmaxiddemande);
                $rowmaxiddemande = $querymaxiddemande->fetch_assoc();
                $maxiddemande = $rowmaxiddemande['max(id)'] + 1;

                //insertion demande------------------
                $sqlinsertdemande = "INSERT INTO demande VALUES ( $maxiddemande, $idtmsctvo, $currentID, 'CTVO', $opposition, 'demande effectue en attente de paiement', 'KO', 'progression test' )";
                echo $sqlinsertdemande;

                //----get max id ancien titulaire------
                $sqlmaxidancient = "SELECT max(id) FROM ancientitulaire";
                $querymaxidancient = $conn->query($sqlmaxidancient);
                $rowmaxidancient = $querymaxidancient->fetch_assoc();
                $maxidancient = $rowmaxidancient['max(id)'] + 1;

                //insertion ancient titulaire---------
                $sqlinsertancientitulaire = "INSERT INTO ancientitulaire VALUES ( $maxidancient, 'physique', NULL, '$ancienTitulaire' )";
                echo '<br>'.$sqlinsertancientitulaire;

                //----get max id adresse------
                $sqlmaxidadresse = "SELECT max(id) FROM adresse";
                $querymaxidadresse = $conn->query($sqlmaxidadresse);
                $rowmaxidadresse = $querymaxidadresse->fetch_assoc();
                $maxidadresse = $rowmaxidadresse['max(id)'] + 1;

                //insertion adresse
                $sqlinsertadresse = "INSERT INTO adresse VALUES ( $maxidadresse, $numeroRue, '$extension', '$precision', '$typevoie', '$nomvoie', '$complement', '$lieudit', '$codepostal', '$ville', '$boitepostale', '$pays' )";
                echo '<br>'.$sqlinsertadresse;

                //----get max id cartegrise------
                $sqlmaxidcartegrise = "SELECT max(id) FROM cartegrise";
                $querymaxidcartegrise = $conn->query($sqlmaxidcartegrise);
                $rowmaxidcartegrise = $querymaxidcartegrise->fetch_assoc();
                $maxidcartegrise = $rowmaxidcartegrise['max(id)'] + 1;

                //insertion carte grise
                $sqlinsertcginfo = "INSERT INTO cartegrise VALUES ( $maxidcartegrise, '', '', '', '', '', '', '', '' )";
                echo '<br>'.$sqlinsertcginfo;

                //insertion cotitulaires

                if($nbcotitulaires >= 1){
                    //----get max id cotitulaires------
                    $sqlmaxidcotitulaires = "SELECT max(id) FROM cotitulaires";
                    $querymaxidcotitulaires = $conn->query($sqlmaxidcotitulaires);
                    $rowmaxidcotitulaires = $querymaxidcotitulaires->fetch_assoc();
                    $maxidcotitulaires = $rowmaxidcotitulaires['max(id)'] + 1;

                    for($i=0; $i<$nbcotitulaires; $i=$i+1){
                        if($_POST['personne3'][$i] == "PersonnePhysique"){
                            //echo $_POST['prenomct'][$i];
                            $prenomct = $_POST['prenomct'][$i];
                            $nomct = $_POST['nomct'][$i];
                            $sexe3 = $_POST['sexe3'][$i];
                            $sqlinsertcotitulaires = "INSERT INTO cotitulaires VALUES($maxidcotitulaires, $maxidcartegrise, 'PersonnePhysique', '$nomct', '$prenomct', '', '$sexe3' )";
                            echo '<br>'.$sqlinsertcotitulaires;
                            $maxidcotitulaires = $maxidcotitulaires +1;
                        }
                        else{
                            //echo $_POST['raisonct'][$i];
                            $raisonct = $_POST['raisonct'][$i];
                            $sqlinsertcotitulaires = "INSERT INOT cotitulaires VALUES($maxidcotitulaires, $maxidcartegrise, 'PersonneMorale', '', '', '$raisonct', '')";
                            echo '<br>'.$sqlinsertcotitulaires;
                            $maxidcotitulaires = $maxidcotitulaires +1;

                        }
                        
                    }
                }
                

                //insertion vehicule
                //$sqlinsertvehicule = "INSERT INTO vehicule VALUES ( $currentID, $currentID, )";
            }
            catch (Exception $e){
                echo  $e->getMessage(), "\n";
            }


            
        }
        else{
            //Ancien titulaire Morale
            $ancienTitulaire = $_POST['RaisonSociale'];
        }
    }
}


$conn->close();

?>

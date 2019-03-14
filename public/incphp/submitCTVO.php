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
        //var_dump($_POST);
    }
    catch (Exception $e){
        echo  $e->getMessage(), "\n";
    }
}

if(isset($_POST)){

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
    $nbcotitulaires = $_POST['NbCotitulaires'];
    $cgpresent = $_POST['CIPresent'];
    $immatric = $_POST['Immatriculation'];
    $vin = $_POST['VIN'];
    if(isset($_POST['NumFormule'])){
        $numformule = $_POST['NumFormule'];
    }
    else{
        $numformule = NULL;
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

    
            

    //fetch client info id
    $sqlAcquereur = "SELECT client_id FROM fos_user WHERE id = ".$currentID;


    $result = $conn->query($sqlAcquereur);
    $row = $result->fetch_array(MYSQLI_NUM);
    $idclient = $row[0];
    




    //var_dump($_POST);
    if(isset($_POST['personne'])){
        


        try{



                //record into tms and fetch id 

                $idtmsctvo = $client->sauverCTVO($_POST);
                $client->ouvrir($idtmsctvo,"CTVO");
                //var_dump($idtmsctvo);
                //$idtmsctvo = 19;

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
                


                //insertion new titulaire--------------

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




                //----get max id adresse------
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


                //----get max id demande--------------
                $sqlmaxiddemande = "SELECT max(id) FROM demande";
                $querymaxiddemande = $conn->query($sqlmaxiddemande);
                $rowmaxiddemande = $querymaxiddemande->fetch_assoc();
                $maxiddemande = $rowmaxiddemande['max(id)'] + 1;

                //--------get date demande--------
                $datetimedemande = date('Y-m-d H:i:s', time());

                //insertion demande------------------
                //$sqlinsertdemande = "INSERT INTO demande VALUES ( $maxiddemande, $idtmsctvo, $idclient, 'CTVO', $opposition, 'demande effectue en attente de paiement', 'KO', 'progression test', '$datetimedemande', NULL, NULL)";
                    $sqlinsertdemande = "INSERT INTO `demande`(`id`, `client_id`, `type_demande`, `oppose_demande`, `statut_demande`, `paiement_demande`, `tms_id_demande`, `progression_demande`, `date_demande`, `prix`, `nomfic`, `acquerreur_id`) VALUES ( $maxiddemande, $idclient, 'CTVO', $opposition, 'demande effectue en attente de paiement', 'KO', $idtmsctvo, 'progression test', '$datetimedemande', NULL, NULL, $maxidtitulaire )";
                //echo $sqlinsertdemande;

                //insert demande query
                if($conn->query($sqlinsertdemande)){
                    echo "<br>demande recorded";
                }
                else{
                    echo "<br>Error DEMANDE: " . $sqlinsertdemande . "<br>" . $conn->error;
                }




                //----get max id cartegrise------
                $sqlmaxidcartegrise = "SELECT max(id) FROM cartegrise";
                $querymaxidcartegrise = $conn->query($sqlmaxidcartegrise);
                $rowmaxidcartegrise = $querymaxidcartegrise->fetch_assoc();
                $maxidcartegrise = $rowmaxidcartegrise['max(id)'] + 1;

                //insertion carte grise
                $sqlinsertcginfo = "INSERT INTO cartegrise VALUES ( $maxidcartegrise, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL )";
                //echo '<br>'.$sqlinsertcginfo;


                //insert cartegrise info query
                if($conn->query($sqlinsertcginfo)){
                    echo "<br>cartegrise info recorded";
                }
                else{
                    echo "<br>Error CARTE GRISE: " . $sqlinsertcginfo . "<br>" . $conn->error;
                }


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
                            //echo '<br>'.$sqlinsertcotitulaires;
                            $maxidcotitulaires = $maxidcotitulaires +1;
                        }
                        else{
                            //echo $_POST['raisonct'][$i];
                            $raisonct = $_POST['raisonct'][$i];
                            $sqlinsertcotitulaires = "INSERT INTO cotitulaires VALUES($maxidcotitulaires, $maxidcartegrise, 'PersonneMorale', '', '', '$raisonct', '')";
                            //echo '<br>'.$sqlinsertcotitulaires;
                            $maxidcotitulaires = $maxidcotitulaires +1;

                        }
                        
                    }
                }
                else{
                    echo "Error: veuillez saisir correctements les champs <br>";
                }
                

                //insertion vehicule
                //$sqlinsertvehicule = "INSERT INTO vehicule VALUES ( $currentID, $currentID, )";
            }
            catch (Exception $e){
                echo  $e->getMessage(), "\n";
            }


        //----get max id vehicule------
        $sqlmaxidvehicule = "SELECT max(id) FROM vehicule";
        $querymaxidvehicule = $conn->query($sqlmaxidvehicule);
        $rowmaxidvehicule = $querymaxidvehicule->fetch_assoc();
        $maxidvehicule = $rowmaxidvehicule['max(id)'] + 1;

        //insertion vehicule
                //$sqlinsertvehicule = "INSERT INTO vehicule VALUES ( $maxidvehicule, $maxidancient, $maxidadresse, $maxidcartegrise, $maxiddemande, $idclient, $idclient, $cgpresent, '$immatric', '$vin', '$numformule', $datecg )";

        
                //echo $sqlinsertvehicule;
        if($datecg == NULL){
            $sqlinsertvehicule = "INSERT INTO `vehicule`(`id`, `vehicule_ancientitulaire_id`, `vehicule_cartegrise_id`, `vehicule_demande_id`, `vehicule_client_id`, `client_id`, `infosup_id`, `titulaire_id`, `cgpresent`, `immatriculation`, `vin`, `numformule`, `datecg`) VALUES ($maxidvehicule,$maxidancient,$maxidcartegrise,$maxiddemande,$idclient,$idclient,NULL, $maxidtitulaire,$cgpresent,'$immatric','$vin','$numformule',$datecg)";
        }
        else{
            $sqlinsertvehicule = "INSERT INTO `vehicule`(`id`, `vehicule_ancientitulaire_id`, `vehicule_cartegrise_id`, `vehicule_demande_id`, `vehicule_client_id`, `client_id`, `infosup_id`, `titulaire_id`, `cgpresent`, `immatriculation`, `vin`, `numformule`, `datecg`) VALUES ($maxidvehicule,$maxidancient,$maxidcartegrise,$maxiddemande,$idclient,$idclient,NULL, $maxidtitulaire,$cgpresent,'$immatric','$vin','$numformule','$datecg')";
        }


    }
    else{
        echo "Error: veuillez saisir correctements les champs <br>";
    }

        

    

        //------------------------------------------------------------------------------------
        


        


        //insert vehicule query
        if($conn->query($sqlinsertvehicule)){
            echo "<br>vehicule info recorded";
             ?>
            <script>
            function myFunction() {
                //location.reload();

                var url = window.location.href;
                var url2 = url+"/checkout/<?php echo $idtmsctvo ?>";
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

        //demande
        //$conn->query($sqlinsertancienttitulaire);
        //$conn->query($sqlinsertadresse);
        //$conn->query($sqlinsertcotitulaire);
        //vehicule
        echo "<br>insertion réussi";
        $_POST['success']= "Vous avez bien effectué votre demande";
        //header("Refresh:0;");
       

    

}
else{
    var_dump("Error: veuillez saisir correctements les champs <br>");
}


$conn->close();

?>

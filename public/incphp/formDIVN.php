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

// Ajout Rochel

  /*  $sqlfetchcommande = "SELECT * FROM `taxes` WHERE `commande_id` = ".$_GET['commande'}."";
    $result = $conn2->query($sqlfetchcommande);
    $commandeResult = mysqli_query($result);
    var_dump($_GET['commande']);*/
// Fin ajout Rochel

$sqlfetchdemande = "SELECT * FROM `demande` WHERE `client_id` = (SELECT client_id FROM fos_user WHERE id = ".$_POST['currentid']." ) AND `type_demande` = 'DIVN'";
$res = $conn2->query($sqlfetchdemande);

$currentclientdemandenumrows = mysqli_num_rows($res);

if($currentclientdemandenumrows == 0 ){

echo "<br><hr><br><h3>Vous n'avez effectué aucune demande</h2>";
}
else{
    //echo "Display demande";

    echo "<br><hr><h3>Vous avez déja effectué ".$currentclientdemandenumrows." demandes DIVN</h3>";


}



?>


<hr>
<div class="container">
<form method="POST" id="formdivn">   
    <input name="currentID" value="<?php echo $_POST['currentid'] ?>" type="hidden">
    <!--<fieldset>
        <legend class="control-label">Date Démarche</legend>
        <div class="form-group">
            <input class="form-control" name="DateDemarche" type="date">
            <input class="form-control" name="TimeDemarche" type="time">
        </div>
    </fieldset>-->
    <!------------------------------------------------------------------------------BEGIN CLIENT TITULAIRE-------------------------->
    <!-----------------------------Titulaire new-------------------->
    <fieldset >
        <legend class="control-label">Nouveau Titulaire</legend>
        <div class="form-group">
            <select id="personne2" name="personne2"  class="form-control" onchange="acquereur()">
                <option value="phy">Personne Physique</option>
                <option value="mor">Personne Morale</option>
            </select><br>

            <div id="acquereur">
                <label for="Nom">Nom</label>
                <input class="form-control" name="Nom" onkeyup="this.value = this.value.toUpperCase();" required><br>

                <label for="Prenom">Prenom</label>
                <input class="form-control" name="Prenom"  required><br>

                <label for="sexe">Sexe</label>
                <select id="sexe" name="sexe"  class="form-control" onchange="genre()">
                    <option value="F" >Feminin</option>
                    <option value="M" >Masculin</option>
                </select>
                <div id="genre">
                    <label for="NomUsage">NOM Usage</label>
                    <input class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="NomUsage">
                </div>
                    <!--<option value="F" >Feminin</option>
                    <option value="M" >Masculin</option>--
                </select>
                <div id="genre">
                    <label for="NomUsage">NOM Usage</label>
                    <input class="form-control" name="NomUsage" required>
                </div>-->
                
            </div>

            <div id="naissance">
                <label for="DateNaissance">Née le:</label>
                <input class="form-control" name="DateNaissance" id="DateNaissance" type="date" required>

                <label for="LieuNaissance">Ville de Naissance</label>
                <input class="form-control" name="LieuNaissance" onkeyup="this.value = this.value.toUpperCase();" id="LieuNaissance"  required>
                
            </div>

            

               
        </div>
    </fieldset>
    <!-------------------------------Droit Opposition--------------->
    <fieldset>
        <label class="control-label">Opposé à la réutilisation des données à des fins d’enquête et de prospection commerciale</label>
        <select class="form-control" name="DroitOpposition">
            <option value=1>oui</option>
            <option value=0>non</option>
        </select>
    </fieldset>
    <!-------------------------------Adresse------------------------>

    <fieldset>
        <legend class="control-label">Adresse</legend>
        <div class="form-group">
            <label for="Numero">Numero de Rue</label>
             <input class="form-control" name="Numero" id="Numero" type="number" required><br>

             <label for="ExtensionIndice">Extension au numéro de rue (B, T, …)</label>
             <input class="form-control" name="ExtensionIndice" id="ExtensionIndice" placeholder="B" ><br>

             <label for="EtageEscAppt">Précision sur l’étage, l’appartement, l’escalier, le bâtiment, …</label>
             <input class="form-control" name="EtageEscAppt" id="EtageEscAppt" placeholder="Apt"><br>

             <label for="TypeVoie">Type de la voie</label>
             <select id="TypeVoie" name="TypeVoie"  class="form-control">
                    <option value="SANS">- - - - -</option>
                    <option value="RUE">Rue</option>
                    <option value="BLVD">Boulevard</option>
                    <option value="AVN">Avenue</option>
                    <option value="ALL">Allée</option>
                    <option value="PLC">Place</option>
                    <option value="IMP" selected="selected">Impasse</option>
                    <option value="CHM">Chemin</option>
                    <option value="QUAI">Quai</option>
                    <option value="FORT">Fort</option>
                    <option value="RTE">Route</option>
                    <option value="PASS">Passage</option>
                    <option value="CHAU">Chaussée</option>
                    <option value="COUR">Cour</option>
                    <option value="PARC">Parc</option>
                    <option value="FBG">Faubourg</option>
                    <option value="LDIT">Lieu-Dit</option>
                    <option value="SQUA">Square</option>
                    <option value="SENT">Sente</option>
                    <option value="SANS">Inconnu</option>
                </select><br>

             <label for="NomVoie">Nom de la voie</label>
             <input class="form-control" name="NomVoie" id="NomVoie" required><br>

             <label for="Complement">Complement</label>
             <input class="form-control" name="Complement" id="Complement" placeholder="Immeuble, Bâtiment, Résidence"><br>

             <label for="LieuDit">LieuDit</label>
             <input class="form-control" name="LieuDit" id="LieuDit"><br>

             <label for="CodePostal">Code Postal</label>
             <input class="form-control" name="CodePostal" id="CodePostal" required><br>

             <label for="Ville">Ville</label>
             <input class="form-control" name="Ville" id="Ville" required><br>

             <label for="BoitePostale">Boite Postale</label>
             <input class="form-control" name="BoitePostale" id="BoitePostale"><br>

             <label for="Pays">Pays</label>
             
             <select name="Pays" id="Pays" class="form-control"> 
                    <option value="France" selected="selected">France </option>

                    <option value="Afghanistan">Afghanistan </option>
                    <option value="Afrique_Centrale">Afrique_Centrale </option>
                    <option value="Afrique_du_sud">Afrique_du_Sud </option> 
                    <option value="Albanie">Albanie </option>
                    <option value="Algerie">Algerie </option>
                    <option value="Allemagne">Allemagne </option>
                    <option value="Andorre">Andorre </option>
                    <option value="Angola">Angola </option>
                    <option value="Anguilla">Anguilla </option>
                    <option value="Arabie_Saoudite">Arabie_Saoudite </option>
                    <option value="Argentine">Argentine </option>
                    <option value="Armenie">Armenie </option> 
                    <option value="Australie">Australie </option>
                    <option value="Autriche">Autriche </option>
                    <option value="Azerbaidjan">Azerbaidjan </option>

                    <option value="Bahamas">Bahamas </option>
                    <option value="Bangladesh">Bangladesh </option>
                    <option value="Barbade">Barbade </option>
                    <option value="Bahrein">Bahrein </option>
                    <option value="Belgique">Belgique </option>
                    <option value="Belize">Belize </option>
                    <option value="Benin">Benin </option>
                    <option value="Bermudes">Bermudes </option>
                    <option value="Bielorussie">Bielorussie </option>
                    <option value="Bolivie">Bolivie </option>
                    <option value="Botswana">Botswana </option>
                    <option value="Bhoutan">Bhoutan </option>
                    <option value="Boznie_Herzegovine">Boznie_Herzegovine </option>
                    <option value="Bresil">Bresil </option>
                    <option value="Brunei">Brunei </option>
                    <option value="Bulgarie">Bulgarie </option>
                    <option value="Burkina_Faso">Burkina_Faso </option>
                    <option value="Burundi">Burundi </option>

                    <option value="Caiman">Caiman </option>
                    <option value="Cambodge">Cambodge </option>
                    <option value="Cameroun">Cameroun </option>
                    <option value="Canada">Canada </option>
                    <option value="Canaries">Canaries </option>
                    <option value="Cap_vert">Cap_Vert </option>
                    <option value="Chili">Chili </option>
                    <option value="Chine">Chine </option> 
                    <option value="Chypre">Chypre </option> 
                    <option value="Colombie">Colombie </option>
                    <option value="Comores">Colombie </option>
                    <option value="Congo">Congo </option>
                    <option value="Congo_democratique">Congo_democratique </option>
                    <option value="Cook">Cook </option>
                    <option value="Coree_du_Nord">Coree_du_Nord </option>
                    <option value="Coree_du_Sud">Coree_du_Sud </option>
                    <option value="Costa_Rica">Costa_Rica </option>
                    <option value="Cote_d_Ivoire">Côte_d_Ivoire </option>
                    <option value="Croatie">Croatie </option>
                    <option value="Cuba">Cuba </option>

                    <option value="Danemark">Danemark </option>
                    <option value="Djibouti">Djibouti </option>
                    <option value="Dominique">Dominique </option>

                    <option value="Egypte">Egypte </option> 
                    <option value="Emirats_Arabes_Unis">Emirats_Arabes_Unis </option>
                    <option value="Equateur">Equateur </option>
                    <option value="Erythree">Erythree </option>
                    <option value="Espagne">Espagne </option>
                    <option value="Estonie">Estonie </option>
                    <option value="Etats_Unis">Etats_Unis </option>
                    <option value="Ethiopie">Ethiopie </option>

                    <option value="Falkland">Falkland </option>
                    <option value="Feroe">Feroe </option>
                    <option value="Fidji">Fidji </option>
                    <option value="Finlande">Finlande </option>
                    <option value="France">France </option>

                    <option value="Gabon">Gabon </option>
                    <option value="Gambie">Gambie </option>
                    <option value="Georgie">Georgie </option>
                    <option value="Ghana">Ghana </option>
                    <option value="Gibraltar">Gibraltar </option>
                    <option value="Grece">Grece </option>
                    <option value="Grenade">Grenade </option>
                    <option value="Groenland">Groenland </option>
                    <option value="Guadeloupe">Guadeloupe </option>
                    <option value="Guam">Guam </option>
                    <option value="Guatemala">Guatemala</option>
                    <option value="Guernesey">Guernesey </option>
                    <option value="Guinee">Guinee </option>
                    <option value="Guinee_Bissau">Guinee_Bissau </option>
                    <option value="Guinee equatoriale">Guinee_Equatoriale </option>
                    <option value="Guyana">Guyana </option>
                    <option value="Guyane_Francaise ">Guyane_Francaise </option>

                    <option value="Haiti">Haiti </option>
                    <option value="Hawaii">Hawaii </option> 
                    <option value="Honduras">Honduras </option>
                    <option value="Hong_Kong">Hong_Kong </option>
                    <option value="Hongrie">Hongrie </option>

                    <option value="Inde">Inde </option>
                    <option value="Indonesie">Indonesie </option>
                    <option value="Iran">Iran </option>
                    <option value="Iraq">Iraq </option>
                    <option value="Irlande">Irlande </option>
                    <option value="Islande">Islande </option>
                    <option value="Israel">Israel </option>
                    <option value="Italie">italie </option>

                    <option value="Jamaique">Jamaique </option>
                    <option value="Jan Mayen">Jan Mayen </option>
                    <option value="Japon">Japon </option>
                    <option value="Jersey">Jersey </option>
                    <option value="Jordanie">Jordanie </option>

                    <option value="Kazakhstan">Kazakhstan </option>
                    <option value="Kenya">Kenya </option>
                    <option value="Kirghizstan">Kirghizistan </option>
                    <option value="Kiribati">Kiribati </option>
                    <option value="Koweit">Koweit </option>

                    <option value="Laos">Laos </option>
                    <option value="Lesotho">Lesotho </option>
                    <option value="Lettonie">Lettonie </option>
                    <option value="Liban">Liban </option>
                    <option value="Liberia">Liberia </option>
                    <option value="Liechtenstein">Liechtenstein </option>
                    <option value="Lituanie">Lituanie </option> 
                    <option value="Luxembourg">Luxembourg </option>
                    <option value="Lybie">Lybie </option>

                    <option value="Macao">Macao </option>
                    <option value="Macedoine">Macedoine </option>
                    <option value="Madagascar">Madagascar </option>
                    <option value="Madère">Madère </option>
                    <option value="Malaisie">Malaisie </option>
                    <option value="Malawi">Malawi </option>
                    <option value="Maldives">Maldives </option>
                    <option value="Mali">Mali </option>
                    <option value="Malte">Malte </option>
                    <option value="Man">Man </option>
                    <option value="Mariannes du Nord">Mariannes du Nord </option>
                    <option value="Maroc">Maroc </option>
                    <option value="Marshall">Marshall </option>
                    <option value="Martinique">Martinique </option>
                    <option value="Maurice">Maurice </option>
                    <option value="Mauritanie">Mauritanie </option>
                    <option value="Mayotte">Mayotte </option>
                    <option value="Mexique">Mexique </option>
                    <option value="Micronesie">Micronesie </option>
                    <option value="Midway">Midway </option>
                    <option value="Moldavie">Moldavie </option>
                    <option value="Monaco">Monaco </option>
                    <option value="Mongolie">Mongolie </option>
                    <option value="Montserrat">Montserrat </option>
                    <option value="Mozambique">Mozambique </option>

                    <option value="Namibie">Namibie </option>
                    <option value="Nauru">Nauru </option>
                    <option value="Nepal">Nepal </option>
                    <option value="Nicaragua">Nicaragua </option>
                    <option value="Niger">Niger </option>
                    <option value="Nigeria">Nigeria </option>
                    <option value="Niue">Niue </option>
                    <option value="Norfolk">Norfolk </option>
                    <option value="Norvege">Norvege </option>
                    <option value="Nouvelle_Caledonie">Nouvelle_Caledonie </option>
                    <option value="Nouvelle_Zelande">Nouvelle_Zelande </option>

                    <option value="Oman">Oman </option>
                    <option value="Ouganda">Ouganda </option>
                    <option value="Ouzbekistan">Ouzbekistan </option>

                    <option value="Pakistan">Pakistan </option>
                    <option value="Palau">Palau </option>
                    <option value="Palestine">Palestine </option>
                    <option value="Panama">Panama </option>
                    <option value="Papouasie_Nouvelle_Guinee">Papouasie_Nouvelle_Guinee </option>
                    <option value="Paraguay">Paraguay </option>
                    <option value="Pays_Bas">Pays_Bas </option>
                    <option value="Perou">Perou </option>
                    <option value="Philippines">Philippines </option> 
                    <option value="Pologne">Pologne </option>
                    <option value="Polynesie">Polynesie </option>
                    <option value="Porto_Rico">Porto_Rico </option>
                    <option value="Portugal">Portugal </option>

                    <option value="Qatar">Qatar </option>

                    <option value="Republique_Dominicaine">Republique_Dominicaine </option>
                    <option value="Republique_Tcheque">Republique_Tcheque </option>
                    <option value="Reunion">Reunion </option>
                    <option value="Roumanie">Roumanie </option>
                    <option value="Royaume_Uni">Royaume_Uni </option>
                    <option value="Russie">Russie </option>
                    <option value="Rwanda">Rwanda </option>

                    <option value="Sahara Occidental">Sahara Occidental </option>
                    <option value="Sainte_Lucie">Sainte_Lucie </option>
                    <option value="Saint_Marin">Saint_Marin </option>
                    <option value="Salomon">Salomon </option>
                    <option value="Salvador">Salvador </option>
                    <option value="Samoa_Occidentales">Samoa_Occidentales</option>
                    <option value="Samoa_Americaine">Samoa_Americaine </option>
                    <option value="Sao_Tome_et_Principe">Sao_Tome_et_Principe </option> 
                    <option value="Senegal">Senegal </option> 
                    <option value="Seychelles">Seychelles </option>
                    <option value="Sierra Leone">Sierra Leone </option>
                    <option value="Singapour">Singapour </option>
                    <option value="Slovaquie">Slovaquie </option>
                    <option value="Slovenie">Slovenie</option>
                    <option value="Somalie">Somalie </option>
                    <option value="Soudan">Soudan </option> 
                    <option value="Sri_Lanka">Sri_Lanka </option> 
                    <option value="Suede">Suede </option>
                    <option value="Suisse">Suisse </option>
                    <option value="Surinam">Surinam </option>
                    <option value="Swaziland">Swaziland </option>
                    <option value="Syrie">Syrie </option>

                    <option value="Tadjikistan">Tadjikistan </option>
                    <option value="Taiwan">Taiwan </option>
                    <option value="Tonga">Tonga </option>
                    <option value="Tanzanie">Tanzanie </option>
                    <option value="Tchad">Tchad </option>
                    <option value="Thailande">Thailande </option>
                    <option value="Tibet">Tibet </option>
                    <option value="Timor_Oriental">Timor_Oriental </option>
                    <option value="Togo">Togo </option> 
                    <option value="Trinite_et_Tobago">Trinite_et_Tobago </option>
                    <option value="Tristan da cunha">Tristan de cuncha </option>
                    <option value="Tunisie">Tunisie </option>
                    <option value="Turkmenistan">Turmenistan </option> 
                    <option value="Turquie">Turquie </option>

                    <option value="Ukraine">Ukraine </option>
                    <option value="Uruguay">Uruguay </option>

                    <option value="Vanuatu">Vanuatu </option>
                    <option value="Vatican">Vatican </option>
                    <option value="Venezuela">Venezuela </option>
                    <option value="Vierges_Americaines">Vierges_Americaines </option>
                    <option value="Vierges_Britanniques">Vierges_Britanniques </option>
                    <option value="Vietnam">Vietnam </option>

                    <option value="Wake">Wake </option>
                    <option value="Wallis et Futuma">Wallis et Futuma </option>

                    <option value="Yemen">Yemen </option>
                    <option value="Yougoslavie">Yougoslavie </option>

                    <option value="Zambie">Zambie </option>
                    <option value="Zimbabwe">Zimbabwe </option>
                </select><br>
        </div>
    </fieldset>



    <!------------------------------------------------------------------------------END CLIENT TITULAIRE-------------------------->


    <!------------------------------Cotitulaire--------------------->
    <fieldset>
        <legend name="Co-titulaire">Co-Titulaire</legend>
        <div class="form-group">
            <label for="NbCotitulaires">Nombre de Cotitulaires</label>
            <input type="number" class="form-control" name="NbCotitulaires" id="NbCotitulaires"><br>
            <a class="btn btn-secondary" id="addcotitulaire" onclick="return addCotitulaire()">Add Cotitulaires</a>

            <div id="cotitulaireList"></div>
        </div>
    </fieldset>

    <!-----------------------------Info Vehicule-------------------->
    <fieldset>
        <legend name="InfoVehicule">Information Véhicule</legend>
        <div class="form-group">
            
            
            <div id="immatinfo">


                <label for="VIN">VIN</label>
                <input class="form-control" onkeyup="this.value = this.value.toUpperCase();" value="$commandeResult['vin']" name="VIN" id="VIN" required><br>

                <label for="D1_Marque">Marque du véhicule</label>
                <input class="form-control" value="" name="D1_Marque" id="D1_Marque" required><br>

                <label for="D2_Version">Type - Variant - Version</label>
                <input class="form-control" value="" name="D2_Version" id="D2_Version" required><br>

                <label for="K_NumRecpCE">Numéro de réception par type</label>
                <input class="form-control" value="" name="K_NumRecpCE" id="K_NumRecpCE"><br>

                <label for="F1_MMaxTechAdm">Masse en charge maximale techniquement admissible</label>
                <input class="form-control" type="number" value=0 name="F1_MMaxTechAdm" id="F1_MMaxTechAdm"><br>

                <label for="G_MMaxAvecAttelage">Masse du véhicule en service avec carrosserie et dispositif d'attelage</label>
                <input class="form-control" type="number" value=0  name="G_MMaxAvecAttelage" id="G_MMaxAvecAttelage"><br>

                <label for="G1_PoidsVide">Poids à vide national</label>
                <input class="form-control" type="number" value=0 name="G1_PoidsVide" id="G1_PoidsVide"><br>

                <label for="J_CategorieCE">Catégorie du véhicule</label>
                <input class="form-control" value="" name="J_CategorieCE" id="J_CategorieCE"><br>

                <label for="J1_Genre">Genre national</label>
                <input class="form-control" value="$commandeResult['genre']" name="J1_Genre" id="J1_Genre"><br>

                <label for="J3_Carrosserie">Carrosserie</label>
                <input class="form-control" value="" name="J3_Carrosserie" id="J3_Carrosserie"><br>

                <label for="P6_PuissFiscale">Puissance administrative nationale</label>
                <input class="form-control" type="number" value=0 name="P6_PuissFiscale" id="P6_PuissFiscale"><br>



            </div>

        </div>     
    </fieldset>

    <!-------------------------------------Caractéristique technique particuliere--------------------------->
    <fieldset>
        <legend name="CarTechPart">Caracteristique technique particuliere</legend>
        <div class="form-group">
            <!--<div>
                <label for="Code">Caracteristique</label>
                <select class="form-control" id="Code" name="Code1">
                    <option value="TEEX">TE Exclusif</option>
                    <option value="TEPO">TE Possible</option>
                    <option value="EPEC">Essieux posés en charge</option>
                    <option value="PLMO">Places modulables</option>
                    <option value="VECO">Véhicule école</option>
                    <option value="PLME">Places médicales</option>
                    <option value="THAN">Transport handicapé</option>
                    <option value="GAZO">Gazogène</option>
                    <option value="GAZC">Gaz compr.</option>
                    <option value="RALE">Ralentisseur</option>
                    <option value="AG1P">Autre G1 possible</option>
                    <option value="AF3P">Autre F3 possible</option>
                    <option value="AJ1P">Autre J1 possible</option>
                    <option value="PLCO">PL convoi 6 km/h maxi</option>
                    <option value="EQAC">Equip. accumulat.</option>
                    <option value="AJ3P">Autre J3 possible</option>
                    <option value="VMAX">V max (remorque)</option>
                </select><br>

                <label for="Valeur1">Valeur1 de mention</label>
                <input class="form-control" name="Valeur1" id="Valeur1"><br>

                <label for="Valeur2">Valeur2 de mention</label>
                <input class="form-control" name="Valeur2" id="Valeur2"><br>
            </div>-->

                 <a class="btn btn-secondary" id="addcaract" onclick="return addCaract()">Ajouter caractéristique</a>
                 <a class="btn btn-secondary" id="delcaract" onclick="return delCaract()">Enlever caractéristique</a>


        </div>
        <div id="CaracteristiqueList"></div>
    </fieldset>
    


    <fieldset>
        <input type="submit" class="btn btn-primary" name="envoyer" value="envoyer">
    </fieldset>
</form>


<?php

/*
if(isset($_POST['envoyer'])){
    echo "<hr><h1>Envoyé</h1>";
    echo "<hr>";
}

if(isset($_POST['sauver'])){
    echo "<hr><h1>Enregistré</h1>";
    echo "<hr>";
    try{

        $client->sauverCTVO($_POST);
        //var_dump($_POST);
    }
    catch (Exception $e){
        echo  $e->getMessage(), "\n";
    }
}*/



?>

</div>

<div id="resultform"></div>

<script>
    $('#formdivn').on('submit',function(e) {

        e.preventDefault();
        dataseri = $(this).serialize();
        console.log(dataseri);
        $.ajax({
            url: 'incphp/submitDIVN.php',
            type: 'POST',
            data: dataseri,
            success: function(data) {
                console.log(data);
                console.log("test submit form");
                $('#resultform').html(data);
            }               
        });
    });

   


</script>




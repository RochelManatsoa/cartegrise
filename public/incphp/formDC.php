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

$sqlfetchdemande = "SELECT * FROM `demande` WHERE `client_id` = (SELECT client_id FROM fos_user WHERE id = ".$_POST['currentid']." ) AND `type_demande` = 'DC'";
$res = $conn2->query($sqlfetchdemande);

$currentclientdemandenumrows = mysqli_num_rows($res);

if($currentclientdemandenumrows == 0 ){

echo "<br><hr><br><h3>Vous n'avez effectué aucune demande de Cession</h2>";
}
else{
    //echo "Display demande";

    echo "<br><hr><h3>Vous avez déja effectué ".$currentclientdemandenumrows." demandes DC</h3>";


}


?>


<hr>
<div class="container">
    <form method="POST" id="formda">
        <input name="currentID" value="<?php echo $_POST['currentid'] ?>" type="hidden">
        <div class="form-group">
            <fieldset>
                <legend class="control-label">Date De Cession</legend>
                <div class="form-group">
                    <input  class="form-control" name="DateAchat" type="date">
                    
                </div>
            </fieldset>
        </div>

        <fieldset>
            <legend class="control-label">Titulaire</legend>
            <div class="form-group">
                <select id="personne" name="personne"  class="form-control" onchange="titulaire()">
                    <option value="phy" >Personne Physique</option>
                    <option value="mor">Société</option>
                </select><br>

                <div id="titulaire"><label for="NomPrenom">Nom Prénom</label>
                    <input class="form-control" name="NomPrenom" id="NomPrenom"><br>
                </div>

            </div>
        </fieldset>
        <fieldset>
            <legend class="control-label">Acquereur</legend>
            <div class="form-group">
                <select id="personne2" name="personne2"  class="form-control" onchange="acquereur()">
                    <option value="phy">Personne Physique</option>
                    <option value="mor">Société</option>
                </select><br>

                <div id="acquereur">
                    <label for="Nom">Nom</label>
                    <input class="form-control" name="Nom"><br>

                    <label for="Prenom">Prenom</label>
                    <input class="form-control" name="Prenom"><br>

                    <label for="sexe">Sexe</label>
                    <select id="sexe" name="sexe"  class="form-control" onchange="genre()">
                        <option value="F">Feminin</option>
                        <option value="M">Masculin</option>
                    </select>
                    <div id="genre">
                        <label for="NomUsage">NOM Usage</label>
                        <input class="form-control" name="NomUsage">
                    </div>

                    
                    
                </div>
                <div id="naissance">
                        <label for="DateNaissance">Née le:</label>
                        <input class="form-control" name="DateNaissance" id="DateNaissance" type="date" required>

                        <label for="LieuNaissance">Ville de Naissance</label>
                        <input class="form-control" name="LieuNaissance" onkeyup="this.value = this.value.toUpperCase();" id="LieuNaissance"  required>
                        
                    </div>

                

                   
            </div>
        </fieldset>

        <fieldset>
            <label class="control-label">Opposé à la réutilisation des données à des fins d’enquête et de prospection commerciale</label>
            <select class="form-control" name="DroitOpposition">
                <option value=1>oui</option>
                <option value=0>non</option>
            </select>
        </fieldset>
        <fieldset>
            <legend class="control-label">Adresse</legend>
            <div class="form-group">
                <label for="Numero">Numero de Rue</label>
                 <input class="form-control" name="Numero" id="Numero" type="number"><br>

                 <label for="ExtensionIndice">Extension au numéro de rue (B, T, …)</label>
                 <input class="form-control" name="ExtensionIndice" id="ExtensionIndice" placeholder="B"><br>

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
                 <input class="form-control" name="NomVoie" id="NomVoie"><br>

                 <label for="Complement">Complement</label>
                 <input class="form-control" name="Complement" id="Complement" placeholder="Immeuble, Bâtiment, Résidence"><br>

                 <label for="LieuDit">LieuDit</label>
                 <input class="form-control" name="LieuDit" id="LieuDit"><br>

                 <label for="CodePostal">Code Postal</label>
                 <input class="form-control" name="CodePostal" id="CodePostal"><br>

                 <label for="Ville">Ville</label>
                 <input class="form-control" name="Ville" id="Ville"><br>

                 <label for="BoitePostale">Boite Postale</label>
                 <input class="form-control" name="BoitePostale" id="BoitePostale"><br>

                 <label for="Pays">Pays</label>
                 <input class="form-control" name="Pays" id="Pays"><br>
            </div>
        </fieldset>
        <fieldset>
            <legend name="InfoVehicule">Information Véhicule</legend>
            <div class="form-group">
                
                <!--<input type="checkbox" name="CIPresent" id="CIPresent">-->
                <label for="CIPresent" >Carte Grise Remise</label>
                <select id="cip" name="CIPresent" class="form-control" onchange="cipresent()">
                    <option value=1>oui</option>
                    <option value=0>non</option>
                </select>
                <br>
                <div id="immatinfo">
                    <label for="Immatriculation">Numero d'Immatriculation</label>

                    <input class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="AB-123-CD ou 1234 AB 56 " pattern="[0-9]{1,4} [A-Z]{1,4} [0-9]{1,2}|[A-Z]{1,2}-[0-9]{1,3}-[A-Z]{1,2}" name="Immatriculation" id="Immatriculation"><br>

                    <label for="VIN">VIN</label>
                    <input class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="VIN" id="VIN"><br>

                    <label for="NumFormule">Numero de Formule</label>
                    <input class="form-control" name="NumFormule" id="NumFormule"><br>

                    <label for="DateCI">Date CG</label>
                    <input type="date" class="form-control" name="DateCI" id="DateCI"><br>
                </div>

            </div>
            
        </fieldset>
        <fieldset>
            <input type="submit" class="btn btn-primary" name="envoyer" value="envoyer">
        </fieldset>
    </form>
</div>

<div id="resultform"></div>
<script src="https://code.jquery.com/jquery-3.2.1.js" crossorigin="anonymous"></script>
<script>
	var jQuerynotslim = $.noConflict(true);
</script>

	

<script>



    $('#formda').on('submit',function(e) {

            e.preventDefault();
            dataseri = $(this).serialize();
            console.log(dataseri);
            jQuerynotslim.ajax({
                url: 'incphp/submitDC.php',
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




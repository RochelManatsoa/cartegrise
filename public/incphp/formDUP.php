
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

$sqlfetchdemande = "SELECT * FROM `demande` WHERE `client_id` = (SELECT client_id FROM fos_user WHERE id = ".$_POST['currentid']." ) AND `type_demande` = 'DUP'";
$res = $conn2->query($sqlfetchdemande);

$currentclientdemandenumrows = mysqli_num_rows($res);

if($currentclientdemandenumrows == 0 ){

echo "<br><hr><br><h3>Vous n'avez effectué aucune demande</h2>";
}
else{
    //echo "Display demande";

    echo "<br><hr><h3>Vous avez déja effectué ".$currentclientdemandenumrows." demandes DUP</h3>";


}


?>


<hr>

<div class="container">
<form method="POST" id="formdup">   
    <input name="currentID" value="<?php echo $_POST['currentid'] ?>" type="hidden">
    <!--<fieldset>
        <legend class="control-label">Date Démarche</legend>
        <div class="form-group">
            <input class="form-control" name="DateDemarche" type="date">
            <input class="form-control" name="TimeDemarche" type="time">
        </div>
    </fieldset>-->


    <fieldset>
        <legend>Motif de la demande</legend>
        <select class="form-control" name="MotifDuplicata" id="MotifDuplicata" onchange="motif()">
            <option value="VOL">Vol</option>
            <option value="PERT">Perte</option>
            <option value="DETE">Détérioration</option>
        </select><br>
        <div id="datepertediv"></div>
        <label for="CTVOouDC">Demande effectuée dans le cadre d'un changement de titulaire ou de cession</label>
        <select class="form-control" name="CTVOouDC" id="CTVOouDC">
            <option value="oui">Oui</option>
            <option value="non">Non</option>
        </select><br>
    </fieldset>
    <fieldset>
        <legend class="control-label">Titulaire</legend>
        <div class="form-group">
            <select id="personne" name="personne"  class="form-control" onchange="titulaire()">
                <option value="phy" >Personne Physique</option>
                <option value="mor">Société</option>
            </select><br>

            <div id="titulaire"><label for="NomPrenom">Nom Prénom</label>
                <input class="form-control" name="NomPrenom" id="NomPrenom" required><br>
            </div>

        </div>
    </fieldset>


    <fieldset>

        <label class="control-label">Opposé à la réutilisation des données à des fins d’enquête et de prospection commerciale</label>
        <div class="form-group">
            <select class="form-control" name="DroitOpposition">
                <option value=1>oui</option>
                <option value=0>non</option>
            </select>
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

                <input class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="AB-123-CD ou 1234 AB 56 " pattern="[0-9]{1,4} [A-Z]{1,4} [0-9]{1,2}|[A-Z]{1,2}-[0-9]{1,3}-[A-Z]{1,2}" name="Immatriculation" id="Immatriculation" required><br>

                <label for="VIN">VIN</label>
                <input class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="VIN" id="VIN" required><br>

                <label for="NumFormule">Numero de Formule</label>
                <input class="form-control" name="NumFormule" id="NumFormule"><br>

                <label for="DateCI">Date CG</label>
                <input type="date" class="form-control" name="DateCI" id="DateCI"><br>
            </div>

        </div>
        
    </fieldset>
    

    <fieldset>
        <input value="enregistrer" type="submit" name="sauver" id="enregistrer">
    </fieldset>
</form>



</div>

<div id="resultform"></div>

<script>

    $('#formdup').on('submit',function(e) {

            e.preventDefault();
            dataseri = $(this).serialize();
            console.log(dataseri);
            $.ajax({
                url: 'incphp/submitDUP.php',
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





   <?php
include('client.class.php');
$client = new Client();

$servername2 = "localhost";
$username2 = "root";
//$password2 = "KrS7gj72";
$password2 = "";
$database2 = "cgdatabaseoffprod";

// Create connection
$conn2 = new mysqli($servername2, $username2, $password2, $database2);

// Check connection
if ($conn2->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>

<div id="Changement-de-titulaire" class="row commander">
	<div class="search">
		<form method="POST" id="formecg" >

			<div class="row ">
			
				<!--<div class="col-6">-->
				<div class="col-11 col-md-6 mx-auto search-box">
                	<div class="row col-12 mx-auto input-group ">
						<label for="TypeECG" class="col-12 search-box--titre">Démarche</label>
						<select name="TypeECG" id="TypeECG" class="mx-auto search-form">
							<option value="VOF">Véhicule d’Occasion Français</option>
							<option value="VOI">Véhicule d’Occasion Importé</option>
							<option value="VN">Véhicule Neuf</option>
							<option value="DUP">Duplicata</option>
						</select><br>
					</div>
				</div>
				
				<div class="col-11 col-md-6 mx-auto search-box">
                	<div class="row col-12 mx-auto input-group ">
						<label for="Immatriculation" class="col-12 search-box--titre">Numero d'Immatriculation</label>
						<input class="mx-auto search-form" onkeyup="this.value = this.value.toUpperCase();" placeholder="AB-123-CD ou 1234 AB 56 " pattern="[0-9]{1,4} [A-Z]{1,4} [0-9]{1,2}|[A-Z]{1,2}-[0-9]{1,3}-[A-Z]{1,2}" name="Immatriculation" id="Immatriculation" ><br>
					</div>
				</div>
					
				<div class="col-11 col-md-6 mx-auto search-box">
                	<div class="row col-12 mx-auto input-group ">
						<label for="CO2" class="col-12 search-box--titre">Taux de CO2 (V.7)</label>
						<input name="CO2" id="CO2" type="number" class="mx-auto search-form"><br>
					</div>
				</div>

				<div class="col-11 col-md-6 mx-auto search-box">
                	<div class="row col-12 mx-auto input-group ">
						<label for="Puissance" class="col-12 search-box--titre">Puissance fiscale (P.6)</label>
						<input name="Puissance" id="Puissance" type="number" class="mx-auto search-form"><br>
					</div>
				</div>

				<div class="col-11 col-md-6 mx-auto search-box">
                	<div class="row col-12 mx-auto input-group ">
						<label for="Genre" class="col-12 search-box--titre">Genre du Véhicule</label>
						<select name="Genre" id="Genre" class="mx-auto search-form">
							<option value="1">Véhicule particulier (VP)</option>
							<option value="2">Utilitaire (CTTE, Deriv-VP)</option>
							<option value="3">Camion, Bus, Tracteur non agricole (CAM, TCP, TRR)</option>
							<option value="4">VASP</option>
							<option value="5">Moto (MTL, MTT1, MTT2)</option>
							<option value="6">Cyclomoteur &lt;= 50cm3 (CL)</option>
							<option value="7">Quadricycle à moteur (QM)&nbsp;: voiturette, quad, buggy</option>
							<option value="8">Tracteur agricole, quad agricole (TRA)</option>
							<option value="9">Remorque, semi-remorque et caravane (REM, SREM, RESP)</option>
							<option value="10">Tricycle à moteur (TM)</option>
							<option value="11">Cyclomoteurs carrossés à 3 roues (CYCL)</option>
						</select><br>
					</div>
				</div>


				<div class="col-11 col-md-6 mx-auto search-box">
                	<div class="row col-12 mx-auto input-group ">
						<label for="PTAC" class="col-12 search-box--titre">Poids total autorisé en charge du vehicule || PTAC (F.2)</label>
						<select name="PTAC" id="PTAC" class="mx-auto search-form">
							<option value="1">PTAC inférieur à 3,5 t</option>
							<option value="2">PTAC entre 3,5 et 6 t</option>
							<option value="3">PTAC entre 6 et 11 t</option>
							<option value="4">PTAC supérieur à 11 t</option>
						</select><br>
					</div>
				</div>

				<!--</div>-->
				<div class="col-11 col-md-6 mx-auto search-box">
                	<div class="row col-12 mx-auto input-group ">

						<label for="Energie" class="col-12 search-box--titre">Energie (P.3)</label>
						<select name="Energie" id="Energie" class="mx-auto search-form">
							<option value="1">Essence ou diesel (gasoil)</option>
							<option value="2">GPL ou GNV</option>
							<option value="3">Electricité</option>
							<option value="4">Hybride</option>
							<option value="5">Bioéthanol E85</option>
						</select><br>
					</div>
				</div>

				<div class="col-11 col-md-6 mx-auto search-box">
                	<div class="row col-12 mx-auto input-group ">
						<label for="TypeVehicule" class="col-12 search-box--titre">Type de reception du vehicule</label>
						<select name="TypeVehicule" id="TypeVehicule"  class="mx-auto search-form">
							<option value="1">Réception Nationale</option>
							<option value="2">Réception Communautaire</option>
						</select><br>
					</div>
				</div>

				<div class="col-11 col-md-6 mx-auto search-box">
                	<div class="row col-12 mx-auto input-group ">
						<label for="Collection" class="col-12 search-box--titre">Est-ce un véhicule de collection ?</label>
						<select class="mx-auto search-form"  name="Collection" id="Collection">
							<option value="1">Oui</option>
							<option value="0">Non</option>
						</select><br>
					</div>
				</div>

				<div class="col-11 col-md-6 mx-auto search-box">
                	<div class="row col-12 mx-auto input-group ">
						<label for="Departement" class="col-12 search-box--titre">Departement d'immatriculation</label>
						<input type="text" class="mx-auto search-form" name="Departement" id="Departement" pattern="[0-9,A-B]{2,3}" maxlength="3" minlength="2"><br>
					</div>
				</div>

				<div class="col-11 col-md-6 mx-auto search-box">
                	<div class="row col-12 mx-auto input-group ">
						<label for="TypeAchat" class="col-12 search-box--titre">Type d'achat</label>
						<select name="TypeAchat" id="TypeAchat" class="mx-auto search-form">
							<option value="1">Véhicule Neuf</option>
							<option value="2">Véhicule d'Occasion Français</option>
							<option value="3">Véhicule d'Occasion Etranger</option>
						</select><br>
					</div>
				</div>

				<div class="col-11 col-md-6 mx-auto search-box">
                	<div class="row col-12 mx-auto input-group ">
						<label for="PremiereImmat" class="col-12 search-box--titre">Est-ce la première immatriculation du véhicule ?</label>
						<select name="PremiereImmat" id="PremiereImmat" class="mx-auto search-form">
							<option value="1">Oui</option>
							<option value="0">Non</option>
						</select>
					</div>
				</div>

				<div class="col-12 col-md-6 mx-auto text-center search-box">
	                <button type="submit" class="btn btn-primary btn-sm mx-auto">COMMANDER</button>
	            </div>

			</div>

		</form>

		<form method="POST" id="formecgauto">
			<div class="col-11 col-md-6 mx-auto search-box">
                <div class="row col-12 mx-auto input-group ">
					<label for="Immatriculation" class="col-12 search-box--titre">Numero d'Immatriculation</label>
					<input class="mx-auto search-form" onkeyup="this.value = this.value.toUpperCase();" placeholder="AB-123-CD ou 1234 AB 56 " pattern="[0-9]{1,4} [A-Z]{1,4} [0-9]{1,2}|[A-Z]{1,2}-[0-9]{1,3}-[A-Z]{1,2}" name="Immatriculation" id="Immatriculation" ><br>
				</div>
			</div>
			<div class="col-11 col-md-6 mx-auto search-box">
                <div class="row col-12 mx-auto input-group ">
					<label for="Departement" class="col-12 search-box--titre">Departement d'immatriculation</label>
					<input type="text" class="mx-auto search-form" name="Departement" id="Departement" pattern="[0-9,A-B]{2,3}" maxlength="3" minlength="2"><br>
				</div>
			</div>
			<div class="col-12 col-md-6 mx-auto text-center search-box">
	            <button type="submit" class="btn btn-primary btn-sm mx-auto">COMMANDER</button>
	        </div>

		</form>

	</div>
</div>

<div id="resultecg"></div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
<script>
	
    $('#formecg').on('submit',function(e) {

        e.preventDefault();
        dataseri = $(this).serialize();
        console.log(dataseri);
        $.ajax({
            url: 'incphp/submitECG.php',
            type: 'POST',
            data: dataseri,
            success: function(data) {
                //console.log(data);
                //console.log("test submit form");
                $('#resultecg').html(data);
            }               
        });
    });


    $('#formecgauto').on('submit', function(e){
    	e.preventDefault();
    	dataseri2 = $(this).serialize();
    	console.log(dataseri2);
    	$.ajax({
            url: 'incphp/submitECGAUTO.php',
            type: 'POST',
            data: dataseri2,
            success: function(data) {
                //console.log(data);
                //console.log("test submit form");
                $('#resultecg').html(data);
            }               
        });
    });

   


</script>

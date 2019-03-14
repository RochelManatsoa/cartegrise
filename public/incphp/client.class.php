<?php

class client
{
	public $TMS_CodeTMS = "31-000100";
	public $TMS_Login = "JE@n-Y100";
	public $TMS_Password = "GY-31@mLA";
	public $TMS_ApiKey = "d79c135056fdf6aeee19a83577ea1088f4afa49c4d814fd10a94533a5c1af00c";

	private function Ident($TMS_CodeTMS, $TMS_Login, $TMS_Password){
		$Ident = array("CodeTMS"=>$TMS_CodeTMS, "Login"=>$TMS_Login, "Password"=>$TMS_Password);
		return $Ident;
	}

	public function getInfoImmat($immat)
	{
		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);

		$params = array("Identification"=>$Identification, "Immatriculation"=>$immat);

		//-----------------------------------------------------------------------
		$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
		$client = new SoapClient($TMS_URL);
		//-----------------------------------------------------------------------
		$value = $client->InfoImmat($params);

		if(isset($value->Code)){
			throw new Exception('<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Erreur</strong>: cette immatriculation ne correspond a aucun vehicule</div>');
		}
		else{

			$bigresult = (array)$value->InfoVehicule->Reponse->Positive;
			echo '<table class="table table-bordered table-striped">';
			foreach($bigresult as $i => $j){
				//echo $i.' =>'.$j.'<br>';
				echo "<tr><th>".$i.":</th><td>".$j."</td></tr>";
			}
			echo '</table>';
		}
	}

	public function getInfoVIN($VIN)
	{
		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);

		$params = array("Identification"=>$Identification, "VIN"=>$VIN);

		//-----------------------------------------------------------------------
		$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
		$client = new SoapClient($TMS_URL);
		//-----------------------------------------------------------------------
		$value = $client->InfoVIN($params);
		
		echo '</table>';
		if(isset($value->Code)){
			throw new Exception('<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Erreur</strong>: ce VIN ne correspond a aucun vehicule</div>');
		}
		else{
			$bigresult = (array)$value->InfoVehicule->Reponse->Positive;
			echo '<table class="table table-bordered table-striped">';
			foreach($bigresult as $i => $j){
				//echo $i.' =>'.$j.'<br>';
				echo "<tr><th>".$i.":</th><td>".$j."</td></tr>";
			}
			echo '</table>';

		}

	}

	//recursive function display table
	private function recursivedisplay($value){
		//echo '<table class="table table-bordered table-striped">';
			foreach($value as $i => $j){

				if(is_array($j)){
					$this->recursivedisplay($j);
				}
				else{
					echo "<tr><th>".$i.":</th><td>".$j."</td></tr>";
				}

				
			}
			//echo '</table>';
	}


	public function chercher($immat, $type){
		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);

		if(empty($immat)){
			$params = array("Identification"=>$Identification, 'TypeDemarche' => $type);
		}
		else{
			$params = array("Identification"=>$Identification, "Immatriculation"=>$immat, 'TypeDemarche' => $type);
		}

		//-----------------------------------------------------------------------
		$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
		$client = new SoapClient($TMS_URL);
		//-----------------------------------------------------------------------
		$value = $client->Chercher($params);
		//var_dump($value);

		if(isset($value->Code)){
				throw new Exception('<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Erreur</strong>: '.$value->Erreur.'</div>');
		}
		else{
				
			$json = json_encode($value->Lot->Demarche);
			$objectjson = json_decode($json, true);
			//var_dump($objectjson);
			foreach($objectjson as $t){
			
			if(isset($t[$type])){
				$bigresult = $t[$type];
			}
			else{
				$bigresult = $t;
			}
			
			
			echo '<table class="table table-bordered table-striped">';
			/*
			foreach($bigresult as $i => $j){

				if(is_array($j)){
					foreach($j as $k => $l){
						echo "<tr><th>".$i.":</th><td>".$k." : ".$l."</td></tr>";
					}
				}
				else{
					echo "<tr><th>".$i.":</th><td>".$j."</td></tr>";
				}

				
			}*/
			$this->recursivedisplay($bigresult);
			echo '</table><br>';
			}
		}

		
	}

	public function ouvrir($id, $type){
		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);

		$params = array("Identification"=>$Identification, "IDDemarche"=>$id, 'TypeDemarche' => $type);


		//-----------------------------------------------------------------------
		$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
		$client = new SoapClient($TMS_URL);
		//-----------------------------------------------------------------------
		$value = $client->Ouvrir($params);

		if(isset($value->Code)){
				throw new Exception('<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Erreur</strong>: '.$value->Erreur.'</div>');
		}
		else{
			//var_dump($value);

			$json = json_encode($value->Demarche);
			$objectjson = json_decode($json, true);
			//var_dump($objectjson);
			foreach($objectjson as $t){
			
			if(isset($t[$type])){
				$bigresult = $t[$type];
			}
			else{
				$bigresult = $t;
			}
			var_dump($bigresult);
			
			
			echo '<table class="table table-bordered table-striped">';
			/*
			foreach($bigresult as $i => $j){

				if(is_array($j)){
					foreach($j as $k => $l){
						echo "<tr><th>".$i.":</th><td>".$k." : ".$l."</td></tr>";
					}
				}
				else{
					echo "<tr><th>".$i.":</th><td>".$j."</td></tr>";
				}

				
			}*/
			$this->recursivedisplay($bigresult);
			echo '</table><br>';
			}

		}
	}

	//$demarche = DA || DC || CTVO  return doc
	public function editer($type, $demarche, $demarchetype){
		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);

		

		//$demarche = array("DC" => $DC);

		//$DC = array("TypeDemarche" => $demarchetype);
		$typeDemarche = array($demarchetype => $demarche );

		$params = array("Identification"=>$Identification, 'Type' => $type, "Demarche"=>$typeDemarche );

		//-----------------------------------------------------------------------
		$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
		$client = new SoapClient($TMS_URL);
		//-----------------------------------------------------------------------
		$value = $client->Editer($params);
		
		if(isset($value->Code)){
				throw new Exception('<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Erreur</strong>: '.$value->Erreur.'</div>');
		}
		else{
			//var_dump($value);

			

			if($type == "Cerfa"){

				//$decoded = base64_decode($value->Document);
				//$file = 'CERFA.pdf';
				//$filefinal = file_put_contents($file, $decoded);
				//echo $file;

				echo '<div class="col " id="dll_cerfa">';
	        	
				//echo '<form method="POST" action="{{ path("dllcerfa") }}">';
				?>
				<form method="POST" action="/dlcerfa">
		<?php
			    echo '<input type="hidden" name="get_fic" value="'.$value->Document.'">';
			    echo '<input type="submit" class="mx-auto btn btn-outline-primary" value="Telecharger votre CERFA">';
				echo '</form>';

				echo '</div>';
			}
			else{
				//$decoded = base64_decode($value->Document);
				//$file = 'Mandat.pdf';
				//file_put_contents($file, $decoded);
				//echo $file;

				echo '<div class="col " id="dllmandat">';
	        	
				//echo '<form method="POST">';
				?>
				<form method="POST" action="/dlmandat">
		<?php
			    echo '<input type="hidden" name="get_fic" value="'.$value->Document.'">';
			    echo '<input type="submit" class="mx-auto btn btn-outline-warning" value="Telecharger un Mandat">';
				echo '</form>';

				echo '</div>';
			}
			

				if(isset($_POST['get_fic'])){

				    if (file_exists($file)) {

					    /*header('Content-Description: File Transfer');
					    header('Content-Type: application/octet-stream');
						header("Content-Transfer-Encoding: Binary"); 
					    header('Content-Disposition: attachment; filename="'.basename($file).'"');
					    header('Expires: 0');
					    header('Cache-Control: must-revalidate');
					    header('Pragma: public');
					    header('Content-Length: ' . filesize($file));
					    readfile($file);
					    //exit;*/
					}
				}
			


			//return $value;
		}

	}


	/*
	public function sauvertestDA(){
		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);
		$Titulaire = array("NomPrenom" => "Wayne Martha");

		//---------------------------------Acquerreur----------------------------------------
		$PersonnePhysique = array("Nom" => "SMITH", "Prenom" => "Sylvie", "Sexe" => "F");
		$Adresse = array("Numero" => 204, "TypeVoie" => "RUE", "NomVoie" => "Martelle Sevrak", "CodePostal" => "29200", "Ville" => "Brest");
		$DroitOpposition = 1;

		$Acquereur = array("PersonnePhysique" => $PersonnePhysique, "Adresse" => $Adresse, "DroitOpposition" => $DroitOpposition);
		//------------------------------------------------------------------------------------

		$Vehicule = array("VIN" => "VIN888", "Immatriculation" => "CS-346-NS", "CIPresent" => 1, "DateCI" => "03/10/2018");

		$DA = array("ID" => 6, "TypeDemarche" => "DA", "DateAchat" => "10/10/2018", "DateDemarche" => "10/10/2018", "Titulaire" => $Titulaire, "Acquereur" => $Acquereur, "Vehicule" => $Vehicule);

		$Demarche = array("DA" => $DA);
		$Lot = array("Demarche" => $Demarche);


		$params = array("Identification"=>$Identification, "Lot" => $Lot);
		//$params = array_merge($params, $parameters);
		var_dump($params);


		//-----------------------------------------------------------------------
		$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
		$client = new SoapClient($TMS_URL);
		//-----------------------------------------------------------------------
		$value = $client->Sauver($params);


		if(isset($value->Code)){
				throw new Exception('<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Erreur '.$value->Code.'</strong>: '.$value->Erreur.'</div>');
		}
		else{
			echo "<hr>";
			var_dump($value);
		}
	}*/

	public function sauverDA1($post){
		
		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);

		//---------------------------------Titulaire-----------------------------------------
		if($post['personne'] == "phy"){
			$Titulaire = array("NomPrenom" => $post['NomPrenom']);
		}
		else{
			$Titulaire = array("RaisonSociale" => $post['RaisonSociale1']);
		}

		//---------------------------------Acquerreur----------------------------------------
		

		if($post['personne2'] == "phy"){
			if($post['sexe'] == "F"){
				$PersonnePhysique = array("Nom" => $post['Nom'], "Prenom" => $post['Prenom'], "Sexe" => $post['sexe'], "NomUsage" => $post['NomUsage']);
			}
			else{
				$PersonnePhysique = array("Nom" => $post['Nom'], "Prenom" => $post['Prenom'], "Sexe" => $post['sexe']);
			}
			
			$Adresse = array("Numero" => $post['Numero'], "TypeVoie" => $post['TypeVoie'], "NomVoie" => $post['NomVoie'], "CodePostal" => $post['CodePostal'], "Ville" => $post['Ville']);
			$DroitOpposition = $post['DroitOpposition'];

			$Acquereur = array("PersonnePhysique" => $PersonnePhysique, "Adresse" => $Adresse, "DroitOpposition" => $DroitOpposition);
		}
		else{
			if($post['SocieteCommerciale'] == 1 ){
				$PersonneMorale = array("RaisonSociale" => $post["RaisonSociale2"], "SocieteCommerciale" => $post['SocieteCommerciale'], "SIREN" => $post["SIREN"]);
			}
			else{
				$PersonneMorale = array("RaisonSociale" => $post["RaisonSociale2"], "SocieteCommerciale" => $post['SocieteCommerciale']);
			}
			$Adresse = array("Numero" => $post['Numero'], "TypeVoie" => $post['TypeVoie'], "NomVoie" => $post['NomVoie'], "CodePostal" => $post['CodePostal'], "Ville" => $post['Ville']);
			$DroitOpposition = $post['DroitOpposition'];

			$Acquereur = array("PersonneMorale" => $PersonneMorale, "Adresse" => $Adresse, "DroitOpposition" => $DroitOpposition);	
		}


		//-----------------------------------Info Vehicule------------------------------------

		if($post["CIPresent"] == 1){
			$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "DateCI" => $post["DateCI"]);

			if( preg_match("/[0-9]{1,4} [A-Z]{1,4} [0-9]{1,2}/", $post['Immatriculation'])){
				echo "<br>TEST FNI<br>";
				$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "DateCI" => $post["DateCI"]);
				var_dump($Vehicule);
			}
			else{
				echo "<br>TEST SIV<br>";
				$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "NumFormule" => $post["NumFormule"]);
				var_dump($Vehicule);
			}
		}
		else{

			$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 0);
		}


		$DA = array("ID" => "", "TypeDemarche" => "DA", "DateAchat" => "10/10/2018", "DateDemarche" => $post["DateDemarche"], "Titulaire" => $Titulaire, "Acquereur" => $Acquereur, "Vehicule" => $Vehicule);

		$Demarche = array("DA" => $DA);
		$Lot = array("Demarche" => $Demarche);


		$params = array("Identification"=>$Identification, "Lot" => $Lot);
		//$params = array_merge($params, $parameters);
		//var_dump($params);


		//-----------------------------------------------------------------------
		$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
		$client = new SoapClient($TMS_URL);
		//-----------------------------------------------------------------------
		$value = $client->Sauver($params);


		if(isset($value->Code)){
				throw new Exception('<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Erreur '.$value->Code.'</strong>: '.$value->Erreur.'</div>');
		}
		else{
			echo "<hr>";
			var_dump($value);
			//$sql = "INSERT INTO demande VALUES $post['']"
		}
		//var_dump($post);
	}


	public function sauverDC($post){
		
		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);

		//---------------------------------Titulaire-----------------------------------------
		if($post['personne'] == "phy"){
			$Titulaire = array("NomPrenom" => $post['NomPrenom']);
		}
		else{
			$Titulaire = array("RaisonSociale" => $post['RaisonSociale1']);
		}

		//---------------------------------Acquerreur----------------------------------------
		

		if($post['personne2'] == "phy"){
			if($post['sexe'] == "F"){
				$PersonnePhysique = array("Nom" => $post['Nom'], "Prenom" => $post['Prenom'], "Sexe" => $post['sexe'], "NomUsage" => $post['NomUsage']);
			}
			else{
				$PersonnePhysique = array("Nom" => $post['Nom'], "Prenom" => $post['Prenom'], "Sexe" => $post['sexe']);
			}
			
			$Adresse = array("Numero" => $post['Numero'], "TypeVoie" => $post['TypeVoie'], "NomVoie" => $post['NomVoie'], "CodePostal" => $post['CodePostal'], "Ville" => $post['Ville']);
			$DroitOpposition = $post['DroitOpposition'];

			$Acquereur = array("PersonnePhysique" => $PersonnePhysique, "Adresse" => $Adresse, "DroitOpposition" => $DroitOpposition);
		}
		else{
			if($post['SocieteCommerciale'] == 1 ){
				$PersonneMorale = array("RaisonSociale" => $post["RaisonSociale2"], "SocieteCommerciale" => $post['SocieteCommerciale'], "SIREN" => $post["SIREN"]);
			}
			else{
				$PersonneMorale = array("RaisonSociale" => $post["RaisonSociale2"], "SocieteCommerciale" => $post['SocieteCommerciale']);
			}
			$Adresse = array("Numero" => $post['Numero'], "TypeVoie" => $post['TypeVoie'], "NomVoie" => $post['NomVoie'], "CodePostal" => $post['CodePostal'], "Ville" => $post['Ville']);
			$DroitOpposition = $post['DroitOpposition'];

			$Acquereur = array("PersonneMorale" => $PersonneMorale, "Adresse" => $Adresse, "DroitOpposition" => $DroitOpposition);	
		}


		//-----------------------------------Info Vehicule------------------------------------

		if($post["CIPresent"] == 1){
			$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "DateCI" => $post["DateCI"]);

			if( preg_match("/[0-9]{1,4} [A-Z]{1,4} [0-9]{1,2}/", $post['Immatriculation'])){
				echo "<br>TEST FNI<br>";
				$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "DateCI" => $post["DateCI"]);
				var_dump($Vehicule);
			}
			else{
				echo "<br>TEST SIV<br>";
				$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "NumFormule" => $post["NumFormule"]);
				var_dump($Vehicule);
			}
		}
		else{

			$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 0);
		}

		$DateDemarche = date('Y-m-d H:i:s');


		$DC = array("ID" => "", "TypeDemarche" => "DC", "DateCession" => $post["DateAchat"], "DateDemarche" => $DateDemarche, "Titulaire" => $Titulaire, "Acquereur" => $Acquereur, "Vehicule" => $Vehicule);

		$Demarche = array("DC" => $DC);
		$Lot = array("Demarche" => $Demarche);


		$params = array("Identification"=>$Identification, "Lot" => $Lot);
		//$params = array_merge($params, $parameters);
		//var_dump($params);


		//-----------------------------------------------------------------------
		$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
		$client = new SoapClient($TMS_URL);
		//-----------------------------------------------------------------------
		$value = $client->Envoyer($params);


		if(isset($value->Code)){
				throw new Exception('<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Erreur '.$value->Code.'</strong>: '.$value->Erreur.'</div>');
		}
		else{
			echo "<hr>";
			var_dump($value);
			$dcidtms = $value->Lot->Demarche->DC->ID;
			return $dcidtms;
		}
		//var_dump($post);
	}

	public function sauverDSV($post){
		
		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);

		//---------------------------------Titulaire-----------------------------------------
		if($post['personne'] == "phy"){
			$Titulaire = array("NomPrenom" => $post['NomPrenom']);
		}
		else{
			$Titulaire = array("RaisonSociale" => $post['RaisonSociale1']);
		}


		//-----------------------------------Info Vehicule------------------------------------

			//$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "DateCI" => $post["DateCI"]);

			if( preg_match("/[0-9]{1,4} [A-Z]{1,4} [0-9]{1,2}/", $post['Immatriculation'])){
				echo "<br>TEST FNI<br>";
				$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "DateCI" => $post["DateCI"]);
				var_dump($Vehicule);
			}
			else{
				echo "<br>TEST SIV<br>";
				$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "NumFormule" => $post["NumFormule"]);
				var_dump($Vehicule);
			}



		$DSV = array("ID" => "", "TypeDemarche" => "DSV", "DateDemarche" => $post["DateDemarche"], "Titulaire" => $Titulaire, "Vehicule" => $Vehicule);

		$Demarche = array("DSV" => $DSV);
		$Lot = array("Demarche" => $Demarche);


		$params = array("Identification"=>$Identification, "Lot" => $Lot);
		//$params = array_merge($params, $parameters);
		//var_dump($params);


		//-----------------------------------------------------------------------
		$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
		$client = new SoapClient($TMS_URL);
		//-----------------------------------------------------------------------
		$value = $client->Sauver($params);


		if(isset($value->Code)){
				throw new Exception('<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Erreur '.$value->Code.'</strong>: '.$value->Erreur.'</div>');
		}
		else{
			echo "<hr>";
			var_dump($value);
			/*$savedID = $value->Lot->Demarche->DSV->ID;
			echo $savedID;
			$sql = "INSERT INTO demande VALUES ".$savedID.", DSV, NULL, client_id, statut, paiement, NULL";
			echo '<br>'.$sql;*/
		}
		//var_dump($post);
	}

	public function sauverCTVO($post){

		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);

		//---------------------------------Titulaire-----------------------------------------
		if($post['personne'] == "phy"){
			$Titulaire = array("NomPrenom" => $post['NomPrenom']);
		}
		else{
			$Titulaire = array("RaisonSociale" => $post['RaisonSociale1']);
		}

		//---------------------------------Nouveau Titulaire----------------------------------------
		

		if($post['personne2'] == "phy"){
			if($post['sexe'] == "F"){
				$PersonnePhysique = array("Nom" => $post['Nom'], "Prenom" => $post['Prenom'], "Sexe" => $post['sexe'], "NomUsage" => $post['NomUsage'], "DateNaissance" => $post['DateNaissance'], "LieuNaissance" => $post["LieuNaissance"]);
			}
			else{
				$PersonnePhysique = array("Nom" => $post['Nom'], "Prenom" => $post['Prenom'], "Sexe" => $post['sexe'], "DateNaissance" => $post['DateNaissance'], "LieuNaissance" => $post["LieuNaissance"]);
			}
			
			$Adresse = array("Numero" => $post['Numero'], "TypeVoie" => $post['TypeVoie'], "NomVoie" => $post['NomVoie'], "CodePostal" => $post['CodePostal'], "Ville" => $post['Ville']);
			$DroitOpposition = $post['DroitOpposition'];

			$Acquereur = array("PersonnePhysique" => $PersonnePhysique, "Adresse" => $Adresse, "DroitOpposition" => $DroitOpposition);
		}
		else{
			if($post['SocieteCommerciale'] == 1 ){
				$PersonneMorale = array("RaisonSociale" => $post["RaisonSociale2"], "SocieteCommerciale" => $post['SocieteCommerciale'], "SIREN" => $post["SIREN"]);
			}
			else{
				$PersonneMorale = array("RaisonSociale" => $post["RaisonSociale2"], "SocieteCommerciale" => $post['SocieteCommerciale']);
			}
			$Adresse = array("Numero" => $post['Numero'], "TypeVoie" => $post['TypeVoie'], "NomVoie" => $post['NomVoie'], "CodePostal" => $post['CodePostal'], "Ville" => $post['Ville']);
			$DroitOpposition = $post['DroitOpposition'];

			$Acquereur = array("PersonneMorale" => $PersonneMorale, "Adresse" => $Adresse, "DroitOpposition" => $DroitOpposition);	
		}

		//-----------------------------------Info Vehicule------------------------------------

		if($post["CIPresent"] == 1){
			$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "DateCI" => $post["DateCI"]);

			if( preg_match("/[0-9]{1,4} [A-Z]{1,4} [0-9]{1,2}/", $post['Immatriculation'])){
				//echo "<br>TEST FNI<br>";
				$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "DateCI" => $post["DateCI"]);
				//var_dump($Vehicule);
			}
			else{
				//echo "<br>TEST SIV<br>";
				$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "NumFormule" => $post["NumFormule"]);
				//var_dump($Vehicule);
			}
		}
		else{

			$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 0);
		}


		//-----------------------------------Co-titulaire----------------------------------------

		$NbCotitulaires = $post['NbCotitulaires'];
		$Cotitulaires = array();
		for($j = 0; $j<$NbCotitulaires; $j= $j+1){

			//nom test
			//echo "<br><p style='font-color:red'>".$post["nomct"][$j]."</p>";

			//check if premier cotitulaire
			if($j == 0){
				$PremierCotitulaire = true;
			}
			else{
				$PremierCotitulaire = false;
			}

			//type personne
			//echo $post['personne3'][$j];
			$personne3type = $post['personne3'][$j];

			if($personne3type == "PersonnePhysique"){
				$nomct = $post["nomct"][$j];
				$prenomct = $post["prenomct"][$j];
				$sexect = $post["sexe3"][$j];

				$PersonnePhysiquect = array("Nom" => $nomct, "Prenom" => $prenomct, "Sexe" => $sexect);
				$Cotitulaires[$j] = array("PremierCotitulaire" => $PremierCotitulaire, "PersonnePhysique" => $PersonnePhysiquect);
			}
			else{
				$raisonct = $post["raisonct"][$j];

				$PersonneMoralect = array("RaisonSociale" => $raisonct);
				$Cotitulaires[$j] = array("PremierCotitulaire" => $PremierCotitulaire, "PersonneMorale" => $PersonneMoralect);
			}




		}
		//echo "<hr>";
		//var_dump($Cotitulaires);




		//----------------------------------------------------------------------------------------------------

		$DateDemarche = date('Y-m-d H:i:s');

		$CTVO = array("ID" => "", "TypeDemarche" => "CTVO", "DateDemarche" => $DateDemarche, "Titulaire" => $Titulaire, "Acquereur" => $Acquereur, "Vehicule" => $Vehicule, "NbCotitulaires" => $NbCotitulaires, "Cotitulaires" => $Cotitulaires);

		$Demarche = array("CTVO" => $CTVO);
		$Lot = array("Demarche" => $Demarche);


		$params = array("Identification"=>$Identification, "Lot" => $Lot);
		//$params = array_merge($params, $parameters);
		//var_dump($params);


		//-----------------------------------------------------------------------
		$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
		$client = new SoapClient($TMS_URL);
		//-----------------------------------------------------------------------
		//$value = $client->Sauver($params);
		$value = $client->Envoyer($params);


		if(isset($value->Code)){
				throw new Exception('<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Erreur '.$value->Code.'</strong>: '.$value->Erreur.'</div>');
		}
		else{
			//echo "<hr>";
			$ctvoidtms = $value->Lot->Demarche->CTVO->ID;
			return $ctvoidtms;
			//echo "<hr>";
			//var_dump($params);
			//$sql = "INSERT INTO demande VALUES $post['']"
		}
		//var_dump($post);

	}

	public function sauverDIVN($post){

		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);
		
		//---------------------------------Nouveau Titulaire----------------------------------------
		

		if($post['personne2'] == "phy"){
			if($post['sexe'] == "F"){
				$PersonnePhysique = array("Nom" => $post['Nom'], "Prenom" => $post['Prenom'], "Sexe" => $post['sexe'], "NomUsage" => $post['NomUsage'], "DateNaissance" => $post['DateNaissance'], "LieuNaissance" => $post["LieuNaissance"]);
			}
			else{
				$PersonnePhysique = array("Nom" => $post['Nom'], "Prenom" => $post['Prenom'], "Sexe" => $post['sexe'], "DateNaissance" => $post['DateNaissance'], "LieuNaissance" => $post["LieuNaissance"]);
			}
			
			$Adresse = array("Numero" => $post['Numero'], "TypeVoie" => $post['TypeVoie'], "NomVoie" => $post['NomVoie'], "CodePostal" => $post['CodePostal'], "Ville" => $post['Ville']);
			$DroitOpposition = $post['DroitOpposition'];

			$Acquereur = array("PersonnePhysique" => $PersonnePhysique, "Adresse" => $Adresse, "DroitOpposition" => $DroitOpposition);
		}
		else{
			if($post['SocieteCommerciale'] == 1 ){
				$PersonneMorale = array("RaisonSociale" => $post["RaisonSociale2"], "SocieteCommerciale" => $post['SocieteCommerciale'], "SIREN" => $post["SIREN"]);
			}
			else{
				$PersonneMorale = array("RaisonSociale" => $post["RaisonSociale2"], "SocieteCommerciale" => $post['SocieteCommerciale']);
			}
			$Adresse = array("Numero" => $post['Numero'], "TypeVoie" => $post['TypeVoie'], "NomVoie" => $post['NomVoie'], "CodePostal" => $post['CodePostal'], "Ville" => $post['Ville']);
			$DroitOpposition = $post['DroitOpposition'];

			$Acquereur = array("PersonneMorale" => $PersonneMorale, "Adresse" => $Adresse, "DroitOpposition" => $DroitOpposition);	
		}



		//-----------------------------------Info Vehicule------------------------------------


			$Vehicule = array("VIN" => $post['VIN'], 'D1_Marque' => $post['D1_Marque'], "D2_Version" => $post["D2_Version"], "K_NumRecpCE" => $post["K_NumRecpCE"], "F1_MMaxTechAdm" => $post['F1_MMaxTechAdm'], "G_MMaxAvecAttelage" => $post["G_MMaxAvecAttelage"], "G1_PoidsVide" => $post["G1_PoidsVide"], "J_CategorieCE" => $post["J_CategorieCE"],  'J1_Genre' => $post['J1_Genre'], "J3_Carrosserie" => $post["J3_Carrosserie"], 'P6_PuissFiscale' => $post['P6_PuissFiscale'] );


		/*if($post["CIPresent"] == 1){
			$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "DateCI" => $post["DateCI"]);

			if( preg_match("/[0-9]{1,4} [A-Z]{1,4} [0-9]{1,2}/", $post['Immatriculation'])){
				//echo "<br>TEST FNI<br>";
				$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "DateCI" => $post["DateCI"]);
				//var_dump($Vehicule);
			}
			else{
				//echo "<br>TEST SIV<br>";
				$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "NumFormule" => $post["NumFormule"]);
				//var_dump($Vehicule);
			}
		}
		else{

			$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 0);
		}*/


		//-----------------------------------Co-titulaire----------------------------------------

		$NbCotitulaires = $post['NbCotitulaires'];
		$Cotitulaires = array();
		for($j = 0; $j<$NbCotitulaires; $j= $j+1){

			//nom test
			//echo "<br><p style='font-color:red'>".$post["nomct"][$j]."</p>";

			//check if premier cotitulaire
			if($j == 0){
				$PremierCotitulaire = true;
			}
			else{
				$PremierCotitulaire = false;
			}

			//type personne
			//echo $post['personne3'][$j];
			$personne3type = $post['personne3'][$j];

			if($personne3type == "PersonnePhysique"){
				$nomct = $post["nomct"][$j];
				$prenomct = $post["prenomct"][$j];
				$sexect = $post["sexe3"][$j];

				$PersonnePhysiquect = array("Nom" => $nomct, "Prenom" => $prenomct, "Sexe" => $sexect);
				$Cotitulaires[$j] = array("PremierCotitulaire" => $PremierCotitulaire, "PersonnePhysique" => $PersonnePhysiquect);
			}
			else{
				$raisonct = $post["raisonct"][$j];

				$PersonneMoralect = array("RaisonSociale" => $raisonct);
				$Cotitulaires[$j] = array("PremierCotitulaire" => $PremierCotitulaire, "PersonneMorale" => $PersonneMoralect);
			}




		}
		//echo "<hr>";
		//var_dump($Cotitulaires);




		//----------------------------------------------------------------------------------------------------

		$DateDemarche = date('Y-m-d H:i:s');

		$DIVN = array("ID" => "", "TypeDemarche" => "DIVN", "DateDemarche" => $DateDemarche, "Acquereur" => $Acquereur, "Vehicule" => $Vehicule, "NbCotitulaires" => $NbCotitulaires, "Cotitulaires" => $Cotitulaires);

		$Demarche = array("DIVN" => $DIVN);
		$Lot = array("Demarche" => $Demarche);


		$params = array("Identification"=>$Identification, "Lot" => $Lot);
		//$params = array_merge($params, $parameters);
		//var_dump($params);


		//-----------------------------------------------------------------------
		$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
		$client = new SoapClient($TMS_URL);
		//-----------------------------------------------------------------------
		//$value = $client->Sauver($params);
		
		$value = $client->Envoyer($params);
		echo '<hr>';
		var_dump($value);


		if(isset($value->Code)){
				throw new Exception('<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Erreur '.$value->Code.'</strong>: '.$value->Erreur.'</div>');
		}
		else{
			//echo "<hr>";
			$ctvoidtms = $value->Lot->Demarche->DIVN->ID;
			return $ctvoidtms;
			//echo "<hr>";
			//var_dump($params);
			//$sql = "INSERT INTO demande VALUES $post['']"
		}
		//var_dump($post);

	}


	public function findParamsById($id, $type)
	{

		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);

		$params = array("Identification"=>$Identification, "IDDemarche"=>$id, 'TypeDemarche' => $type);


		//-----------------------------------------------------------------------
		$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
		$client = new SoapClient($TMS_URL);
		//-----------------------------------------------------------------------
		$value = $client->Ouvrir($params);

		if(isset($value->Code)){
				throw new Exception('<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Erreur '.$value->Code.'</strong>: '.$value->Erreur.'</div>');
		}
		else{
			//var_dump($value);

			$json = json_encode($value->Demarche);
			$objectjson = json_decode($json, true);
			//var_dump($objectjson);
			foreach($objectjson as $t){
			
			if(isset($t[$type])){
				$bigresult = $t[$type];
			}
			else{
				$bigresult = $t;
			}
			//var_dump($bigresult['Reponse']['Positive']);

			if(isset($bigresult['Reponse']['Positive'])){


				if($type == "DC"){
					$urlfic = 'http://test.webservice.misiv.fr/pdf.php?fichier='.$bigresult['Reponse']['Positive']['NomFic']."&codetms=".$this->TMS_CodeTMS."&apikey=".$this->TMS_ApiKey;
				}else{
			
				echo '<table class="table table-bordered table-striped mx-auto">';
				/*
				foreach($bigresult as $i => $j){

					if(is_array($j)){
						foreach($j as $k => $l){
							echo "<tr><th>".$i.":</th><td>".$k." : ".$l."</td></tr>";
						}
					}
					else{
						echo "<tr><th>".$i.":</th><td>".$j."</td></tr>";
					}

					
				}*/
				echo "<tr><th>Taxe Regionale</th><td>".$bigresult['Reponse']['Positive']['TaxeRegionale']."€</td></tr>";
				echo "<tr><th>Taxe Parafiscale</th><td>".$bigresult['Reponse']['Positive']['TaxeParafiscale']."€</td></tr>";
				echo "<tr><th>Taxe CO2</th><td>".$bigresult['Reponse']['Positive']['TaxeCO2']."€</td></tr>";
				echo "<tr><th>Taxe SIV</th><td>".$bigresult['Reponse']['Positive']['TaxeSIV']."€</td></tr>";
				echo "<tr><th>Taxe RedevanceSIV</th><td>".$bigresult['Reponse']['Positive']['TaxeRedevanceSIV']."€</td></tr>";
				echo "<tr><th>Frais de traitement du dossier</th><td> Nos Prix </td></tr>";
				echo "<tr><th>Taxe Totale</th><td>".$bigresult['Reponse']['Positive']['TaxeTotale']."€</td></tr>";

			



				//$this->recursivedisplay($bigresult['Reponse']);
				echo '</table><br>';

				$urlfic = 'http://test.webservice.misiv.fr/pdf.php?fichier='.$bigresult['Reponse']['Positive']['NomFic']."&codetms=".$this->TMS_CodeTMS."&apikey=".$this->TMS_ApiKey;
				/*echo '<a href="#" onclick="loadXMLDoc()">click to call function</a>';


				//echo file_get_contents($urlfic);
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $urlfic);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_HEADER, false);
				$data = curl_exec($curl);
				curl_close($curl);

				$downloadPath = "RECAP.pdf";
				file_put_contents($downloadPath, $data);
				/*$file = fopen($downloadPath, "w+");
				fputs($file, $data);
				fclose($file);*/

				//readfile($data);
				}
			}
			else{
				echo '<div class="alert alert-danger" role="alert">'.$bigresult['Reponse']['Negative']['Erreur'].'</div>';
			}




			}

		}
	
	}

	public function getNomFic($id, $type){
		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);

		$params = array("Identification"=>$Identification, "IDDemarche"=>$id, 'TypeDemarche' => $type);


		//-----------------------------------------------------------------------
		$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
		$client = new SoapClient($TMS_URL);
		//-----------------------------------------------------------------------
		$value = $client->Ouvrir($params);

		if(isset($value->Code)){
				throw new Exception('<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Erreur</strong>: '.$value->Erreur.'</div>');
		}
		else{
			//var_dump($value);

			$json = json_encode($value->Demarche);
			$objectjson = json_decode($json, true);
			//var_dump($objectjson);
			foreach($objectjson as $t){
			
			if(isset($t[$type])){
				$bigresult = $t[$type];
			}
			else{
				$bigresult = $t;
			}

			if(isset($bigresult['Reponse']['Positive'])){
				return $bigresult['Reponse']['Positive']['NomFic'];
			}
			else{
				return 0;
			}

			
			}
		}
	}


	public function getDemande($id, $type){
		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);

		$params = array("Identification"=>$Identification, "IDDemarche"=>$id, 'TypeDemarche' => $type);


		//-----------------------------------------------------------------------
		$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
		$client = new SoapClient($TMS_URL);
		//-----------------------------------------------------------------------
		$value = $client->Ouvrir($params);

		if(isset($value->Code)){
				throw new Exception('<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Erreur</strong>: '.$value->Erreur.'</div>');
		}
		else{
			//var_dump($value);

			$json = json_encode($value->Demarche);
			$objectjson = json_decode($json, true);
			//var_dump($objectjson);
			foreach($objectjson as $t){
			
			if(isset($t[$type])){
				$bigresult = $t[$type];
			}
			else{
				$bigresult = $t;
			}
			/*var_dump($bigresult['Titulaire']);
			var_dump($bigresult['Acquereur']);
			var_dump($bigresult['Vehicule']);
			var_dump($bigresult['TypeDemarche']);
			var_dump($bigresult['DateDemarche']);*/

			return $bigresult;




			
			
			
			}

		}
	}

	public function envoyerDUP($post){
		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);

		//---------------------------------Titulaire-----------------------------------------

		$DroitOpposition = $post['DroitOpposition'];

		if($post['personne'] == "phy"){
			$Titulaire = array("NomPrenom" => $post['NomPrenom'], "DroitOpposition" => $DroitOpposition);
		}
		else{
			$Titulaire = array("RaisonSociale" => $post['RaisonSociale1'], "DroitOpposition" => $DroitOpposition);
		}



		//-----------------------------------Info Vehicule------------------------------------

		if($post["CIPresent"] == 1){
			$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "DateCI" => $post["DateCI"]);

			if( preg_match("/[0-9]{1,4} [A-Z]{1,4} [0-9]{1,2}/", $post['Immatriculation'])){
				//echo "<br>TEST FNI<br>";
				$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "DateCI" => $post["DateCI"]);
				//var_dump($Vehicule);
			}
			else{
				//echo "<br>TEST SIV<br>";
				$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "NumFormule" => $post["NumFormule"]);
				//var_dump($Vehicule);
			}
		}
		else{

			$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 0);
		}

		//-------------------------------------Info DUP----------------------------------



		//----------------------------------------------------------------------------------------------------

		$DateDemarche = date('Y-m-d H:i:s');

		//$DUP = array("ID" => "", "TypeDemarche" => "DUP", "DateDemarche" => $DateDemarche, "Titulaire" => $Titulaire, "Vehicule" => $Vehicule);
		if(isset($post['DatePerte'])){
			//$infodemande = array("MotifDuplicata" => $post['MotifDuplicata'], "CTVOouDC" => $post['CTVOouDC'], "DatePerte" = > $post['DatePerte']);
			$DUP = array("ID" => "", "TypeDemarche" => "DUP", "DateDemarche" => $DateDemarche, "Titulaire" => $Titulaire, "Vehicule" => $Vehicule, "MotifDuplicata" => $post['MotifDuplicata'], "CTVOouDC" => $post['CTVOouDC'], "DatePerte" => $post['DatePerte']);
		}
		else{
			//$infodemande = array("MotifDuplicata" => $post['MotifDuplicata'], "CTVOouDC" => $post['CTVOouDC']);
			$DUP = array("ID" => "", "TypeDemarche" => "DUP", "DateDemarche" => $DateDemarche, "Titulaire" => $Titulaire, "Vehicule" => $Vehicule, "MotifDuplicata" => $post['MotifDuplicata'], "CTVOouDC" => $post['CTVOouDC']);
		}

		$Demarche = array("DUP" => $DUP);
		$Lot = array("Demarche" => $Demarche);


		$params = array("Identification"=>$Identification, "Lot" => $Lot);

		//-----------------------------------------------------------------------
		$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
		$client = new SoapClient($TMS_URL);
		//-----------------------------------------------------------------------
		//$value = $client->Sauver($params);
		$value = $client->Envoyer($params);


		if(isset($value->Code)){
				throw new Exception('<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Erreur '.$value->Code.'</strong>: '.$value->Erreur.'</div>');
		}
		else{
			//echo "<hr>";
			
			$ctvoidtms = $value->Lot->Demarche->DUP->ID;
			return $ctvoidtms;
			//echo "<hr>";
			//var_dump($params);
			//$sql = "INSERT INTO demande VALUES $post['']"
		}
		//var_dump($post);

	}

		
	public function sauverDCA($post){

		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);

		//---------------------------------Nouveau Titulaire----------------------------------------
		

		if($post['personne2'] == "phy"){
			if($post['sexe'] == "F"){
				$nomprenom = $_POST['NomUsage'].' '.$_POST['Prenom'];
				$PersonnePhysique = array("NomPrenom" => $nomprenom, "NomNaissance" => $post["Nom"], "Prenom" => $post['Prenom'], "Sexe" => $post['sexe'], "NomUsage" => $post['NomUsage'], "DateNaissance" => $post['DateNaissance'], "LieuNaissance" => $post["LieuNaissance"]);
			}
			else{
				$nomprenom = $_POST['Nom'].' '.$_POST['Prenom'];
				$PersonnePhysique = array("NomPrenom" => $nomprenom, "NomNaissance" => $post['Nom'], "Prenom" => $post['Prenom'], "Sexe" => $post['sexe'], "DateNaissance" => $post['DateNaissance'], "LieuNaissance" => $post["LieuNaissance"]);
			}
			
			$Adresse = array("Numero" => $post['Numero'], "TypeVoie" => $post['TypeVoie'], "NomVoie" => $post['NomVoie'], "CodePostal" => $post['CodePostal'], "Ville" => $post['Ville']);

			//----------------------------------AncienneAdresse-----------------------------------------

			$AncienneAdresse = array("Numero" => $post['Numero2'], "TypeVoie" => $post['TypeVoie2'], "NomVoie" => $post['NomVoie2'], "CodePostal" => $post['CodePostal2'], "Ville" => $post['Ville2']);

			$DroitOpposition = $post['DroitOpposition'];

			$Acquereur = array("PersonnePhysique" => $PersonnePhysique, "NouvelleAdresse" => $Adresse, "AncienneAdresse" => $AncienneAdresse, "DroitOpposition" => $DroitOpposition);
		}
		else{
			if($post['SocieteCommerciale'] == 1 ){
				$PersonneMorale = array("RaisonSociale" => $post["RaisonSociale2"], "SocieteCommerciale" => $post['SocieteCommerciale'], "SIREN" => $post["SIREN"]);
			}
			else{
				$PersonneMorale = array("RaisonSociale" => $post["RaisonSociale2"], "SocieteCommerciale" => $post['SocieteCommerciale']);
			}
			$Adresse = array("Numero" => $post['Numero'], "TypeVoie" => $post['TypeVoie'], "NomVoie" => $post['NomVoie'], "CodePostal" => $post['CodePostal'], "Ville" => $post['Ville']);

			//----------------------------------AncienneAdresse-----------------------------------------

			$AncienneAdresse = array("Numero" => $post['Numero2'], "TypeVoie" => $post['TypeVoie2'], "NomVoie" => $post['NomVoie2'], "CodePostal" => $post['CodePostal2'], "Ville" => $post['Ville2']);

			$DroitOpposition = $post['DroitOpposition'];

			$Acquereur = array("PersonneMorale" => $PersonneMorale, "NouvelleAdresse" => $Adresse, "AncienneAdresse" => $AncienneAdresse,  "DroitOpposition" => $DroitOpposition);	
		}





		//-----------------------------------Info Vehicule------------------------------------

		if($post["CIPresent"] == 1){
			$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "DateCI" => $post["DateCI"]);

			if( preg_match("/[0-9]{1,4} [A-Z]{1,4} [0-9]{1,2}/", $post['Immatriculation'])){
				//echo "<br>TEST FNI<br>";
				$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "DateCI" => $post["DateCI"]);
				//var_dump($Vehicule);
			}
			else{
				//echo "<br>TEST SIV<br>";
				$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 1, "NumFormule" => $post["NumFormule"]);
				//var_dump($Vehicule);
			}
		}
		else{

			$Vehicule = array("VIN" => $post['VIN'], "Immatriculation" => $post['Immatriculation'], "CIPresent" => 0);
		}

		//-------------------------------------------------------------------------------------------------

		$DateDemarche = date('Y-m-d H:i:s');

		$DCA = array("ID" => "", "TypeDemarche" => "DCA", "DateDemarche" => $DateDemarche, "Titulaire" => $Acquereur, "Vehicule" => $Vehicule);

		$Demarche = array("DCA" => $DCA);
		$Lot = array("Demarche" => $Demarche);


		$params = array("Identification"=>$Identification, "Lot" => $Lot);
		//$params = array_merge($params, $parameters);
		//var_dump($params);


		//-----------------------------------------------------------------------
		$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
		$client = new SoapClient($TMS_URL);
		//-----------------------------------------------------------------------
		//$value = $client->Sauver($params);
		$value = $client->Envoyer($params);
		//var_dump($value);


		if(isset($value->Code)){
				throw new Exception('<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Erreur '.$value->Code.'</strong>: '.$value->Erreur.'</div>');
		}
		else{
			//echo "<hr>";
			$dcaidtms = $value->Lot->Demarche->DCA->ID;
			return $dcaidtms;
			//echo "<hr>";
			//var_dump($params);
			//$sql = "INSERT INTO demande VALUES $post['']"
		}		

	}

	public function calculerECG($post){
		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);

		//-----------------------------------Info Vehicule------------------------------------

				$Vehicule = array("Immatriculation" => $post["Immatriculation"], "CO2" => $post["CO2"], "Puissance" => $post["Puissance"], "Genre" => $post['Genre'], "PTAC" => $post["PTAC"], "Energie" => $post["Energie"], "Departement" => $post["Departement"], "TypeVehicule" => $post["TypeVehicule"], "Collection" => $post["Collection"], "TypeAchat" => $post["TypeAchat"], "PremiereImmat" => $post["PremiereImmat"]);

		

		//-------------------------------------------------------------------------------------------------

		$DateDemarche = date('Y-m-d H:i:s');

		$ECG = array("ID" => "", "TypeDemarche" => "ECG", "DateDemarche" => $DateDemarche, "Vehicule" => $Vehicule);

		$Demarche = array("ECG" => $ECG);
		$Lot = array("Demarche" => $Demarche);


		$params = array("Identification"=>$Identification, "Lot" => $Lot);
		//$params = array_merge($params, $parameters);
		//var_dump($params);

		//-----------------------------------------------------------------------
		$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
		$client = new SoapClient($TMS_URL);
		//-----------------------------------------------------------------------
		//$value = $client->Sauver($params);
		$value = $client->Envoyer($params);
		//var_dump($value);


		if(isset($value->Code)){
				throw new Exception('<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Erreur '.$value->Code.'</strong>: '.$value->Erreur.'</div>');
		}
		else{
			//echo "<hr>";
			//$dcaidtms = $value->Lot->Demarche->ECG->ID;
			//var_dump($value->Lot->Demarche->ECG->Reponse->Positive);
				
				echo '<table class="table table-bordered table-striped mx-auto">';

				echo "<tr><th>Taxe Regionale</th><td>".$value->Lot->Demarche->ECG->Reponse->Positive->TaxeRegionale."€</td></tr>";
				echo "<tr><th>Taxe > 35CV</th><td>".$value->Lot->Demarche->ECG->Reponse->Positive->Taxe35cv."€</td></tr>";
				echo "<tr><th>Taxe Parafiscale</th><td>".$value->Lot->Demarche->ECG->Reponse->Positive->TaxeParafiscale."€</td></tr>";
				echo "<tr><th>Taxe CO2</th><td>".$value->Lot->Demarche->ECG->Reponse->Positive->TaxeCO2."€</td></tr>";
				echo "<tr><th>Taxe Malus</th><td>".$value->Lot->Demarche->ECG->Reponse->Positive->TaxeMalus."€</td></tr>";
				echo "<tr><th>Taxe SIV</th><td>".$value->Lot->Demarche->ECG->Reponse->Positive->TaxeSIV."€</td></tr>";
				echo "<tr><th>Taxe RedevanceSIV</th><td>".$value->Lot->Demarche->ECG->Reponse->Positive->TaxeRedevanceSIV."€</td></tr>";
				echo "<tr><th>Frais de traitement du dossier</th><td> Nos Prix </td></tr>";
				echo "<tr><th>Taxe Totale</th><td>".$value->Lot->Demarche->ECG->Reponse->Positive->TaxeTotale."€</td></tr>";

				echo '</table><br>';

		}	
		return $value->Lot->Demarche->ECG->Reponse->Positive->TaxeTotale;	

	}

	public function calculerECGAuto($post){
		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);

		//-----------------------------------Info Vehicule------------------------------------

				$Vehicule = array("Immatriculation" => $post["Immatriculation"], "Departement" => $post["Departement"]);

		

		//-------------------------------------------------------------------------------------------------

		$DateDemarche = date('Y-m-d H:i:s');

		$ECG = array("ID" => "", "TypeDemarche" => "ECGAUTO", "DateDemarche" => $DateDemarche, "Vehicule" => $Vehicule);

		$Demarche = array("ECGAUTO" => $ECG);
		$Lot = array("Demarche" => $Demarche);


		$params = array("Identification"=>$Identification, "Lot" => $Lot);
		//$params = array_merge($params, $parameters);
		//var_dump($params);

		//-----------------------------------------------------------------------
		$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
		$client = new SoapClient($TMS_URL);
		//-----------------------------------------------------------------------
		//$value = $client->Sauver($params);
		$value = $client->Envoyer($params);
		//var_dump($value);


		if($value->Code){
				throw new Exception('<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Erreur '.$value->Code.'</strong>: '.$value->Erreur.'</div>');
		}
		else{
			//echo "<hr>";
			//$dcaidtms = $value->Lot->Demarche->ECG->ID;
			//var_dump($value->Lot->Demarche->ECG->Reponse->Positive);
				
				echo '<table class="table table-bordered table-striped mx-auto">';

				echo "<tr><th>Taxe Regionale</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeRegionale."€</td></tr>";
				echo "<tr><th>Taxe > 35CV</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->Taxe35cv."€</td></tr>";
				echo "<tr><th>Taxe Parafiscale</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeParafiscale."€</td></tr>";
				echo "<tr><th>Taxe CO2</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeCO2."€</td></tr>";
				echo "<tr><th>Taxe Malus</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeMalus."€</td></tr>";
				echo "<tr><th>Taxe SIV</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeSIV."€</td></tr>";
				echo "<tr><th>Taxe RedevanceSIV</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeRedevanceSIV."€</td></tr>";
				echo "<tr><th>Frais de traitement du dossier</th><td> Nos Prix </td></tr>";
				echo "<tr><th>Taxe Totale</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeTotale."€</td></tr>";

				echo '</table><br>';

				echo '<table class="table table-bordered table-striped mx-auto">';

				echo "<tr><th>Immatriculation</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->VIN."</td></tr>";
				echo "<tr><th>CO2</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->CO2."</td></tr>";
				echo "<tr><th>Genre</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->Genre."</td></tr>";
				echo "<tr><th>PTAC</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->PTAC."</td></tr>";
				echo "<tr><th>Energie</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->Energie."</td></tr>";
				echo "<tr><th>Date de mise en ciruclation</th><td>".$value->Lot->Demarche->ECGAUTO->Reponse->Positive->DateMEC."</td></tr>";

				echo '</table><br>';

		}	
		return $value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeTotale;	

	}


	public function test(){
		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);

		$params = array("Identification"=>$Identification, 'Type' => $type, "Demarche"=>$demarche, );


		//-----------------------------------------------------------------------
		$TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
		$client = new SoapClient($TMS_URL);
		//-----------------------------------------------------------------------

		$url = 'http://test.misiv.intra.misiv.fr/interface.php?v=2&'.$this->TMS_CodeTMS;
	}

}


?>

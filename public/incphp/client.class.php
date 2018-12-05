<?php

class client
{
	public $TMS_CodeTMS = "31-000100";
	public $TMS_Login = "JE@n-Y100";
	public $TMS_Password = "GY-31@mLA";

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
	public function editer($type, $demarche){
		$Identification = $this->Ident($this->TMS_CodeTMS,$this->TMS_Login,$this->TMS_Password);

		$params = array("Identification"=>$Identification, 'Type' => $type, "Demarche"=>$demarche, );


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
			var_dump($value);
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


		$DC = array("ID" => "", "TypeDemarche" => "DC", "DateCession" => $post["DateAchat"], "DateDemarche" => $post["DateDemarche"], "Titulaire" => $Titulaire, "Acquereur" => $Acquereur, "Vehicule" => $Vehicule);

		$Demarche = array("DC" => $DC);
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
		$value = $client->Sauver($params);


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
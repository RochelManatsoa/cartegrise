<?php

include('client.class.php');
$client = new Client();

if(isset($_POST)){

	$client->calculerECG($_POST);
}


}
else{
	echo "Veuillez remplir les informations correctement";
}

?>
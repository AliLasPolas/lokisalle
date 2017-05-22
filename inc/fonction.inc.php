<?php 

/*---------- FONCTIONS MEMBRES ----------*/
function executeRequete($req){
	global $mysqli; // Permet d'avoir accès a la variable $mysqli définie dans l'espace global a l'interieur de notre fonction (espace local)
	$resultat = $mysqli->query($req); // On execute la requete recue en argument
	if (!$resultat) {
		die("Erreur sur la requete sql.<br> Message : " . $mysqli->error . "<br>Code : " . $req); // Si la requete échoue, on va décéder (die) avec le message d'erreur 
	}
	return $resultat; // On retourne un objet issu de la classe mysqli_result (en cas de requete SELECT, autre requete : true ou false) 
}

//--------------------------------------
// debug($_POST);
function debug($var, $mode = 1){
	echo "<div style='background: orange; padding: 5px; float: right; clear: both;'>";
	$trace = debug_backtrace(); // Fonction prédéfinie retournant un tableau ARRAY contenant des infos tel que la ligne et le fichier ou est exécuté la fonction
	$trace = array_shift($trace); // Extrait le première valeur d'un tableau et la retourne
	echo "Debug demandé dans le fichier : $trace(file) a la ligne $trace[line] . <hr>";
	if ($mode == 1) {
		echo "<pre>"; print_r($var); echo "</pre>";
	}
	else{
		echo "<pre>";var_dump($var); echo "</pre";
	}
	echo "</div>";
}


//---------------------------------------
function internauteEstConnecte(){ // Cette fonction m'indique si le membre est connecté. (une fonction retourne toujours false par défaut)
	if (!isset($_SESSION['membre'])) { // Si la session membre est non définie (elle ne peux etre que définie si nous sommes passés par la page de connexion avec le bon mdp)
		return false;
	}
	else{
		return true;
	}
}

//-----------------------------------
function InternauteEstAdmin(){ // Cette fonction m'indique si le membre est admin
	if (internauteEstConnecte() && $_SESSION['membre']['statut'] == 1) {// Si la session membre est définie, nous regardons si il est admin, c'est le cas, nous retournons true
		return true;
	}
	return false;
}


 ?>
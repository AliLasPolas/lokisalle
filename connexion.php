<?php require_once("haut.inc.php") ?>

<?php 

if ($_POST) {
	$resultat = executeRequete("SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]' ");
	if ($resultat->num_rows != 0) {
		$membre = $resultat->fetch_assoc();
		if ($membre['mdp'] == $_POST['mdp']) {
			foreach ($membre as $indice => $element) {
				if ($indice != 'mdp') {
					$_SESSION['membre'][$indice] = $element; 
				}
			}
		}
		else{
		$contenu .= 'Erreur de Mot de Passe';
		}
	}
	else{
		$contenu .= 'Erreur de Pseudo';
	}
echo "$contenu";
}

 ?>

<h1>Connexion</h1>
<form>
	<label for="pseudo">Pseudo</label>
	<input type="text" name="pseudo">

	<label for="mdp">Mot de passe</label>
	<input type="password" name="mdp" id="mdp">
</form>

<?php require_once("bas.inc.php") ?>
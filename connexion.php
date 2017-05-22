<?php require_once("inc/haut.inc.php") ?>

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
		header("location:profil.php");
		}
		else{
		$contenu .= 'Erreur de Mot de Passe';
		}
	}
	else{
		$contenu .= 'Erreur de Pseudo';
	}
echo "$contenu";
debug($_SESSION);
}

 ?>

<h1>Connexion</h1>
<form method="post">
	<label for="pseudo">Pseudo</label><br>
	<input type="text" name="pseudo"><br><br>

	<label for="mdp">Mot de passe</label><br>
	<input type="password" name="mdp" id="mdp"><br><br>

	<input type="submit" name="envoi"><br>
</form>

<?php require_once("inc/bas.inc.php") ?>
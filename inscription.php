<?php require_once("inc/haut.inc.php") ?>

<?php 
if ($_POST) {
	$erreur = "";
	if (strlen($_POST['pseudo']) <= 3 || strlen($_POST['pseudo']) > 20) {
		$erreur .= '<div class="erreur">Erreur taille du pseudo</div>';
	}
	if (!preg_match('#^[a-zA-Z0-9-_.]+$#', $_POST['pseudo'])) {
		$erreur .= 'Erreur format/caractère pseudo';
	}

	$result = executeRequete("SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]'"); 
	if ($result->num_rows >= 1) {
		$erreur .= 'Pseudo indisponible !';
	}
	if (empty($erreur)) {
		executeRequete("
			INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite)
			VALUES(
			'$_POST[pseudo]',
			'$_POST[mdp]',
			'$_POST[nom]',
			'$_POST[prenom]',
			'$_POST[email]',
			'$_POST[civilite]'
			)
			");
		$contenu .= "Inscription réussie. Vous pouvez désormais vous connecter";
	}
	$contenu .= $erreur;
}
 ?>

<h1>S'inscrire</h1>
<form method="post"> 
	<label for="pseudo">Pseudonyme</label><br>
	<input type="text" name="pseudo" id="pseudo"><br><br>
	<label for="mdp">Mot de passe</label><br>
	<input type="password" name="mdp" id="mdp"><br><br>
	<label for="nom">Nom</label><br>
	<input type="text" name="nom" id="nom"><br><br>
	<label for="prenom">Prénom</label><br>
	<input type="text" name="prenom" id="prenom"><br><br>
	<label for="email">Courriel</label><br>
	<input type="email" name="email" id="email"><br><br>
	<select name="civilite">
		<option value="f">Femme</option>
		<option value="h">Homme</option>
		<option value="a">Autre</option>
	</select><br><br>
	<input type="submit" name="inscription">
</form>

<?php echo $contenu ?>

<?php require_once("inc/bas.inc.php") ?>
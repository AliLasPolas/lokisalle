<?php require_once("haut.inc.php") ?>

<?php 
if ($_POST) {
	$erreur = "";
	if (strlen($_POST['pseudo']) <= 3 || strlen($_POST['pseudo']) > 20) {
		$erreur .= '<div class="erreur">Erreur taille du pseudo</div>';
	}
	if (!preg_match('#^[a-zA-Z0-9-_.]+$#', $_POST['pseudo'])) {
		$erreur .= '<div class="erreur">Erreur format/caractère pseudo</div>';
	}

	$result = executeRequete("SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]'"); 
	if ($result->num_rows >= 1) {
		$erreur .= '<div class="erreur">Pseudo indisponible !</div>';
	}
	if (empty($erreur)) {
		executeRequete("
			INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse)
			VALUES(
			'$_POST[pseudo]',
			'$_POST[mdp]',
			'$_POST[nom]',
			'$_POST[prenom]',
			'$_POST[email]',
			'$_POST[civilite]',
			'$_POST[ville]',
			'$_POST[code_postal]',
			'$_POST[adresse]'
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
	<label for="mdp">Mot de passe</label>
	<input type="password" name="mdp" id="mdp">
	<label for="nom">Nom</label>
	<input type="text" name="nom" id="nom">
	<label for="prenom">Prénom</label>
	<input type="text" name="prenom" id="prenom">
	<label for="email">Courriel</label>
	<input type="email" name="email" id="email">
	<select name="sexe">
		<option value="f">Femme</option>
		<option value="h">Homme</option>
		<option value="a">Autre</option>
	</select>
</form>

<?php require_once("bas.inc.php") ?>
<?php require_once("../inc/haut.inc.php");
$resultat = executeRequete("SELECT * FROM membre");
$contenu .= "Nombre de membres inscrits : " . $resultat->num_rows;
$contenu .= '<table border ="1" cellpadding="3"><tr>';
	while ($colonne = $resultat->fetch_field()) {
		if ($colonne->name != 'mdp') {
		$contenu .= '<th>' . $colonne->name . '</th>';
		}
	}
	$contenu .= '<th>Modification</th>';
	$contenu .= '<th>Suppression</th>';
	$contenu .= '</tr>';
	while ($ligne = $resultat->fetch_assoc()) {
		$contenu .= '<tr>';
		foreach ($ligne as $indice => $information) {
				if ($indice != "mdp") {
				$contenu .= '<td>' . $information . '</td>';
				}
		}
		$contenu .= '<td><a href="?action=modification&id_membre=' . $ligne['id_membre'] . '"><img src="../inc/img/edit.png"></a></td>';
		$contenu .= '<td><a href="?action=suppression&id_membre=' . $ligne['id_membre'] . '" OnClick="return(confirm(\'En etes vous bien certain ?\'));"><img src="../inc/img/delete.png"></a></td>';
		$contenu .= '</tr>';
	}
	$contenu .= '</table>';
	if (isset($_GET['action']) ) {
		if ($_GET['action'] == 'suppression') {
			executeRequete("DELETE FROM membre WHERE id_membre = '$_GET[id_membre]' ");
		}
	}
	if ($_POST) {
	executeRequete("
	UPDATE membre SET 
	pseudo = '$_POST[pseudo]', 
	nom = '$_POST[nom]', 
	prenom = '$_POST[prenom]', 
	email = '$_POST[email]', 
	civilite = '$_POST[civilite]', 
	date_enregistrement = '$_POST[date]'
	WHERE id_membre = '$_GET[id_membre]' ");
	$contenu .= 'Le membre a bien été mis a jour';
	}
	if (isset($_GET['action']) && $_GET['action'] == 'modification' ){
	$resultat = executeRequete("SELECT * FROM membre WHERE id_membre = '$_GET[id_membre]'");
	$membre_actuel = $resultat->fetch_assoc();
	$id_membre = (isset($membre_actuel['id_membre'])) ? $membre_actuel['id_membre'] : '';
	$pseudo = (isset($membre_actuel['pseudo'])) ? $membre_actuel['pseudo'] : '';
	$nom = (isset($membre_actuel['nom'])) ? $membre_actuel['nom'] : '';
	$prenom = (isset($membre_actuel['prenom'])) ? $membre_actuel['prenom'] : '';
	$email = (isset($membre_actuel['email'])) ? $membre_actuel['email'] : '';
	$civilite = (isset($membre_actuel['civilite'])) ? $membre_actuel['civilite'] : '';
	$date_enregistrement = (isset($membre_actuel['date_enregistrement'])) ? $membre_actuel['date_enregistrement'] : '';
	echo '<form method="post" action="">
	<label for="pseudo">Pseudo</label><br>
	<input type="text" value="' . $pseudo . '" name="pseudo" id="pseudo" maxlength="20" placeholder="Pseudo" pattern="[a-zA-z0-9-_.]{3,20}" title="caractère acceptés : a-zA-Z0-9-_." required=""><br><br>
	<label for="nom">Nom</label><br>
	<input type="text" name="nom" value="' . $nom . '" id="nom" placeholder="Nom"><br><br>
	<label for="prenom">Prénom</label><br>
	<input type="text" name="prenom" value="' . $prenom . '" id="prenom" placeholder="Prenom"><br><br>
	<label for="email">E-Mail</label><br>
	<input type="email" name="email" value="' . $email . '" id="email" placeholder="exemple@gmail.com"><br><br>
	<label for="date_enregistrement">Date d\'enregistrement</label><br>
	<input type="date" name="date" value="' . $date_enregistrement . '" id="date" placeholder=""><br><br>
	<label for="civilite">Civilité</label><br>
	<input type="radio" name="civilite" id="civilite" value="m" ';if ($civilite == 'm') {echo "checked";} echo' > Homme
	<input type="radio" name="civilite" id="civilite" value="f" ';if ($civilite == 'f') {echo "checked";} echo' > Femme
	<br><br>
	<input type="submit" name="modifierMembre" value="Mettre a Jour">
</form>' ;
}
	echo $contenu;
?>

<?php require_once("../inc/bas.inc.php"); ?>

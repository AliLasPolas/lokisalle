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
		debug($_POST);
		executeRequete("
			REPLACE INTO membre (id_membre, pseudo, mdp, nom, prenom, email, civilite, date_enregistrement, statut)
			VALUES(
			'$_GET[id_membre]',
			'$_POST[pseudo]',
			'$_POST[mdp]',
			'$_POST[nom]',
			'$_POST[prenom]',
			'$_POST[email]',
			'$_POST[civilite]',
			'$_POST[date_enregistrement]',
			'$_POST[statut]'
			)
			");
		$contenu .= 'Le membre a bien été mis a jour';
		}
	if (isset($_GET['action']) && $_GET['action'] == 'modification' ){
		$resultat = executeRequete("SELECT * FROM membre WHERE id_membre = '$_GET[id_membre]'");
	}
	$membre_actuel = $resultat->fetch_assoc();
	$id_membre = (isset($membre_actuel['id_membre'])) ? $membre_actuel['id_membre'] : '';
	$pseudo = (isset($membre_actuel['pseudo'])) ? $membre_actuel['pseudo'] : '';
	$nom = (isset($membre_actuel['nom'])) ? $membre_actuel['nom'] : '';
	$mdp = (isset($membre_actuel['mdp'])) ? $membre_actuel['mdp'] : '';
	$prenom = (isset($membre_actuel['prenom'])) ? $membre_actuel['prenom'] : '';
	$email = (isset($membre_actuel['email'])) ? $membre_actuel['email'] : '';
	$civilite = (isset($membre_actuel['civilite'])) ? $membre_actuel['civilite'] : '';
	$date_enregistrement = (isset($membre_actuel['date_enregistrement'])) ? $membre_actuel['date_enregistrement'] : '';
	$statut = (isset($membre_actuel['statut'])) ? $membre_actuel['statut'] : '';
	echo '<form method="post" action="">
		<label for="pseudo">Pseudo</label><br>
		<input type="hidden" value="' . $id_membre . '" name="id_membre">
		<input type="text" value="' . $pseudo . '" name="pseudo" id="pseudo" maxlength="20" placeholder="Pseudo" pattern="[a-zA-z0-9-_.]{3,20}" title="caractère acceptés : a-zA-Z0-9-_." required=""><br><br>
		<label for="nom">Nom</label><br>
		<input type="text" name="nom" value="' . $nom . '" id="nom" placeholder="Nom"><br><br>
		<label for="mdp">Mot de passe</label><br>
		<input type="password" name="mdp" value="' . $mdp . '" id="mdp" placeholder="Mot de passe"><br><br>
		<label for="prenom">Prénom</label><br>
		<input type="text" name="prenom" value="' . $prenom . '" id="prenom" placeholder="Prenom"><br><br>
		<label for="email">E-Mail</label><br>
		<input type="email" name="email" value="' . $email . '" id="email" placeholder="exemple@gmail.com"><br><br>
		<label for="date_enregistrement">Date d\'enregistrement</label><br>
		<input type="date" name="date_enregistrement" value="' . $date_enregistrement . '" id="date" placeholder=""><br><br>
		<label for="civilite">Civilité</label><br>
		<input type="radio" name="civilite" id="civilite" value="m" ';if ($civilite == 'm') {echo "checked";} echo' > Homme
		<input type="radio" name="civilite" id="civilite" value="f" ';if ($civilite == 'f') {echo "checked";} echo' > Femme
		<br><br>


		<label for="statut">Status</label><br>
		<select name="statut" id="statut" >		
			<option value="0" ';if ($statut == '0') {echo "selected";} echo' > Membre
			<option value="1" ';if ($statut == '1') {echo "selected";} echo' > Admin
		</select>
		<br><br>

		<input type="submit" name="modifierMembre" value="Mettre a Jour">
	</form>';
echo $contenu;
?>

<?php require_once("../inc/bas.inc.php"); ?>

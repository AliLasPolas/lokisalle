<?php require_once("../inc/haut.inc.php") ?>

<?php 



	$resultat = executeRequete("SELECT * FROM salle");

	$contenu .= '<h2>Affichage des salles</h2>';
	$contenu .= 'Nombre de produits dans la boutique : ' . $resultat->num_rows;
	$contenu .= '<table border ="1" cellpadding="5"><tr>';

	while ($colonne = $resultat->fetch_field()) {
		$contenu .= '<th>' . $colonne->name . '</th>';
	}
	$contenu .= '<th>Voir/Modifier/Supprimer</th>';
	$contenu .= '</tr>';

	while ($ligne = $resultat->fetch_assoc()) {
		$contenu .= '<tr>';
		foreach ($ligne as $indice => $information) {
			if ($indice == "photo") {
				$contenu .= '<td><img src="' . $information . '" width="70" height="70"></td>';
			}
			else{
				$contenu .= '<td>' . $information . '</td>';
			}
		}
		$contenu .= '<td><a href="?action=voir&id_salle=' . $ligne['id_salle'] . '"><img src="../inc/img/view.png"></a> <a href="?action=modification&id_salle=' . $ligne['id_salle'] . '"><img src="../inc/img/edit.png"></a> <a href="?action=suppression&id_salle=' . $ligne['id_salle'] . '" OnClick="return(confirm(\'En etes vous bien certain ?\'));"><img src="../inc/img/delete.png"></a></td>';
		$contenu .= '</tr>';
	}
	$contenu .= '</table><br><hr><br>';

	if (!isset($_GET['action'])) {
		
	}

	if (isset($_GET['action']) && $_GET['action'] == "voir" ) {
		$contenu .= "<br><h3>Détails de la salle" . $_GET['id_salle'] . "</h3>";
		$resultat = executeRequete("SELECT * FROM produit WHERE id_salle = ". $_GET['id_salle']." ");
		$contenu .= '<table border ="1" cellpadding="3"><tr>';
		while ($colonne = $resultat->fetch_field()) {
		$contenu .= '<th>' . $colonne->name . '</th>';
		}
		$contenu .= '<th> Voir la fiche </th>';
		$contenu .= '</tr>';

		while ($ligne = $resultat->fetch_assoc()) {
			$contenu .= '<tr>';
			foreach ($ligne as $indice => $information) {
				$contenu .= '<td>' . $information . '</td>';

			}
			$contenu .= '<td> <a href="?action=voir&id_salle=' . $ligne['id_salle'] . '"><img src="../inc/img/view.png"></a>';
			$contenu .= '</tr>';
		}
		$contenu .= '</table>';
	}

	echo $contenu;




	if ($_POST) {
		$photo_bdd = "";
		if (isset($_GET['action']) && $_GET['action'] == 'modification') {
			$photo_bdd = $_POST['photo_actuelle'];
		}
		if (!empty($_FILES['photo']['name'])) {
			$nom_photo = $_POST['titre'] . '-' . $_FILES['photo']['name'];
			$photo_bdd = URL . "inc/img/$nom_photo"; 
			$photo_dossier = RACINE_SITE . "inc/img/$nom_photo";
			copy($_FILES['photo']['tmp_name'], $photo_dossier);
		}
		foreach ($_POST as $indice => $valeur) {
			$_POST[$indice] = htmlEntities(addSlashes($valeur));
		}
		debug($photo_bdd);
		debug($nom_photo);
		debug($photo_dossier);
		executeRequete("
			REPLACE INTO salle (id_salle, titre, description, photo, pays, ville, adresse, cp, capacite, categorie)
			VALUES(
			'$_POST[id_salle]',
			'$_POST[titre]',
			'$_POST[description]',
			'$photo_bdd',
			'$_POST[pays]',
			'$_POST[ville]',
			'$_POST[adresse]',
			'$_POST[cp]',
			'$_POST[capacite]',
			'$_POST[categorie]'
			)
			");
		$contenu .= 'La base salle a bien été mis a jour';
		}

	if (isset($_GET['action']) ) {
		if ($_GET['action'] == 'suppression') {
			executeRequete("DELETE FROM salle WHERE id_salle = '$_GET[id_salle]' ");
		}
	}

	if (isset($_GET['action']) && $_GET['action'] == "modification" ) {
			$resultat = executeRequete("SELECT * FROM salle WHERE id_salle = '$_GET[id_salle]'");
	}
		$salle_actuelle = $resultat->fetch_assoc();
		debug($salle_actuelle);
		$id_salle = (isset($salle_actuelle['id_salle'])) ? $salle_actuelle['id_salle'] : '';
		$titre = (isset($salle_actuelle['titre'])) ? $salle_actuelle['titre'] : '';
		$description = (isset($salle_actuelle['description'])) ? $salle_actuelle['description'] : '';
		$photo = (isset($salle_actuelle['photo'])) ? $salle_actuelle['photo'] : '';
		$pays = (isset($salle_actuelle['pays'])) ? $salle_actuelle['pays'] : '';
		$ville = (isset($salle_actuelle['ville'])) ? $salle_actuelle['ville'] : '';
		$adresse = (isset($salle_actuelle['adresse'])) ? $salle_actuelle['adresse'] : '';
		$cp = (isset($salle_actuelle['cp'])) ? $salle_actuelle['cp'] : '';
		$capacite = (isset($salle_actuelle['capacite'])) ? $salle_actuelle['capacite'] : '';
		$categorie = (isset($salle_actuelle['categorie'])) ? $salle_actuelle['categorie'] : '';
		echo '<form method="post" enctype="multipart/form-data" action="">

			<label for="titre">Titre</label><br>
			<input type="text" name="titre" value="' . $titre . '" id="titre" placeholder="Titre"><br><br>
			<input type="hidden" name="id_salle" value="' . $id_salle . '>

			<label for="descripton">Description</label><br>
			<textarea name="description" id="description" placeholder="description">' . $description . '</textarea><br><br>

			<label for="photo">Photo</label><br>
			<input type="file" name="photo" id="photo"><br><br>
			<input type="hidden" name="photo_actuelle" id="photo_actuelle" value="' . $photo . '"><br>

			
			<label for="pays">Pays</label><br>
			<input type="text" name="pays" value="' . $pays . '" id="pays" placeholder="Pays"><br><br>

			<label for="Ville">Ville</label><br>
			<input type="text" name="ville" value="' . $ville . '" id="ville" placeholder="Ville"><br><br>

			<label for="adresse">Adresse</label><br>
			<input type="text" name="adresse" value="' . $adresse . '" id="adresse" placeholder="Adresse"><br><br>
			
			<label for="cp">Code Postal</label><br>
			<input type="number" name="cp" value="' . $cp . '" id="cp" placeholder="Code postal"><br><br>
			
			<label for="capacite">Capacité d\'accueil</label><br>
			<input type="text" name="capacite" value="' . $capacite . '" id="capacite" placeholder="Capacité"><br><br>
			
			<label for="categorie">Cagégorie</label><br>
			<select name="categorie"> 
				<option value="formation" '; if ($categorie == "formation") {
					echo "selected";
				} echo '>Formation</option>
				<option value="reunion"'; if ($categorie == "reunion") {
					echo "selected";
				} echo '>Reunion</option>
				<option value="bureau"'; if ($categorie == "bureau") {
					echo "selected";
				} echo '>Bureau</option>
			</select><br><br>

			<input type="submit" name="modifier" value="Mettre a Jour">
		</form>' ;


 ?>

<?php require_once("../inc/bas.inc.php") ?>
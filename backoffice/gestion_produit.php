<?php require_once("../inc/haut.inc.php");


	$resultat = executeRequete("SELECT * FROM produit");

	$contenu .= '<h2>Affichage des produits</h2>';
	$contenu .= 'Nombre de produits dans la boutique : ' . $resultat->num_rows;
	$contenu .= '<table border ="1" cellpadding="5"><tr>';

	while ($colonne = $resultat->fetch_field()) {
		$contenu .= '<th>' . $colonne->name . '</th>';
	}
	$contenu .= '<th>Voir</th>';
	$contenu .= '<th>Modification</th>';
	$contenu .= '<th>Suppression</th>';
	$contenu .= '</tr>';

	while ($ligne = $resultat->fetch_assoc()) {
		$contenu .= '<tr>';
		foreach ($ligne as $indice => $information) {
			if ($indice == "id_salle") {
				$photo = executeRequete("SELECT photo FROM salle WHERE id_salle = " . $information . " ");
				$photo = $photo->fetch_assoc();
				$photo = $photo['photo'];
				$contenu .= '<td>' . $information . '<br><img src="' . $photo . '" width="70" height="70"></td>';
			}
			else{
				$contenu .= '<td>' . $information . '</td>';
			}
		}
		$contenu .= '<td><a href="?action=voir&id_produit=' . $ligne['id_produit'] . '"><img src="../inc/img/view.png"></a></td>';
		$contenu .= '<td><a href="?action=modification&id_produit=' . $ligne['id_produit'] . '"><img src="../inc/img/edit.png"></a></td>';
		$contenu .= '<td><a href="?action=suppression&id_produit=' . $ligne['id_produit'] . '" OnClick="return(confirm(\'En etes vous bien certain ?\'));"><img src="../inc/img/delete.png"></a></td>';
		$contenu .= '</tr>';
	}
	$contenu .= '</table><br><hr><br>';
echo $contenu;

	if ($_POST) {
			executeRequete("
			REPLACE INTO produit (id_salle, date_arrivee, date_depart, prix)
			VALUES(
			'$_POST[id_salle]',
			'$_POST[date_arrivee]',
			'$_POST[date_depart]',
			'$_POST[prix]'
			)
			");
		$contenu .= 'Le produit a bien été mis a jour';

	}

	if (isset($_GET['action']) && $_GET['action'] == 'modification' ){
		$resultat = executeRequete("SELECT * FROM produit WHERE id_produit = '$_GET[id_produit]'");
	}
	$produit_actuel = $resultat->fetch_assoc();
	$id_produit = (isset($produit_actuel['id_produit'])) ? $produit_actuel['id_produit'] : '';
	$id_salle = (isset($produit_actuel['id_salle'])) ? $produit_actuel['id_salle'] : '';
	$date_arrivee = (isset($produit_actuel['date_arrivee'])) ? $produit_actuel['date_arrivee'] : '';
	$date_depart = (isset($produit_actuel['date_depart'])) ? $produit_actuel['date_depart'] : '';
	$prix = (isset($produit_actuel['prix'])) ? $produit_actuel['prix'] : '';
	$etat = (isset($produit_actuel['etat'])) ? $produit_actuel['etat'] : '';

	echo '<form method="post" action="">
		<input type="hidden" value="' . $id_produit . '" name="id_membre">
		<input type="hidden" value="' . $id_salle . '" name="id_salle">
		<label for="date_arrivee">Date arrivée</label><br>
		<input type="date" value="' . $date_arrivee . '" name="date_arrivee" id="date_arrivee"><br><br>
		<label for="date_depart">Date départ</label><br>
		<input type="date" name="date_depart" value="' . $date_depart . '" id="date_depart"><br><br>
		<label for="prix">Prix</label><br>
		<input type="number" name="prix" value="' . $prix . '" id="prix" placeholder="Tarif"><br><br>

		<select name="id_salle">';
		$resultat = executeRequete("SELECT * FROM salle ");
		while ($ligne = $resultat->fetch_assoc()) {
				echo "<option value=" . $ligne['id_salle'] . "> Salle de $ligne[categorie] $ligne[titre] - $ligne[adresse] $ligne[cp] $ligne[ville] - Capacité $ligne[capacite] personnes</option>";
		}
		echo '</select>
		<input type="submit" name="modifierMembre" value="Mettre a Jour">
	</form>';



?>

<?php 
require_once("../inc/bas.inc.php") ?>
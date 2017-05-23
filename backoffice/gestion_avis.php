<?php require_once("../inc/haut.inc.php") ?>
<?php 

$resultat = executeRequete("SELECT * FROM avis");
$contenu .= "Nombre d'avis inscrits : " . $resultat->num_rows;
$contenu .= '<table border ="1" cellpadding="3"><tr>';
	while ($colonne = $resultat->fetch_field()) {
		if ($colonne->name != 'mdp') {
		$contenu .= '<th>' . $colonne->name . '</th>';
		}
	}
	$contenu .= '<th>Suppression</th>';
	$contenu .= '</tr>';
	while ($ligne = $resultat->fetch_assoc()) {
		$contenu .= '<tr>';
		foreach ($ligne as $indice => $information) {
				$contenu .= '<td>' . $information . '</td>';
		}
		$contenu .= '<td><a href="?action=suppression&id_avis=' . $ligne['id_avis'] . '" OnClick="return(confirm(\'En etes vous bien certain ?\'));"><img src="../inc/img/delete.png"></a></td>';
		$contenu .= '</tr>';
	}
	$contenu .= '</table>';

	if (isset($_GET['action']) && $_GET['action'] == 'suppression') {
		executeRequete("DELETE FROM avis WHERE id_avis =' $_GET[id_avis] ' ");
	}

	echo $contenu;

 ?>
<?php require_once("../inc/bas.inc.php") ?>
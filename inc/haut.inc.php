<?php 
require_once("init.inc.php");

// debug($_SESSION);

 ?>

 <!DOCTYPE html>
<html>
<head>
	<title>Inscription</title>
	<link rel="stylesheet" type="text/css" href="/lokisalle/inc/css/style.css">
	<style type="text/css">
		body{
			height: 100vh;
			width: 100vw;
			background-color: #ddd;
		}
		ul{
			width: 100vw;
			height: 50px;
			background-color: grey;
		}
		li{
			width: 10%;
			height: : 50px;
			list-style-type: none;
			display: inline-block;

		}
		a{
			width: 100%;
			height: 50%;
			text-decoration: none;
			color: white;
		}
		a:hover{
			background-color: blue;
		}
	</style>
</head>
<body>
<header>
	<ul>
	<?php 
		echo '<li><a href="acceuil.php">Accueil</a></li>';
		if (isset($_SESSION) && !empty($_SESSION)) {
			echo '<li><a href="/lokisalle/profil.php">Profil</a></li>';
		}
		else{
			echo '<li><a href="/lokisalle/inscription.php">Inscription</a></li>';
		}
		echo '<li><a href="/lokisalle/boutique.php">Boutique</a></li>';
		if (isset($_SESSION) && !empty($_SESSION)) {
		echo '<li><a href="/lokisalle/connexion.php?action=deconnexion">Se deconnecter</a></li>';
		}
		else{
		echo '<li><a href="/lokisalle/connexion.php">Se connecter</a></li>';
		}
		if (isset($_SESSION['membre']) ) {
			if ($_SESSION['membre']['statut'] == 1) {
				echo '<li><a href="/lokisalle/backoffice/gestion_salle.php">Gestion salles</a></li>';
				echo '<li><a href="/lokisalle/backoffice/gestion_produits.php">Gestion produits</a></li>';
				echo '<li><a href="/lokisalle/backoffice/gestion_avis.php">Gestion avis</a></li>';
				echo '<li><a href="/lokisalle/backoffice/gestion_membres.php">Gestion membres</a></li>';
				echo '<li><a href="/lokisalle/backoffice/gestion_commandes.php">Gestion commandes</a></li>';
				echo '<li><a href="/lokisalle/backoffice/statistiques.php">Statistiques</a></li>';
			}
		}
	?>
	</ul>
</header>
<section class="main">
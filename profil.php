<?php
require_once("inc/haut.inc.php");

// si le membre n'est pas connect� , il ne doit pas avoir acc�s � la page profil.
if(!internauteEstConnecte()){
	header("location:connexion.php");
}


?>

<?php
debug($_SESSION);// D�s lors que la "session_start" est inscrite,les sessions sont disponibles sur toutes les pages du site*/




// Exercice : Afficher sur la page profil , le pseudo , email,ville,code postal,adresse du membre connect� en passant par le fichier $_SESSION

// Pour afficher le contenu des tableaux , on cr�� une variable de r�ception pour contenir toutes les informations et pouvoir les afficher
$contenu.="<p class ='centre'>Bonjour <strong>".$_SESSION['membre']['pseudo']." </strong></p><br>";
//echo $contenu;
$contenu.="<div class='cadre'><h2>Voici les informations de votre profil</h2><br>";
//$contenu .='<p> Votre id membre est : '.$_SESSION['membre']['id_membre'].'<p><br>';
$contenu.='<p> Votre pseudo est : '.$_SESSION['membre']['pseudo'].'<p><br>';
$contenu.='<p> Votre nom est : '.$_SESSION['membre']['nom'].'<p><br>';
$contenu.='<p> Votre prenom est :  '.$_SESSION['membre']['prenom'].'<p><br>';
$contenu.='<p> Votre mail  est :  '.$_SESSION['membre']['email'].'<p><br>';
$contenu.='<p> Votre statut est :  '.$_SESSION['membre']['civilite'].'<p><br>';
if($_SESSION['membre']['statut'] == 0 ){$contenu .= "Vous êtes membre <br>";}
if($_SESSION['membre']['statut'] == 1 ){$contenu .= "Vous êtes admin <br>";}

$contenu.='<p> Vous vous êtes enregistré le  : '.$_SESSION['membre']['date_enregistrement'].'<p><br>';



echo $contenu;
echo "<h2> Suivi des commandes</h2>";
$suivi_des_commandes = executeRequete("SELECT * FROM commande WHERE id_membre = '" .$_SESSION['membre']['id_membre']."'");

if ($suivi_des_commandes->num_rows>0)
{
    while ($commande = $suivi_des_commandes->fectch_assoc())
    {
        echo "Votre commande n°".$commande['id_commande']."est actuellement".$commande['etat']."<br><br>";
    }

}
else
{
echo "Aucune commande en cours";
}
echo "<br>";
echo "<div";
echo "<div class='conteneur'><h2>Vos actions possibles</h2>";
echo'<a href="profil.php?action=modifier">Modifier votre compte</a>';
echo'<a href="profil.php?action=supprimer" onclick="return(confirm(\'Êtes vous sûr de vouloir supprimer votre compte?\'))">Supprimer votre compte </a>';
echo "</div>";

	if ($_POST) {
	executeRequete("
	UPDATE membre SET 
	pseudo = '$_POST[pseudo]', 
	nom = '$_POST[nom]', 
	prenom = '$_POST[prenom]', 
	email = '$_POST[email]', 
	civilite = '$_POST[civilite]', 
	date_enregistrement = '$_POST[date]'
	WHERE id_membre = ' " . $_SESSION['membre']['id_membre'] . " ' ");
	$contenu .= 'Le membre a bien été mis a jour';
	}

	if (isset($_GET['action']) && $_GET['action'] == 'modifier' ){
	$resultat = executeRequete("SELECT * FROM membre WHERE id_membre = " . $_SESSION['membre']['id_membre'] . "");
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

if(isset($_GET['action'])&& $_GET['action'] == 'supprimer')
{
    executeRequete("DELETE FROM membre WHERE id_membre='".$_SESSION['membre']['id_membre']."'");
    unset($_SESSION['membre']['id_membre']);
    header("location:connexion.php?action=deconnexion");//on renvoi l'utilisateur sur la page connexion.php et on le déconnecte de la même manière
}


?>

<?php
// BAS DE PAGE
require_once("inc/bas.inc.php");

?>

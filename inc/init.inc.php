<?php 

$mysqli = new Mysqli("localhost","root","","lokisalle");
if($mysqli->connect_error)die("Un problème est survenu lors de la tentative de connection a la BDD : " . $mysqli->connect_error);

session_start();

define("RACINE_SITE", $_SERVER['DOCUMENT_ROOT'] . "/lokisalle/");
define("URL",'http://localhost/lokisalle/');

$contenu = '';

require_once("fonction.inc.php")
 ?>
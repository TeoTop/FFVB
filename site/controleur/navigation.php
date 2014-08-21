<?php 
/*
*
* Créer par : CHAPON Théo
* Date de modification : 06/08/2014
*
*/

/*
*
* Information sur la page :
* Nom : navigation.php
* Chemin abs : site\controleur
* Information : Page permettant de rediriger vers les pages du site
* 
* 
*
*/

$action = $_GET['a'];

if ($action == 'editeur') {
	include V . 'editeur.php';	
} else if ($action == 'generateur') {
	include V . 'generateur.php';	
} else if ($action == 'verificateur') {
	include V . 'verificateur.php';	
}

?>
<?php 
/*
*
* Créer par : CHAPON Théo
*
*/

/*
*
* Information sur la page :
* Nom : css.php
* Chemin abs : site\controleur
* Information : Page permettant d'inclure les fichiers CSS nécessaire à la page
* 
* 
*
*/
	$action = $_GET['a'];
	
	if ($action == 'editeur') {
		echo '<link href="site/css/editeur.css" rel="stylesheet">';	
	} else if ($action == 'generateur') {
		echo '<link href="site/css/generateur.css" rel="stylesheet">';
	} else if ($action == 'verificateur') {
		echo '<link href="site/css/verificateur.css" rel="stylesheet">';	
	}
?>

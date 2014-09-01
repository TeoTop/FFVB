<?php 
/*
*
* Créer par : CHAPON Théo
*
*/

/*
*
* Information sur la page :
* Nom : js.php
* Chemin abs : site\controleur
* Information : Page permettant d'inclure les fichiers JS nécessaire à la page
* 
* 
*
*/
	$action = $_GET['a'];
	
	if ($action == 'editeur') {
		echo '<script type="text/javascript" src="site/js/editeur.js"></script>';	
	} else if ($action == 'generateur') {
		echo '<script type="text/javascript" src="site/js/generateur.js"></script>';
	} else if ($action == 'verificateur') {
		echo '<script type="text/javascript" src="site/js/verificateur.js"></script>';	
	}
?>
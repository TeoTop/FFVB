<?php 
/*
*
* Créer par : CHAPON Theo
* Date de modification : 14/08/2013
*
**/

/*
*
* Information sur la page :
* Nom : chargerMenu.php
* Chemin abs : site/ajax/verification
* Information : page permettant de recharger la partie menu déroulant
*
**/
	
	define('V', '../../vue/');
	define('M', '../../model/');

	//page contenant les fonctions associées à la base de données
 	require '../../bdd.php';
 	
 	function chargerClasse($classe)
	{
	  require M . $classe . '.class.php'; // On inclut la classe correspondante au paramètre passé.
	}

	// On enregistre la fonction en autoload pour qu'elle soit appelée dès qu'on instanciera une classe non déclarée.
	spl_autoload_register('chargerClasse'); 

	//ouverture d'un session ATTENTION : le session start DOIT être placé APRES le chargement des classes
	session_start();


	// on récupère les poules du tour de coupe
    $manager = new PouleManager();
    $poules = $manager->poules($_SESSION['tour']->id());


	include V . 'verification/menuDeroulant.php'
?>
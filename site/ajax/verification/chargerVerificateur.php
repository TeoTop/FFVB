<?php 
/*
*
* Créer par : CHAPON Theo
* Date de modification : 18/08/2014
*
**/

/*
*
* Information sur la page :
* Nom : chargerVerificateur.php
* Chemin abs : site/ajax/verification
* Information : page permettant de recharger le contenue de la page vérificateur à partir de la coupe et du tour passés en POST
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

	include V . 'verificateur.php';
   
?>
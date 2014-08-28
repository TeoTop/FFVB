<?php 
/*
*
* Créer par : CHAPON Theo
*
**/

/*
*
* Information sur la page :
* Nom : chargerIndicateur.php
* Chemin abs : site/ajax/verification
* Information : page permettant de recharger l'indicateur d'erreur pour un poule
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

	// ouverture d'un session ATTENTION : le session start DOIT être placé APRES le chargement des classes
	session_start();

	// on récupère les poules du tour de coupe, les équipes et les exemptés
    $manager = new PouleManager();
    $poules = $manager->poules($_SESSION['tour']->id());

	$manager = new EquipeManager();
    $equipes = $manager->equipesTour($_SESSION['tour']->id());

    $exemptees = $manager->equipesExempte($_SESSION['tour']->id()); 

    
	include V . 'verification/indicateur.php';
   
?>
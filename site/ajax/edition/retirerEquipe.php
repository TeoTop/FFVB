<?php 
/*
*
* Créer par : CHAPON Theo
* Date de modification : 09/08/2013
*
**/

/*
*
* Information sur la page :
* Nom : retirerEquipe.php
* Chemin abs : site/ajax
* Information : page permettant de retirer l'équipe passé en POST d'une poule
*
**/

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



	$manager = new PouleManager();

	if($_SESSION['poule'] != ''){

		if($_POST['equipe'] !== 'all'){
			//on retire toutes une équipe de la poule
			$manager->retirerEquipe($_POST['equipe'], $_SESSION['poule']->id());
		} else {
			//on retire toutes les équipes de la poule
			$manager->retirerEquipes($_SESSION['poule']->id());
		}

	} else {

		if($_POST['equipe'] !== 'all'){
			//on retire une équipe éxemptée
			$manager->retirerExempte($_POST['equipe'], $_SESSION['tour']->id());
		} else {
			//on retire une équipe éxemptée
			$manager->retirerExemptes($_SESSION['tour']->id());
		}

	}
?>
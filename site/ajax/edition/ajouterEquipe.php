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
* Nom : ajouterEquipe.php
* Chemin abs : site/ajax
* Information : page permettant d'ajouter une équipe passé en POST à une poule en SESSION
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


	$equipesPoule = array();
	$distance = NULL;

    if($_SESSION['poule'] != ''){
        $manager = new EquipeManager();
        $equipesPoule = $manager->equipesPoule($_SESSION['poule']->id());
    }

    if(!empty($equipesPoule)){
    	$distance = $manager->recupererDistance($equipesPoule[0]->club()->id(), $_POST['equipe']);
    }


	$manager = new PouleManager();

	if($_SESSION['poule'] != ''){
		
		// on ajoute l'équipe à la poule
		$manager->ajouterEquipe($_POST['equipe'], $_SESSION['poule']->id(), $distance);

	} else {

		// on ajoute l'équipe dans les exemptées
		$manager->ajouterExempter($_POST['equipe'], $_SESSION['tour']->id());
	}
	    

?>
<?php 
/*
*
* Créer par : CHAPON Theo
* Date de modification : 08/08/2013
*
**/

/*
*
* Information sur la page :
* Nom : creerPoule.php
* Chemin abs : siteajax
* Information : page permttant de creer une poule à 
*
**/

	define('M', '../model/');

	//page contenant les fonctions associées à la base de données
 	require '../bdd.php';
 	
 	function chargerClasse($classe)
	{
	  require M . $classe . '.class.php'; // On inclut la classe correspondante au paramètre passé.
	}

	// On enregistre la fonction en autoload pour qu'elle soit appelée dès qu'on instanciera une classe non déclarée.
	spl_autoload_register('chargerClasse'); 

	//ouverture d'un session ATTENTION : le session start DOIT être placé APRES le chargement des classes
	session_start();


	// on récupère la coupe pour créer le nom de la poule
	$manager = new CoupeManager();
    $coupe = $manager->coupe($_SESSION['coupe']->id());
    
	// on récupère la dernière poule
    $manager = new PouleManager();

    //on regarde si il manque une poule
    $poule = $manager->premierePouleManquante($_SESSION['tour']->id());

    //traitement pour créer la poule manque
    if(isset($poule)){

    	$manager->creerPouleId($poule->id(), $poule->nom(), $_SESSION['tour']->id());
    	$manager->supprimerPouleManquante($poule->id());

    } else {

    	$poule = $manager->dernierePoule($_SESSION['tour']->id());

	    //traitement pour créer le nouveau nom de la poule à partir de la dernière poule existante dans la base
	    if(!isset($poule)){
	    	//fonction permettant de définir la base des noms de poules
	    	$nom = $coupe->coupeVersPoule();
	    } else {
	    	$nom = $poule->nouveauNom();
	    }

	    //on créer la poule
	    $manager->creerPoule($nom, $_SESSION['tour']->id());

	    //on récupère la poule que l'on vient de créer
	    $poule = $manager->dernierePoule($_SESSION['tour']->id());

    }

    echo json_encode(['poule' => $poule->id()]);
?>
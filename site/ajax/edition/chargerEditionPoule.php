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
* Nom : chargerEditionPoule.php
* Chemin abs : site/ajax
* Information : page permettant de recharger l'éditeur de poule à partir de la poule passé en POST
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



	// on récupère les poules du tour de coupe pour l'affichage
    $manager = new PouleManager();
    $poules = $manager->poules($_SESSION['tour']->id());

    //récupération de la poule à afficher, si il n'y en a pas, on affiche la poule exempté
    if(isset($_POST['poule'])){
    
        if($_POST['poule'] != ''){
            $_SESSION['poule'] = $manager->poule($_POST['poule']);
        } else {
            $_SESSION['poule'] = '';
        }

    }
    
	include V . 'edition/editionPoule.php';
   
?>
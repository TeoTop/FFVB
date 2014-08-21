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
* Nom : chargerEquipeCritere.php
* Chemin abs : site/ajax
* Information : page permettant de recharger la partie sélection d'équipes en fonction du type de critère en SESSION
*
**/
	
	define('V', '../vue/');
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


	// on récupère les critères utilsées pour ce tour de coupe et ce type de critère puis on affiche la bonne vue
    $manager = new CritereManager();
    
    if($_SESSION['critere'] == 'domicile'){

    	$critereDomicile = $manager->criteresType($_SESSION['tour']->id(), 'domicile');
    	include V . 'equipeCritereDomicile.php';

	} else if($_SESSION['critere'] == 'exterieur'){

    	$critereExterieur = $manager->criteresType($_SESSION['tour']->id(), 'exterieur');
    	include V . 'equipeCritereExterieur.php';

	} else {

		$critereExempter = $manager->criteresType($_SESSION['tour']->id(), 'exempter');
		include V . 'equipeCritereExempter.php';

	}
?>
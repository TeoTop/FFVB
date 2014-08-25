<?php 
/*
*
* Créer par : CHAPON Theo
* Date de modification : 14/08/2014
*
**/

/*
*
* Information sur la page :
* Nom : categorieIncomplete.php
* Chemin abs : site/ajax/accueil
* Information : page permettant de modifier la valeur d'un critère
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

	// on modifie le critère en fonction du tour, du critère et de ça valeur
    // on modifie le critère en fonction du tour, du critère et de ça valeur
    $manager = new EquipeManager();
	$equipes = $manager->equipeNonClassee($_POST['categorie']);

	if(empty($equipes)){
		echo json_encode(['reponse' => false]);
	} else {
		echo json_encode(['reponse' => true]);
	}
?>
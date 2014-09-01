<?php 
/*
*
* Créer par : CHAPON Theo
*
**/

/*
*
* Information sur la page :
* Nom : chargerEquipe.php
* Chemin abs : site/ajax/verification
* Information : page permettant de savoir si il faut charger une poule ou ajouter une équipe
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



	// on regarde si l'équipe est déjà dans une poule
    $manager = new EquipeManager();
    $resultat = $manager->dansPoule($_POST['equipe'], $_SESSION['tour']->id());
    
	
	//si l'équipe est dans une poule on retourne la poule
	if(isset($resultat)){

		echo json_encode(['action' => true, 'poule' => $resultat]);
	
	} else {

		//si l'équipe est exempté, on retourne la valeur de la poule exempté
		$resultat = $manager->dansExempter($_POST['equipe'], $_SESSION['tour']->id());
		if($resultat){
			echo json_encode(['action' => true, 'poule' => '']);
		} else {
			echo json_encode(['action' => false]);
		}
		
	}
	    

?>
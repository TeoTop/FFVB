<?php 
/*
*
* Créer par : CHAPON Théo
* Date de modification : 08/08/2013
*
*/

/*
*
* Information sur la page :
* Nom : supprimerPoule.php
* Chemin abs : site\ajax\
* Information : page permettant de supprimer la poule en session
*
*/

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


	  // on récupère la dernière poule
    $manager = new PouleManager();
    $derniere = $manager->dernierePoule($_SESSION['tour']->id());

    //on regarde si c'est la dernière poule
    if($derniere->id() != $_SESSION['poule']->id()){

      //si ce n'est pas le cas, on récupère la poule
    	$poule = $manager->poule($_SESSION['poule']->id());

      //puis on la place dans la table des poules manquantes, elle aura donc la priorité lors de la création d'une poule
    	$manager->creerPouleManquante($poule->id(), $poule->nom(), $_SESSION['tour']->id());

    }

    //on supprime la poule
    $manager->supprimerPoule($_SESSION['poule']->id());

    //si jamais on supprime une poule plus élévé, alors on supprime de la table des manquantes toutes les poules qui manquent 
    // superieur à la dernière poule existante
    $derniere = $manager->dernierePoule($_SESSION['tour']->id());
    
    if(!isset($derniere)){
    	$manager->supprimerPoulesManquantesSuperieur(0);  // on vide la table de poule manquante car il n'y a plus de poule (RAZ)
    } else {
    	$manager->supprimerPoulesManquantesSuperieur($derniere->id()); //on retire les poules superieurs à l'id de poule indiqué
    }
    
   
    //on affiche la poule situez juste avant celle que l'on vient de supprimer
   	$pouleAff = $manager->affichageSuppression($_SESSION['poule']->id(), $_SESSION['tour']->id()  );
    
   	if(isset($pouleAff)){
   		echo json_encode(['poule' => $pouleAff]);
   	} else {
   		echo json_encode(['poule' => '']);
   	}
    
?>
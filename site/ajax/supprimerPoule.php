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
* Information : page permttant de créer une poule
*
*/

	define('M', '../model/');

	//page contenant les fonctions associées à la base de données
 	require '../bdd.php';
 	
 	function chargerClasse($classe)
	{
	  require M . $classe . '.class.php'; // On inclut la classe correspondante au paramètre passé.
	}

	// On enregistre la fonction en autoload pour qu'elle soit appelée dès qu'on instanciera une classe non déclarée.
	spl_autoload_register('chargerClasse'); 
?>

<?php
	// on supprime la poule
    $manager = new PouleManager();
    $derniere = $manager->dernierePoule($_POST['tour']);

    if($derniere->id() != $_POST['poule']){
    	$poule = $manager->poule($_POST['poule']);
    	$manager->creerPouleManquante($poule->id(), $poule->nom(), $_POST['tour']);
    }

    $manager->supprimerPoule($_POST['poule']);

    //si jamais on supprime une poule de élévé, alors on supprime de la table de manquante toutes les poules qui manquent superieur
    // à la dernière poule existante
    $derniere = $manager->dernierePoule($_POST['tour']);
    if(!isset($derniere)){
    	$manager->supprimerPoulesManquantesSuperieur(0);  // on vide la table de poule manquante car il n'y a plus de poule (RAZ)
    } else {
    	$manager->supprimerPoulesManquantesSuperieur($derniere->id()); //on retire les poules supèrieurs à l'id de poule indiqué
    }
    
   
    //on affiche la poule situez juste avant celle que l'on vient de supprimer
   	$pouleAff = $manager->affichageSuppression($_POST['poule']);
    
   	if(isset($pouleAff)){
   		echo json_encode(['poule' => $pouleAff->id()]);
   	} else {
   		echo json_encode(['poule' => NULL]);
   	}
    
?>
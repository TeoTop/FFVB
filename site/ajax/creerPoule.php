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
* Information : page permttant de creer une poule
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
?>

<?php
	// on récupère la coupe pour créer le nom de la poule
	$manager = new CoupeManager();
    $coupe = $manager->coupe($_POST['coupe']);
    
    $pouleAff; //permet de retourner la poule qu'il faudra afficher    

	// on récupère la dernière poule
    $manager = new PouleManager();

    //on regarde si il manque une poule
    $poule = $manager->pouleManquante($_POST['tour']);

    //traitement pour créer la poule manque
    if(isset($poule)){
    	$pouleAff = $manager->premierePouleManquante($_POST['tour']);
    	$manager->creerPouleId($poule->id(), $poule->nom(), $_POST['tour']);
    	$manager->supprimerPouleManquante($poule->id());
    } else {
    	$poule = $manager->dernierePoule($_POST['tour']);

	    //traitement pour créer le nouveau nom de la poule à partir de la dernière poule existante dans la base
	    if(!isset($poule)){
	    	//fonction permettant de définir la base des noms de poules
	    	$nom = $coupe->coupeVersPoule();
	    } else {
	    	$nom = $poule->nouveauNom();
	    }

	    $manager->creerPoule($nom, $_POST['tour']);
	    $pouleAff = $manager->dernierePoule($_POST['tour']);
    }

    echo json_encode(['poule' => $pouleAff->id()]);
?>
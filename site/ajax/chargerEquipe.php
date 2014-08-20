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
* Nom : chargerEquipe.php
* Chemin abs : site/ajax
* Information : page permttant de savoir si il faut charger une poule ou ajouter une équipe
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

	// on regarde si l'équipe est déjà dans une poule
    $manager = new EquipeManager();
    $resultat = $manager->dansPoule($_POST['equipe'], $_POST['tour']);
	if(isset($resultat)){
		echo json_encode(['action' => true, 'poule' => $resultat]);
	} else {
		$resultat = $manager->dansExempter($_POST['equipe'], $_POST['tour']);
		if($resultat){
			echo json_encode(['action' => true, 'poule' => '']);
		} else {
			echo json_encode(['action' => false]);
		}
	}
	    

?>
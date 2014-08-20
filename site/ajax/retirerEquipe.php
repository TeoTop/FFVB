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
* Nom : retirerEquipe.php
* Chemin abs : site/ajax
* Information : page permttant de retirer une équipe d'une poule
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

	session_start();
?>

<?php 

	$manager = new PouleManager();

	if($_POST['poule'] != -1){

		if($_POST['equipe'] !== 'all'){
			//on retire toutes une équipe de la poule
			$manager->retirerEquipe($_POST['equipe'], $_POST['poule']);
		} else {
			//on retire toutes les équipes de la poule
			$manager->retirerEquipes($_POST['poule']);
		}

	} else {

		//on retire toutes une équipe éxemptée
		$manager->retirerExempter($_POST['equipe'], $_SESSION['tour']->id());
	}
?>
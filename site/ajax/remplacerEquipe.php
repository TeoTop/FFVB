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
* Nom : remplacerEquipe.php
* Chemin abs : site/ajax
* Information : page permettant de modifier l'équipe qui reçoit à domicile
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

	// on ajoute l'équipe à la poule
    $manager = new PouleManager();
	$manager->modifierDomicile($_POST['equipe'], $_POST['poule']);
	    

?>
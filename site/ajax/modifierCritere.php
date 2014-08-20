<?php 
/*
*
* Créer par : CHAPON Theo
* Date de modification : 14/08/2013
*
**/

/*
*
* Information sur la page :
* Nom : modifierCritere.php
* Chemin abs : site/ajax
* Information : page permettant de modifier la valeur d'un critère
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
    $manager = new CritereManager();
	$manager->modifierCritere($_POST['tour'], $_POST['critere'], $_POST['valeur']);
	    

?>
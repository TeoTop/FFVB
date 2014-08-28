<?php 
/*
*
* Créer par : CHAPON Theo
*
**/

/*
*
* Information sur la page :
* Nom : categorieIncomplete.php
* Chemin abs : site/ajax/accueil
* Information : page permettant de vérifier les poules de chaque catégorie
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
    $manager = new EquipeManager();
	$equipesNonClassees = $manager->equipeNonClassee($_POST['categorie']);


	// on récupère les poules du tour de coupe
    $manager = new PouleManager();
    $poules = $manager->poules($_POST['categorie']);

	$manager = new EquipeManager();
    $equipes = $manager->equipesTour($_POST['categorie']);

    $exemptees = $manager->equipesExempte($_POST['categorie']); 

    // on récupère le nombre d'équipe, de poule et d'exempté	
    $nbEquipe = count($equipes);
    $nbPouleCree = count($poules);
    $nbExempteCree = count($exemptees);

    $nbEquipeNecessaire = 0;
    $nbPouleNecessaire = 0;
    $repeche = 0;


    // on récupère le nombre nécessaire d'équipe et de poule en fonction du nombre d'équipe présente
    if($nbEquipe <= 8){
        $nbEquipeNecessaire = 6;
    } 
    else if($nbEquipe <= 12){
        $nbEquipeNecessaire = 12;
        $nbPouleNecessaire = 4;
    } 
    else if($nbEquipe <= 18){
        $nbEquipeNecessaire = 18;
        $nbPouleNecessaire = 6;
    } 
    else if($nbEquipe <= 27){
        $nbEquipeNecessaire = 27;
        $nbPouleNecessaire = 9;
    } 
    else if($nbEquipe <= 39){
        $nbEquipeNecessaire = 39;
        $nbPouleNecessaire = 13;
    } 
    else if($nbEquipe <= 57){
        $nbEquipeNecessaire = 57;
        $nbPouleNecessaire = 19;
    } 
    else if($nbEquipe <= 84){
        $nbEquipeNecessaire = 84;
        $nbPouleNecessaire = 28;
    }
    else if($nbEquipe <= 126){
        $nbEquipeNecessaire = 126;
        $nbPouleNecessaire = 42;
    }
    else if($nbEquipe <= 189){
        $nbEquipeNecessaire = 189;
        $nbPouleNecessaire = 63;
    }


    $nbPoule = $nbPouleNecessaire;
    $nbPoule4 = 0;
    $nbExempte = 0;

    // on regarde si aucune équipe n'a été classée
	if(count($equipesNonClassees) == $nbEquipe){
		echo json_encode(['reponse' => "red"]);
	} else {

		$verifExempte = false;

        // si le nombre d'équipe est inférieur au nombre d'équipe nécessaire, on calcule le nombre d'exempté
		if( $nbEquipe < $nbEquipeNecessaire ){
	        
	        $nbExempte = (($nbEquipeNecessaire - $nbEquipe) * 2);
            $nbPoule = ($nbEquipe - $nbExempte) / 3;
	        
	        $verifExempte = $nbExempte - $nbExempteCree;
	        if( $verifExempte != 0 ){
	        	$verifExempte = true;
	        }
	        else {
	        	$verifExempte = false;
	        }
	    
	    } 

        // si le nombre de poule, d'éxempté ou d'équipe qui ne sont pas classées n'est pas bon
	    $verifPoule = $nbPoule - $nbPouleCree;
        if( $verifPoule != 0 || $verifExempte || count($equipesNonClassees) != 0 ){
        	echo json_encode(['reponse' => "orange"]);
        }
        else {
        	echo json_encode(['reponse' => "green"]);
        }
	}
?>
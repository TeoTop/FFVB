<?php


	function chargerClasseEditeur($classe)
    {
        require 'site/model/' . $classe . '.class.php'; // On inclut la classe correspondante au paramètre passé.
    }

    spl_autoload_register('chargerClasseEditeur');

    //on inclut le fichier gérant l'accés à la base
    require 'site/bdd.php';

    // on ouvre une connexion
    $bdd = ouvre_base();

   
    $equipes = array();

    if(isset($_GET['tour'])){
    	$tour = $_GET['tour'];
    } else {
    	$tour = 0;
    }

	//on récupère les clubs
	$q = $bdd->prepare('SELECT `equipe`, `distance` FROM `jouer` WHERE distance IS NOT NULL AND `poule` IN (
			SELECT `id_poule` FROM `poule` WHERE `tour` = :tour
		)');


	$q->bindValue(':tour', $tour, PDO::PARAM_INT);
	$q->execute();

	//recupération des données et création des objets
	while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
	{
		$r = $bdd->prepare('UPDATE `equipe` SET `nbKmParcouru`=`nbKmParcouru` + :distance WHERE `id_equipe` = :equipe');
		$r->bindValue(':distance', $donnees['distance'], PDO::PARAM_INT);
		$r->bindValue(':equipe', $donnees['equipe'], PDO::PARAM_INT);
		$r->execute();
	}

?>
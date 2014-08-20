<?php 
/*
*
* Créer par : CHAPON Théo
* Date de modification : 06/08/2013
*
*/

/*
*
* Information sur la page :
* Nom : tourManager.php
* Chemin abs : site\modele\
* Information : page permettant de gérer les objets tour dans la base de données
*
*/
?>

<?php

class TourManager{

	private $_db;

	//constructeur
	public function __construct()
	{
		$this->setDb(ouvre_base()); // ouvre_base se situe dans le fichier bdd.php -> permet de créer une connexion PDO avec la base puis la retourne
	}

	//setter
	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}


	//retourne le tour définie par l'id
	public function tour($id, Coupe $coupe)
	{
		$tour = NULL;

		//requete SQL avec argument :coupe
		$q = $this->_db->prepare('SELECT `id_tour`, `coupe`, `numero`, `dateTour`, `age`, `sexe` FROM `tour`
		JOIN `coupe` ON `coupe` = `id_coupe` 
		WHERE `id_tour` = :id');

		$q->bindValue(':id', $id, PDO::PARAM_INT);

		$q->execute();


		//recupération des données et création des objets
		if($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$tour = new Tour($donnees['id_tour'], $coupe, $donnees['numero'], $donnees['dateTour']);
		}

		return $tour;
	}


	//retourne la liste des tours d'une coupe
	public function tours(Coupe $coupe)
	{
		$tours = array();


		//requete SQL avec argument :coupe
		$q = $this->_db->prepare('SELECT `id_tour`, `coupe`, `numero`, `dateTour`, `age`, `sexe` FROM `tour` 
			JOIN `coupe` ON `coupe` = `id_coupe` 
			WHERE `coupe` = :coupe');

		$q->bindValue(':coupe', $coupe->id(), PDO::PARAM_INT);

		$q->execute();


		//recupération des données et création des objets
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{	
			$tours[] = new Tour($donnees['id_tour'], $coupe, $donnees['numero'], $donnees['dateTour']);
		}

		return $tours;
	}


	//retourne la liste des tours les plus avancés dans chaque coupe
	public function getListMaxTour($annee)
	{
		$tours = array();


		//requete SQL avec argument :annee
		$q = $this->_db->prepare('SELECT `id_tour`, `coupe`, `numero`, `dateTour`, `age`, `sexe` FROM `tour` 
			JOIN `coupe` ON `coupe` = `id_coupe` 
			WHERE `id_tour` in (
   				SELECT max(`id_tour`) FROM `tour` GROUP BY `coupe` HAVING `annee` = :annee
			)');

		$q->bindValue(':annee', $annee, PDO::PARAM_INT);

		$q->execute();


		//recupération des données et création des objets
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$coupe = new Coupe($donnees['coupe'], $donnees['sexe'], $donnees['age']);	
			$tours[] = new Tour($donnees['id_tour'], $coupe, $donnees['numero'], $donnees['dateTour']);
		}

		return $tours;
	}
}

?>
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
* Nom : coupeManager.php
* Chemin abs : site\modele\
* Information : page permettant de gérer les objets coupe dans la base de données
*
*/

class CoupeManager{

	private $_db;

	//contructeur
	public function __construct()
	{
		$this->setDb(ouvre_base());
	}

	//setter
	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}

	//permet de récupérer les années de coupes dans la base
	public function coupe($id)
	{
		$coupe = NULL;

		//requete SQL
		$q = $this->_db->prepare('SELECT `id_coupe`, `sexe`, `age`, `annee` FROM `coupe` WHERE `id_coupe` = :id');
		
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->execute();


		//recupération des données et création des objets
		if($donnee = $q->fetch(PDO::FETCH_ASSOC))
		{	
			$coupe = new Coupe($donnee['id_coupe'], $donnee['sexe'], $donnee['age'], $donnee['annee']);
		}

		return $coupe;
	}

	//permet de récupérer toutes les coupes de l'année passée en parametre
	public function coupes($annee)
	{
		$coupes = array();

		//requete SQL avec argument :annee
		$q = $this->_db->prepare('SELECT `id_coupe`, `age`, `sexe`, `annee` FROM `coupe` 
				WHERE `annee` = :annee 
				ORDER BY `age`, `sexe`');
		
		$q->bindValue(':annee', $annee, PDO::PARAM_INT);
		$q->execute();


		//recupération des données et création des objets
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$coupes[] = new Coupe($donnees['id_coupe'], $donnees['sexe'], $donnees['age'], $donnees['annee']);
		}

		return $coupes;
	}


	//permet de récupérer les années de coupes dans la base
	public function annees()
	{
		$annees = array();

		//requete SQL
		$q = $this->_db->query('SELECT DISTINCT `annee` FROM `coupe` ORDER BY `annee`');
		
		//recupération des données et création des objets
		while ($donnee = $q->fetch(PDO::FETCH_ASSOC))
		{	
			$annees[] = $donnee['annee'];
		}

		return $annees;
	}


	//permet de vérifier si l'id de coupe existe et si un tour est créé pour cette coupe
	public function existe($id)
	{
		//requete SQL
		$q = $this->_db->prepare('SELECT `coupe` FROM `tour` WHERE `coupe` = :id');

		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->execute();
		
		//recupération des données et création des objets
		if ($donnee = $q->fetch(PDO::FETCH_ASSOC))
		{	
			return true;
		}

		return false;
	}
}

?>
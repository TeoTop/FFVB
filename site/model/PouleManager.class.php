<?php 
/*
*
* Créer par : CHAPON Théo
*
*/

/*
*
* Information sur la page :
* Nom : pouleManager.php
* Chemin abs : site\modele\
* Information : page permettant de gérer les objets poule et poules supprimées dans la base de données
*
*/

class PouleManager{

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



	//permet de récupérer la poule en fonction de l'id
	public function poule($id)
	{
		$poule = NULL;
		
		//requete SQL avec argument :id
		$q = $this->_db->prepare('SELECT `id_poule`, `nom` FROM `poule` 
				WHERE `id_poule` = :id');
		
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->execute();


		//recupération des données et création des objets
		if($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$poule = new Poule($donnees['id_poule'], $donnees['nom']);
		}

		return $poule;
	}



	//permet de récupérer toutes les poules d'un tour
	public function poules($tour)
	{
		$poules = array();

		//requete SQL avec argument :annee
		$q = $this->_db->prepare('SELECT `id_poule`, `nom` FROM `poule` 
				WHERE `tour` = :tour ORDER BY `id_poule`');
		
		$q->bindValue(':tour', $tour, PDO::PARAM_INT);
		$q->execute();


		//recupération des données et création des objets
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$poules[] = new Poule($donnees['id_poule'], $donnees['nom']);
		}

		return $poules;
	}




	//on crée une nouvelle poule
	public function creerPoule($nom, $tour){
		$q = $this->_db->prepare('INSERT INTO `poule`(`tour`, `nom`) VALUES (:tour,:nom)');
		
		$q->bindValue(':tour', $tour, PDO::PARAM_INT);
		$q->bindValue(':nom', $nom, PDO::PARAM_STR);
		$q->execute();
	}



	//on remet dans la table des poules, la poule que l'on a récupéré à partir de la table des poules manquantes
	public function creerPouleId($id, $nom, $tour){
		$q = $this->_db->prepare('INSERT INTO `poule`(`id_poule`, `tour`, `nom`) VALUES (:id, :tour,:nom)');
		
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->bindValue(':tour', $tour, PDO::PARAM_INT);
		$q->bindValue(':nom', $nom, PDO::PARAM_STR);
		$q->execute();
	}



	//on ajoute la poule que l'on veut de supprimer à la table des poules manquantes
	public function creerPouleManquante($id, $nom, $tour){
		$q = $this->_db->prepare('INSERT INTO `poulesupprimer`(`id_poule`, `tour`, `nom`) VALUES (:id, :tour,:nom)');
		
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->bindValue(':tour', $tour, PDO::PARAM_INT);
		$q->bindValue(':nom', $nom, PDO::PARAM_STR);
		$q->execute();
	}






	//on supprime la poule indiquée par id
	public function supprimerPoule($id){
		
		$q = $this->_db->prepare('DELETE FROM `poule` WHERE `id_poule` = :id_poule');
		
		$q->bindValue(':id_poule', $id, PDO::PARAM_INT);
		$q->execute();
	}



	//on supprime la poule indiquée par id dans la table des poules manquantes
	public function supprimerPouleManquante($id){
		
		$q = $this->_db->prepare('DELETE FROM `poulesupprimer` WHERE `id_poule` = :id_poule');
		
		$q->bindValue(':id_poule', $id, PDO::PARAM_INT);
		$q->execute();
	}



	//on supprime toutes les poules manquantes qui ont un id superieur à la dernière poule existante
	public function supprimerPoulesManquantesSuperieur($id){
		
		$q = $this->_db->prepare('DELETE FROM `poulesupprimer` WHERE `id_poule` > :id_poule');
		
		$q->bindValue(':id_poule', $id, PDO::PARAM_INT);
		$q->execute();
	}






	//retourne l'id de la dernière poule existante du tour. NULL si aucune poule n'existe dans ce tour
	public function dernierePoule($tour){
		$poule = NULL;

		$q = $this->_db->prepare('SELECT `id_poule`, `nom` FROM `poule` WHERE `tour` = :tour ORDER BY `id_poule` DESC LIMIT 1');
		
		$q->bindValue(':tour', $tour, PDO::PARAM_INT);
		$q->execute();

		if($donnees = $q->fetch(PDO::FETCH_ASSOC)){
			$poule = new Poule($donnees['id_poule'], $donnees['nom']);
		}

		return $poule;
	}
	

	//retourne la poule situé juste avant celle qui vient d'être supprimé
	public function affichageSuppression($id, $tour){
		$poule = NULL;

		$q = $this->_db->prepare('SELECT `id_poule` FROM `poule` 
			WHERE `id_poule` < :id AND `tour` = :tour
			ORDER BY `id_poule` DESC LIMIT 1');
		
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->bindValue(':tour', $tour, PDO::PARAM_INT);
		$q->execute();

		if($donnees = $q->fetch(PDO::FETCH_ASSOC)){
			$poule = $donnees['id_poule'];
		}

		return $poule;
	}



	//retourne la derniere poule manquante du tour. NULL si aucune poule ne manque dans ce tour
	public function premierePouleManquante($tour){
		$poule = NULL;

		$q = $this->_db->prepare('SELECT `id_poule`, `nom` FROM `poulesupprimer` WHERE `tour` = :tour ORDER BY `id_poule` LIMIT 1');
		
		$q->bindValue(':tour', $tour, PDO::PARAM_INT);
		$q->execute();

		if($donnees = $q->fetch(PDO::FETCH_ASSOC)){
			$poule = new Poule($donnees['id_poule'], $donnees['nom']);
		}

		return $poule;
	}





	//ajoute l'équipe à la poule
	public function ajouterEquipe($equipe, $poule, $distance){
	
		$q = $this->_db->prepare('INSERT INTO `jouer`(`equipe`, `poule`, `distance`) VALUES (:equipe, :poule, :distance)');
		
		$q->bindValue(':equipe', $equipe, PDO::PARAM_INT);
		$q->bindValue(':poule', $poule, PDO::PARAM_INT);
		$q->bindValue(':distance', $distance, PDO::PARAM_INT);
		$q->execute();
	}



	//remplace l'équipe en position 1 de la poule donner en param par l'équipe passée en param
	public function modifierDomicile($equipe, $poule){
	
		$q = $this->_db->prepare('UPDATE `jouer` SET `equipe`= :equipe WHERE `poule` = :poule AND `distance` IS NULL');
		
		$q->bindValue(':equipe', $equipe, PDO::PARAM_INT);
		$q->bindValue(':poule', $poule, PDO::PARAM_INT);
		$q->execute();
	}



	//retire l'équipe de la poule
	public function retirerEquipe($equipe, $poule){
	
		$q = $this->_db->prepare('DELETE FROM `jouer` WHERE `equipe` = :equipe AND `poule` = :poule');
		
		$q->bindValue(':equipe', $equipe, PDO::PARAM_INT);
		$q->bindValue(':poule', $poule, PDO::PARAM_INT);
		$q->execute();
	}



	//retire toutes les équipes de la poule
	public function retirerEquipes($poule){
	
		$q = $this->_db->prepare('DELETE FROM `jouer` WHERE `poule` = :poule');
		
		$q->bindValue(':poule', $poule, PDO::PARAM_INT);
		$q->execute();
	}



	//ajoute l'équipe à la poule
	public function ajouterExempter($equipe, $tour){
	
		$q = $this->_db->prepare('INSERT INTO `exempter`(`equipe`, `tour`) VALUES (:equipe, :tour)');
		
		$q->bindValue(':equipe', $equipe, PDO::PARAM_INT);
		$q->bindValue(':tour', $tour, PDO::PARAM_INT);
		$q->execute();
	}





	//retire l'équipe des exemptées
	public function retirerExempte($equipe, $tour){
	
		$q = $this->_db->prepare('DELETE FROM `exempter` WHERE `equipe` = :equipe AND `tour` = :tour');
		
		$q->bindValue(':equipe', $equipe, PDO::PARAM_INT);
		$q->bindValue(':tour', $tour, PDO::PARAM_INT);
		$q->execute();
	}



	//retire toutes les équipes exemptées du tour
	public function retirerExemptes($tour){
	
		$q = $this->_db->prepare('DELETE FROM `exempter` WHERE `tour` = :tour');
		
		$q->bindValue(':tour', $tour, PDO::PARAM_INT);
		$q->execute();
	}
}

?>
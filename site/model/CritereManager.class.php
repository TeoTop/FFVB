<?php 
/*
*
* Créer par : CHAPON Théo
* Date de modification : 12/08/2013
*
*/

/*
*
* Information sur la page :
* Nom : critereManager.php
* Chemin abs : site\modele\
* Information : page permettant de gérer les objets critere et classifier dans la base de données
*
*/

class CritereManager{

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

	//permet de récupérer les criteres et leur valeur selon le tour et le type
	public function criteresType($tour, $type)
	{
		$criteres = array();

		//requete SQL, valeur != -1 => critère actif
		$q = $this->_db->prepare('SELECT `critere`, `valeur`, `requete` FROM `classifier` 
				JOIN `critere` ON `id_critere` = `critere` 
				WHERE `type` LIKE :type AND `tour` = :tour AND `valeur` != -1');
		
		$q->bindValue(':type', $type, PDO::PARAM_STR);
		$q->bindValue(':tour', $tour, PDO::PARAM_INT);
		$q->execute();


		//recupération des données et création des objets
		while($donnee = $q->fetch(PDO::FETCH_ASSOC))
		{	
			$criteres[] = new Critere($donnee['critere'], $donnee['valeur'], $donnee['requete']);
		}

		return $criteres;
	}


	//modifie la valeur d'un critere
	public function modifierCritere($tour, $critere, $valeur)
	{
		//requete SQL
		$q = $this->_db->prepare('UPDATE `classifier` SET `valeur`=:valeur WHERE `tour`=:tour AND`critere`=:critere');
		
		$q->bindValue(':valeur', $valeur, PDO::PARAM_INT);
		$q->bindValue(':tour', $tour, PDO::PARAM_INT);
		$q->bindValue(':critere', $critere, PDO::PARAM_INT);
		$q->execute();
	}


	public function selectionner($criteres, $id)
	{
		foreach ($criteres as $key => $critere) {
			if($critere->comparer($id, 1)){
				return true;
			}
		}

		return false;
	}

	public function selectionnerOption($criteres, $id, $value)
	{
		foreach ($criteres as $key => $critere) {
			if($critere->comparer($id, $value)){
				return true;
			}
		}

		return ($value == -1) ? true : false;
	}
}

?>
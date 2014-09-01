<?php 
/*
*
* Créer par : CHAPON Théo
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



	//permet de récupérer les criteres et leur valeur selon le type si ceux-ci sont sélectionnés
	//utilisé pour l'édition (retourne requete)
	public function criteresType($type, $inverser)
	{
		$criteres = array();

		//requete SQL, valeur != -1 => critère actif
		if($inverser){
			//on orend les requetes inversées
			$q = $this->_db->prepare('SELECT `id_critere`, `valeur`, `requeteInv` as `requete` FROM `critere` 
				WHERE `type` LIKE :type AND `valeur` != -1');

		} else {
			//on prend les requetes normales
			$q = $this->_db->prepare('SELECT `id_critere`, `valeur`, `requete` FROM `critere` 
				WHERE `type` LIKE :type AND `valeur` != -1');

		}

		
		$q->bindValue(':type', $type, PDO::PARAM_STR);
		$q->execute();


		//recupération des données et création des objets
		while($donnee = $q->fetch(PDO::FETCH_ASSOC))
		{	
			$criteres[] = new Critere($donnee['id_critere'], $donnee['valeur'], $donnee['requete']);
		}

		return $criteres;
	}



	//permet de récupérer TOUS les criteres et leur valeur selon le type
	public function criteresTypeAll($type)
	{
		$criteres = array();

		//requete SQL
		$q = $this->_db->prepare('SELECT `id_critere`, `description` FROM `critere` 
				WHERE `type` LIKE :type');
		
		$q->bindValue(':type', $type, PDO::PARAM_STR);
		$q->execute();


		//recupération des données et création des objets
		while($donnee = $q->fetch(PDO::FETCH_ASSOC))
		{	
			$criteres[] = new Critere($donnee['id_critere'], $donnee['description']);
		}

		return $criteres;
	}



	//permet de récupérer les criteres et leur valeur selon le type si ceux-ci sont sélectionnés 
	//utilisé pour la vérification (retourne requeteVerif)
	public function criteresTypeVerif($type)
	{
		$criteres = array();

		//requete SQL, valeur != -1 => critère actif
		$q = $this->_db->prepare('SELECT `id_critere`, `valeur`, `requeteVerif` FROM `critere` 
				WHERE `type` LIKE :type AND `valeur` != -1');
		
		$q->bindValue(':type', $type, PDO::PARAM_STR);
		$q->execute();


		//recupération des données et création des objets
		while($donnee = $q->fetch(PDO::FETCH_ASSOC))
		{	
			$criteres[] = new Critere($donnee['id_critere'], $donnee['valeur'], $donnee['requeteVerif']);
		}

		return $criteres;
	}



	//modifie la valeur d'un critere
	public function modifierCritere($critere, $valeur)
	{
		//requete SQL
		$q = $this->_db->prepare('UPDATE `critere` SET `valeur`=:valeur WHERE `id_critere` = :critere');
		
		$q->bindValue(':valeur', $valeur, PDO::PARAM_INT);
		$q->bindValue(':critere', $critere, PDO::PARAM_INT);
		$q->execute();
	}



	// permet de savoir si un critère est sélectionné
	public function selectionner($criteres, $id)
	{
		foreach ($criteres as $key => $critere) {
			if($critere->comparer($id, 1)){
				return true;
			}
		}

		return false;
	}



	// permet de savoir si le critère est sélectionné et quelle sa valeur
	public function selectionnerOption($criteres, $id, $value)
	{
		foreach ($criteres as $key => $critere) {
			if($critere->comparer($id, $value)){
				return true;
			}
		}

		return ($value == -1) ? true : false;
	}


	// permet d'afficher l'aide correspondant au critère
	public function aide($criteres, $id)
	{
		foreach ($criteres as $key => $critere) {
			if($critere->id() == $id){
				return '+ '.$critere->description();
			}
		}

		return '';
	}
}

?>
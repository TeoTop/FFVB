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
* Nom : coupe.php
* Chemin abs : site\modele\
* Information : page permettant de gérer les objets coupe
*
*/
?>

<?php

class Coupe{

	private $_id;
	private $_annee;
	private $_sexe;
	private $_age;
	private $_equipe;

	//constructeur
	public function __construct()
	{
		$ctp = func_num_args();
    	$args = func_get_args();

		switch($ctp)
		{
		    case 1:
		        $this->setId($args[0]); 
		        break;
		    case 3:
		        $this->setId($args[0]); 
				$this->setSexe($args[1]); 
				$this->setAge($args[2]); 
		        break;
		    case 4:
		        $this->setId($args[0]);  
				$this->setSexe($args[1]); 
				$this->setAge($args[2]); 
				$this->setAnnee($args[3]);
		        break;
		    case 5:
		        $this->setId($args[0]); 
				$this->setAnnee($args[1]); 
				$this->setSexe($args[2]); 
				$this->setAge($args[3]); 
				$this->setEquipe($args[4]);
		        break;
		     default:
		        break;
		}
	}

	//getter
	public function id(){ return $this->_id; }
	public function annee(){ return $this->_annee; }
	public function sexe(){ return $this->_sexe; }
	public function age(){ return $this->_age; }
	public function equipe(){ return $this->_equipe; }

	//setter
	public function setId($id)
	{
		// L'identifiant du personnage sera, quoi qu'il arrive, un nombre entier.
		$this->_id = (int) $id;
	}

	public function setAnnee($annee)
	{
		$this->_annee = (int) $annee;
	}

	public function setSexe($sexe)
	{
		$sexe = (String) $sexe;
		if($sexe == 'g' || $sexe == 'f'){
			$this->_sexe = $sexe;
		}
	}

	public function setAge($age)
	{
		$age = (int) $age;
		if($age == 13 || $age == 15 || $age == 17 || $age == 20){
			$this->_age = $age;
		}
	}

	public function setEquipe($equipe)
	{
		$this->_equipe = $equipe;
	}


	//cette fonction true si l'id correspond
	public function memeId(Coupe $coupe){
		return ($this->_id == $coupe->_id) ? true : false;
	}


	//cette fonction renvoie l'intitulé de la catégorie de la coupe
	public function categorie(){
		return ($this->_sexe == 'f') ? 'M'.$this->_age.' Fille' : 'M'.$this->_age.' Garçon';
	}

	//cette fonction renvoie la catégorie inférieur à la coupe 
	public function ageInf(){
		switch ($this->_age) {
			case 17:
				return 15;
			case 20:
				return 17;
			default:
				return 13;
		}
	}

	//cette fonction renvoie la 5eme année celle de la coupe
	public function anneeAnt(){
		return $this->_annee - 5;
	}

	//cette fonction permet de retourner la base des noms de poules pour cette coupe
	public function coupeVersPoule(){
		$nomPoule = "";

		switch ($this->_age) {
			case 13:
				$nomPoule = "B";
				break;
			case 15:
				$nomPoule = "M";
				break;
			case 17:
				$nomPoule = "C";
				break;
			case 20:
				$nomPoule = "J";
				break;
			default:
				break;
		}

		return ($this->_sexe == 'f') ? $nomPoule . "FA" : $nomPoule . "MA";
	}
}

?>
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
* Nom : critere.php
* Chemin abs : site\modele\
* Information : page permettant de gérer les objets critere et classifier
*
*/

class Critere{

	private $_id;
	private $_nom;
	private $_description;
	private $_type;
	private $_valeur;
	private $_requete;

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
		    case 2:
		        $this->setId($args[0]);
		        $this->setDescription($args[1]);
		        break;
		    case 3:
		        $this->setId($args[0]);
		        $this->setValeur($args[1]);
		        $this->setRequete($args[2]);
		        break;
		    default:
		        break;
		}
	}

	//getter
	public function id(){ return $this->_id; }
	public function nom(){ return $this->_nom; }
	public function description(){ return $this->_description; }
	public function type(){ return $this->_type; }
	public function valeur(){ return $this->_valeur; }
	public function requete(){ return $this->_requete; }

	//setter
	public function setId($id)
	{
		$this->_id = (int) $id;
	}

	public function setNom($nom)
	{
		$this->_nom = (String) $nom;
	}

	public function setDescription($desc)
	{
		$this->_description = (String) $desc;
	}

	public function setType($type)
	{
		$this->_type = (String) $type;
	}

	public function setValeur($valeur)
	{
		$this->_valeur = (int) $valeur;
	}

	public function setRequete($requete)
	{
		$this->_requete = (String) $requete;
	}


	public function comparer($id, $value)
	{
		if($this->_id == $id && $this->_valeur == $value){
			return true;
		}

		return false;
	}
}

?>
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
* Nom : club.php
* Chemin abs : site\modele\
* Information : page permettant de gérer les objets club
*
*/

class Club{

	private $_id;
	private $_nom;
	private $_ville;     // peut être remplacé par une distance dans certains cas
	private $_commite;
	private $_region;
	private $_distance;

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
		        $this->setNom($args[1]);
		        break;
		    case 3:
		        $this->setId($args[0]);
		        $this->setVille($args[1]);
		        $this->setCommite($args[2]);
		        break;
		    case 5:
		        $this->setId($args[0]);
		        $this->setNom($args[1]);
		        $this->setVille($args[2]);
		        $this->setCommite($args[3]);
		        $this->setRegion($args[4]);
		        break;
		    case 6:
		        $this->setId($args[0]);
		        $this->setNom($args[1]);
		        $this->setCommite($args[2]);
		        $this->setRegion($args[3]);
		        $this->setDistance($args[4]);
		        $this->setVilleDistance($args[5], $args[4]);
		        break;
		     default:
		        break;
		}
	}

	//getter
	public function id(){ return $this->_id; }
	public function nom(){ return $this->_nom; }
	public function ville(){ return $this->_ville; }
	public function commite(){ return $this->_commite; }
	public function region(){ return $this->_region; }
	public function distance(){ return $this->_distance; }

	//setter
	public function setId($id)
	{
		$this->_id = (int) $id;
	}

	public function setNom($nom)
	{
		$this->_nom = (String) $nom;
	}

	public function setVille($ville)
	{
		$this->_ville = (String) $ville;
	}

	public function setCommite($commite)
	{
		$this->_commite = (String) $commite;
	}

	public function setRegion($region)
	{
		$this->_region = (String) $region;
	}

	public function setDistance($distance)
	{
		$this->_distance = (int) $distance;
	}

	public function setVilleDistance($ville, $distance)
	{
		$this->_ville = (String) $distance.' - '.$ville;
	}
}

?>
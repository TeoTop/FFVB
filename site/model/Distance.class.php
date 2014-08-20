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
* Nom : distance.php
* Chemin abs : site\modele\
* Information : page permettant de gérer la distance entre les villes
*
*/
?>

<?php

class Distance{

	private $_id;
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
		        $this->setDistance($args[1]);
		        break;
		     default:
		        break;
		}
	}

	//getter
	public function id(){ return $this->_id; }
	public function distance(){ return $this->_distance; }
	
	//setter
	public function setId($id)
	{
		$this->_id = (int) $id;
	}

	public function setDistance($distance)
	{
		$this->_distance = $distance;
	}
}

?>
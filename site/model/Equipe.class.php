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
* Nom : equipe.php
* Chemin abs : site\modele\
* Information : page permettant de gérer les objets equipe
*
*/

class Equipe{

	private $_id;
	private $_club;
	private $_coupe;
	private $_nbKmParcouru;
	private $_classementCFVB;
	private $_classementCoupe;

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
		        $this->setClub($args[1]);
		        break;
		    case 5:
		        $this->setId($args[0]);
		        $this->setClub($args[1]);
		        $this->setNbKmParcouru($args[2]);
		        $this->setClassementCFVB($args[3]);
		        $this->setClassementCoupe($args[4]);
		        break;
		     default:
		        break;
		}
	}

	//getter
	public function id(){ return $this->_id; }
	public function club(){ return $this->_club; }
	public function coupe(){ return $this->_coupe; }
	public function nbKmParcouru(){ return $this->_nbKmParcouru; }
	public function classementCFVB(){ return $this->_classementCFVB; }
	public function classementCoupe(){ return $this->_classementCoupe; }

	//setter
	public function setId($id)
	{
		$this->_id = (int) $id;
	}

	public function setClub(Club $club)
	{
		$this->_club = $club;
	}

	public function setCoupe(Coupe $coupe)
	{
		$this->_coupe = $coupe;
	}

	public function setNbKmParcouru($km)
	{
		$this->_nbKmParcouru = (int) $km;
	}

	public function setClassementCFVB($classementCFVB)
	{
		$this->_classementCFVB = (int) $classementCFVB;
	}

	public function setClassementCoupe($classementCoupe)
	{
		$this->_classementCoupe = (int) $classementCoupe;
	}


	//permet de faire la comparaison les ID entre deux tableaux d'objets equipe
	// permet la suppression des ID du premier tableau si ceux-ci sont dans le deuxieme (voir array_udiff()
	static public function comp_func_equipe($a, $b){
		
		if ($a->_id == $b->_id)	return 0;
        
        return ($a->_id > $b->_id) ? 1 : -1;
	}
}

?>
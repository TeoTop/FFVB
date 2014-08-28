<?php 
/*
*
* Créer par : CHAPON Théo
*
*/

/*
*
* Information sur la page :
* Nom : tour.php
* Chemin abs : site\modele\
* Information : page permettant de gérer les objets tour
*
*/

class Tour{

	private $_id;
	private $_coupe;
	private $_numero;
	private $_dateTour;

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
				$this->setNumero($args[1]); 
		        break;
		    case 3:
		        $this->setId($args[0]); 
				$this->setNumero($args[1]);
				$this->setDateTour($args[2]); 
		        break;
		    case 4:
		        $this->setId($args[0]); 
				$this->setCoupe($args[1]); 
				$this->setNumero($args[2]); 
				$this->setDateTour($args[3]); 
		        break;
		     default:
		        break;
		}
	}

	//getter
	public function id(){ return $this->_id; }
	public function coupe(){ return $this->_coupe; }
	public function numero(){ return $this->_numero; }
	public function dateTour(){ return $this->_dateTour; }

	//setter
	public function setId($id)
	{
		// L'identifiant du personnage sera, quoi qu'il arrive, un nombre entier.
		$this->_id = (int) $id;
	}

	public function setCoupe(Coupe $coupe)
	{
		$this->_coupe = $coupe;
	}

	public function setNumero($numero)
	{
		$this->_numero = (int) $numero;
	}

	public function setDateTour($dateTour)
	{
		$this->_dateTour = $dateTour;
	}

	//cette fonction true si l'id correspond
	public function memeId(Tour $tour){
		return ($this->_id == $tour->_id) ? true : false;
	}
}

?>
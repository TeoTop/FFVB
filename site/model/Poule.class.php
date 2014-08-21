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
* Nom : poule.php
* Chemin abs : site\modele\
* Information : page permettant de gérer les objets poule
*
*/

class Poule{

	private $_id;
	private $_tour;
	private $_nom;
	

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
		     default:
		        break;
		}
	}

	//getter
	public function id(){ return $this->_id; }
	public function tour(){ return $this->_tour; }
	public function nom(){ return $this->_nom; }

	//setter
	public function setId($id)
	{
		// L'identifiant du personnage sera, quoi qu'il arrive, un nombre entier.
		$this->_id = (int) $id;
	}

	public function setTour($tour)
	{
		$this->_tour = (int) $tour;
	}

	public function setNom($nom)
	{
		$this->_nom = (String) $nom;
	}



	//cette fonction true si l'id correspond
	public function memeId(Poule $poule){
		return ($this->_id == $poule->_id) ? true : false;
	}


	//cette fonction permet de créer un nouveau nom de poule en fonction de la dernière poule utilisée
	public function nouveauNom(){
		$nom = str_split($this->_nom); //on récupère le nom de poule en tableau pour traiter chaque élément

		switch (ord($nom[2])) {  //on rgarde le numero de la poule pour créer le nouveau nom
			case 90:  //equivaut à Z en ASCII
				$nom[2] = "0";
				break;
			case 57:  //equivaut à 9 en ASCII
				($nom[1] == 'F') ? $nom[1] = 'G' : $nom[1] = 'X';   //on doit modifier la lettre de sexe sinon des poules auront le meme nom
				$nom[2] = "A";                                         // on recommence la numerotation des poules depuis le début
				break;
			default:
				$nom[2] = chr(ord($nom[2]) + 1);    // on fait avancer la numerotation
				break;
		}

		return implode('', $nom);
	}

}

?>
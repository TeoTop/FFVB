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
* Nom : equipeManager.php
* Chemin abs : site\modele\
* Information : page permettant de gérer les objets equipe et equipe supprimée provenant de la base de données
*
*/


class EquipeManager{

	private $_db;

	//constructeur
	public function __construct()
	{
		$this->setDb(ouvre_base()); // ouvre_base se situe dans le fichier bdd.php -> permet de créer une connexion PDO avec la base puis la retourne
	}

	//setter
	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}


	//retourne la liste des equipes qualifier pour ce tour
	public function equipesTour($tour)
	{
		$equipes = array();

		//requete SQL avec argument :tour
		$q = $this->_db->prepare('SELECT `id_equipe`,`club`, `nom` FROM `equipe` 
			JOIN `club` ON `id_club` = `club`  
			WHERE `id_equipe` in ( 
				SELECT `equipe` FROM `resultat` WHERE `tour` = :tour 
			) ORDER BY `nom`');

		$q->bindValue(':tour', $tour, PDO::PARAM_INT);

		$q->execute();

		//recupération des valeurs et création des objets
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$club = new Club($donnees['club'], $donnees['nom']);
			$equipes[$donnees['id_equipe']] = new Equipe($donnees['id_equipe'], $club);
		}


		return $equipes;
	}


	//retourne la liste des equipes qualifier pour ce tour
	public function equipesPoules($tour)
	{
		$equipes = array();

		//requete SQL avec argument :tour
		$q = $this->_db->prepare('SELECT cb.`nom`, pl.`nom` as `nomPoule` FROM `equipe` 
			JOIN `club` cb ON `id_club` = `club`
			JOIN `jouer` ON `equipe` = `id_equipe`
			JOIN `poule` pl ON `id_poule` = `poule`   
			WHERE `tour` = :tour');

		$q->bindValue(':tour', $tour, PDO::PARAM_INT);

		$q->execute();

		//recupération des valeurs et création des objets
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$equipes[$donnees['nomPoule']][] = $donnees['nom'];
		}


		return $equipes;
	}


	//retourne la liste des noms des equipes exemptées pour ce tour
	public function equipesExemptesNom($tour)
	{
		$equipes = array();

		//requete SQL avec argument :tour
		$q = $this->_db->prepare('SELECT `nom` FROM `exempter` 
			JOIN `equipe` ON `id_equipe` = `equipe` 
			JOIN `club` ON `id_club` = `club` 
			WHERE `tour` = :tour 
			ORDER BY `nom`');

		$q->bindValue(':tour', $tour, PDO::PARAM_INT);
		$q->execute();

		//recupération des valeurs et création des objets
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$equipes[] = $donnees['nom'];
		}


		return $equipes;
	}

	
	public function tourPrecedent($tour)
	{
		$tourPrc = -1;

		$q = $this->_db->prepare('SELECT `id_tour` FROM `tour` 
			WHERE `coupe` IN (
				SELECT `coupe` FROM `tour` WHERE `id_tour` = :tour
			) AND `numero` IN (
				SELECT `numero`-1 FROM `tour` WHERE `id_tour` = :tour
			)');
		
		$q->bindValue(':tour', $tour, PDO::PARAM_INT);
		$q->execute();

		//recupération des valeurs et création des objets
		if ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$tourPrc = $donnees['id_tour'];
		}

		return $tourPrc;
	}


	//permet de retourner les équipes correspond aux critères transmis (pour DOMICILE et EXEMPTER)
	public function equipesSelonCritere($criteres, $tour)
	{
		$equipesCritere = array();
		$tourPrcd = $this->tourPrecedent($tour->id());

		$requete = 'SELECT `id_equipe`,`club`, `nbKmParcouru`, `classementCFVB`, `classementCoupe`, `nom`, `ville`, `commite`, `region` FROM `equipe` 
			JOIN `club` ON `id_club` = `club`
			WHERE `id_equipe` IN (
				SELECT `equipe` FROM `resultat` WHERE `tour` = :tour AND `equipe` NOT IN (
					SELECT `equipe` FROM `jouer` WHERE `poule` IN (
                		SELECT `id_poule` FROM `poule` WHERE `tour` = :tour
            		)
				)
				AND `equipe` NOT IN (
					SELECT `equipe` FROM `exempter` WHERE `tour` = :tour
				)
			)';

		foreach ($criteres as $key => $critere) {
			$requete = $requete . $critere->requete();
		}


		$requete = $requete . ' ORDER BY nom';

		$q = $this->_db->prepare($requete);
		
		$q->bindValue(':tour', $tour->id(), PDO::PARAM_INT);

		foreach ($criteres as $key => $critere) {
			if ($critere->id() == 1 || $critere->id() == 3) $q->bindValue(':tourPrcd', $tourPrcd, PDO::PARAM_INT);
			if ($critere->id() == 2) $q->bindValue(':dateTour', $tour->dateTour(), PDO::PARAM_STR);
			if ($critere->id() == 4 || $critere->id() == 20) $q->bindValue(':clmtCFVB', $critere->valeur(), PDO::PARAM_INT);
			if ($critere->id() == 5){
				$q->bindValue(':nbEquipe', $critere->valeur(), PDO::PARAM_INT);
				$q->bindValue(':annee', $tour->coupe()->annee(), PDO::PARAM_INT);
			}
			if ($critere->id() == 6){
				$q->bindValue(':nbDomicile', $critere->valeur(), PDO::PARAM_INT);
				$q->bindValue(':annee', $tour->coupe()->annee(), PDO::PARAM_INT);
			}
			if ($critere->id() == 12 || $critere->id() == 16) $q->bindValue(':clmtCoupe', $critere->valeur(), PDO::PARAM_INT);
			if ($critere->id() == 13){
				$q->bindValue(':age', $tour->coupe()->age(), PDO::PARAM_INT);
				$q->bindValue(':sexe', $tour->coupe()->sexe(), PDO::PARAM_STR);
				$q->bindValue(':anneeAnt', $tour->coupe()->anneeAnt(), PDO::PARAM_INT);
			}
			if ($critere->id() == 14){
				$q->bindValue(':ageInf', $tour->coupe()->ageInf(), PDO::PARAM_INT);
				$q->bindValue(':sexe', $tour->coupe()->sexe(), PDO::PARAM_STR);
				$q->bindValue(':anneeAnt', $tour->coupe()->anneeAnt(), PDO::PARAM_INT);
			}
			if ($critere->id() == 15) $q->bindValue(':distanceMin', $critere->valeur(), PDO::PARAM_INT);
			if ($critere->id() == 17) $q->bindValue(':nbKm', $critere->valeur(), PDO::PARAM_INT);
			if ($critere->id() == 21) $q->bindValue(':coupe', $tour->coupe()->id(), PDO::PARAM_INT);
		}
		
		$q->execute();

		//recupération des valeurs et création des objets
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$club = new Club($donnees['club'], $donnees['nom'], $donnees['ville'], $donnees['commite'], $donnees['region']);
			$equipesCritere[] = new Equipe($donnees['id_equipe'], $club, $donnees['nbKmParcouru'], $donnees['classementCFVB'], $donnees['classementCoupe']);
		}

		return $equipesCritere;
	}


	//permet de retourner les équipes correspond aux critères transmis pour EXTERIEUR
	public function equipesSelonCritereExt($criteres, $tour, $equipes)
	{
		$equipesCritere = array();
		$tourPrcd = $this->tourPrecedent($tour->id());

		$requete = 'SELECT `id_equipe`,`club`, `nbKmParcouru`, `classementCFVB`, `classementCoupe`, `nom`, `ville`, `distance`, `commite`, `region` FROM `equipe` 
			JOIN `club` ON `id_club` = `club`
			JOIN `parcourir` ON ( (`clubDomicile` = `id_club` AND `clubExterieur` = :club) OR (`clubExterieur` = `id_club` AND `clubDomicile` = :club)) 
			WHERE `id_equipe` IN (
				SELECT `equipe` FROM `resultat` WHERE `tour` = :tour AND `equipe` NOT IN (
					SELECT `equipe` FROM `jouer` WHERE `poule` IN (
                		SELECT `id_poule` FROM `poule` WHERE `tour` = :tour
            		)
				)
				AND `equipe` NOT IN (
					SELECT `equipe` FROM `exempter` WHERE `tour` = :tour
				)
			)';


		foreach ($criteres as $key => $critere) {
		
			if ($critere->id() == 9) {
				
				$requete = $requete . $critere->requete();

				foreach ($equipes as $key => $equipe) {
					if($key != 0){
						$requete = $requete . ' OR `equipe` = ';
					}
					$requete = $requete . ':equipe' . $key;
				}

				$requete = $requete . '))';
				
			} else if ($critere->id() == 10) {
				
				foreach ($equipes as $key => $equipe) {
					$requete = $requete . $critere->requete() . ' :commite' . $key;
				}
				
			} else {
				$requete = $requete . $critere->requete();
			}
		}


		$requete = $requete . ' ORDER BY nom';

		$q = $this->_db->prepare($requete);
		
		$q->bindValue(':club', $equipes[0]->club()->id(), PDO::PARAM_INT);
		$q->bindValue(':tour', $tour->id(), PDO::PARAM_INT);

		foreach ($criteres as $key => $critere) {
			if ($critere->id() == 7) {
				$q->bindValue(':tourPrcd', $tourPrcd, PDO::PARAM_INT);
				$q->bindValue(':position', $critere->valeur(), PDO::PARAM_INT);
			}
			if ($critere->id() == 8) $q->bindValue(':clmtCoupe', $critere->valeur(), PDO::PARAM_INT);
			if ($critere->id() == 9) {
				foreach ($equipes as $key => $equipe) {
					$q->bindValue(':equipe' . $key, $equipes[0]->id(), PDO::PARAM_INT);
				}
			}
			if ($critere->id() == 10) {
				foreach ($equipes as $key => $equipe) {
					$q->bindValue(':commite' . $key, $equipes[0]->club()->commite(), PDO::PARAM_STR);
				}
			}
			if ($critere->id() == 11) $q->bindValue(':distanceClub', $critere->valeur(), PDO::PARAM_INT);
			if ($critere->id() == 18) $q->bindValue(':clmtCFVB', $critere->valeur(), PDO::PARAM_INT);
			if ($critere->id() == 19) $q->bindValue(':nbKm', $critere->valeur(), PDO::PARAM_INT);
		}
		
		$q->execute();

		//recupération des valeurs et création des objets
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$club = new Club($donnees['club'], $donnees['nom'], $donnees['commite'], $donnees['region'], $donnees['distance'], $donnees['ville']);
			$equipesCritere[] = new Equipe($donnees['id_equipe'], $club, $donnees['nbKmParcouru'], $donnees['classementCFVB'], $donnees['classementCoupe']);
		}

		return $equipesCritere;
	}


	//retourne la liste des equipes qualifier pour ce tour
	public function equipesPoule($poule)
	{
		$equipes = array();

		//requete SQL avec argument :tour
		$q = $this->_db->prepare('SELECT `id_equipe`, `club`, `nbKmParcouru`, `classementCFVB`, `classementCoupe`, `nom`, `ville`, `distance`, `commite`, `region` FROM `jouer` 
			JOIN `equipe` ON `id_equipe` = `equipe` 
			JOIN `club` ON `id_club` = `club`
			WHERE `poule` = :poule 
			ORDER BY `distance`');

		$q->bindValue(':poule', $poule, PDO::PARAM_INT);
		$q->execute();

		//recupération des valeurs et création des objets
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			if($donnees['distance'] == NULL){
				$club = new Club($donnees['club'], $donnees['nom'], $donnees['ville'], $donnees['commite'], $donnees['region']);
			} else {
				$club = new Club($donnees['club'], $donnees['nom'], $donnees['distance'], $donnees['commite'], $donnees['region']);
			}

			$equipes[] = new Equipe($donnees['id_equipe'], $club, $donnees['nbKmParcouru'], $donnees['classementCFVB'], $donnees['classementCoupe']);
		}


		return $equipes;
	}


	//retourne la liste des equipes exempter pour ce tour
	public function equipesExempte($tour)
	{
		$equipes = array();

		//requete SQL avec argument :tour
		$q = $this->_db->prepare('SELECT `id_equipe`,`club`, `nbKmParcouru`, `classementCFVB`, `classementCoupe`, `nom`, `ville`, `commite`, `region` FROM `exempter` 
			JOIN `equipe` ON `id_equipe` = `equipe` 
			JOIN `club` ON `id_club` = `club` 
			WHERE `tour` = :tour 
			ORDER BY `nom`');

		$q->bindValue(':tour', $tour, PDO::PARAM_INT);
		$q->execute();

		//recupération des valeurs et création des objets
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$club = new Club($donnees['club'], $donnees['nom'], $donnees['ville'], $donnees['commite'], $donnees['region']);
			$equipes[] = new Equipe($donnees['id_equipe'], $club, $donnees['nbKmParcouru'], $donnees['classementCFVB'], $donnees['classementCoupe']);
		}


		return $equipes;
	}


	//retourne la distance entre les deux équipes.
	public function recupererDistance($clubDom, $equipeExt)
	{
		$resultat = NULL;
		$clubExt;

		//requete SQL avec argument :tour
		$q = $this->_db->prepare('SELECT `club` FROM `equipe` WHERE `id_equipe` = :equipe');

		$q->bindValue(':equipe', $equipeExt, PDO::PARAM_INT);
		$q->execute();

		//recupération des valeurs et création des objets
		if($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$clubExt = $donnees['club'];
		}


		//requete SQL avec argument :tour
		$q = $this->_db->prepare('SELECT `distance` FROM `parcourir` WHERE
			 (`clubDomicile` = :clubDom AND `clubExterieur` = :clubExt) OR
			 (`clubDomicile` = :clubExt AND `clubExterieur` = :clubDom)');

		$q->bindValue(':clubDom', $clubDom, PDO::PARAM_INT);
		$q->bindValue(':clubExt', $clubExt, PDO::PARAM_INT);
		$q->execute();

		//recupération des valeurs et création des objets
		if($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$resultat = $donnees['distance'];
		}

		return $resultat;
	}


	//retourne la poule si l'équipe figure dans une poule, NULL sinon.
	public function dansPoule($equipe, $tour)
	{
		$resultat = NULL;

		//requete SQL avec argument :tour
		$q = $this->_db->prepare('SELECT `poule` FROM `jouer` 
				WHERE `equipe` = :equipe AND `poule` in (
                	SELECT `id_poule` FROM `poule` WHERE `tour` = :tour
            	)');

		$q->bindValue(':equipe', $equipe, PDO::PARAM_INT);
		$q->bindValue(':tour', $tour, PDO::PARAM_INT);
		$q->execute();

		//recupération des valeurs et création des objets
		if($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$resultat = $donnees['poule'];
		}


		return $resultat;
	}


	//retourne vrai si l'équipe figure parmis les exemptées, faux sinon.
	public function dansExempter($equipe, $tour)
	{
		//requete SQL avec argument :tour
		$q = $this->_db->prepare('SELECT `equipe` FROM `exempter` WHERE `equipe` = :equipe AND `tour` = :tour');

		$q->bindValue(':equipe', $equipe, PDO::PARAM_INT);
		$q->bindValue(':tour', $tour, PDO::PARAM_INT);
		$q->execute();

		//recupération des valeurs et création des objets
		if($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			return true;
		}


		return false;
	}






	//retourne les id des équipes qui ne sont pas classées dans une poule ou exemptées
	public function equipeNonClassee($tour)
	{
		$equipes = array();

		//requete SQL avec argument :tour
		$q = $this->_db->prepare('SELECT `equipe` FROM `resultat` WHERE `tour` = :tour 
			AND `equipe` NOT IN (
				SELECT `equipe` FROM `exempter` WHERE `tour` = :tour
			) AND `equipe` NOT IN (
				SELECT `equipe` FROM `jouer` WHERE `poule` IN (
					SELECT `id_poule` FROM `poule` WHERE `tour` = :tour 
				)
			)');


		$q->bindValue(':tour', $tour, PDO::PARAM_INT);
		$q->execute();

		//recupération des valeurs et création des objets
		while($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$equipes[] = $donnees['equipe'];
		}


		return $equipes;
	}



	//permet de retourner les équipes correspond aux critères transmis (pour DOMICILE et EXEMPTER)
	public function verifierDomicile($criteres, $tour)
	{
		$erreurEquipes = array();
		$tourPrcd = $this->tourPrecedent($tour->id());

		$requeteBase = 'SELECT `id_equipe`, `poule` FROM `equipe` JOIN `jouer` ON `equipe` = `id_equipe`
			WHERE `distance` IS NULL AND `poule` IN (
				SELECT `id_poule` FROM `poule` WHERE `tour` = :tour
			)';


		foreach ($criteres as $key => $critere) {
			
			$requete = $requeteBase . $critere->requete();

			$q = $this->_db->prepare($requete);

			$q->bindValue(':tour', $tour->id(), PDO::PARAM_STR);


			if ($critere->id() == 1 || $critere->id() == 3) $q->bindValue(':tourPrcd', $tourPrcd, PDO::PARAM_INT);
			if ($critere->id() == 2) {
				$q->bindValue(':dateTour', $tour->dateTour(), PDO::PARAM_STR);
				$q->bindValue(':coupe', $tour->coupe()->id(), PDO::PARAM_INT);
			}
			if ($critere->id() == 4) $q->bindValue(':clmtCFVB', $critere->valeur(), PDO::PARAM_INT);
			if ($critere->id() == 5){
				$q->bindValue(':nbEquipe', $critere->valeur(), PDO::PARAM_INT);
				$q->bindValue(':tour', $tour->id(), PDO::PARAM_INT);
				$q->bindValue(':annee', $tour->coupe()->annee(), PDO::PARAM_INT);
			}
			if ($critere->id() == 6){
				$q->bindValue(':nbDomicile', $critere->valeur(), PDO::PARAM_INT);
				$q->bindValue(':annee', $tour->coupe()->annee(), PDO::PARAM_INT);
			}
			if ($critere->id() == 16) $q->bindValue(':clmtCoupe', $critere->valeur(), PDO::PARAM_INT);
 			if ($critere->id() == 17) $q->bindValue(':nbKm', $critere->valeur(), PDO::PARAM_INT);


			$q->execute();

			//recupération des valeurs et création des objets
			while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
			{
				$erreurEquipes[' '.$donnees['poule']][' '.$donnees['id_equipe']][0] = true;
				$erreurEquipes[' '.$donnees['poule']][' '.$donnees['id_equipe']][$critere->id()] = $critere->valeur();
			}

		}


		return $erreurEquipes;
	}


	//permet de retourner les équipes correspond aux critères transmis pour EXTERIEUR
	public function verifierExterieur($criteres, $tour, $poule, $equipes)
	{
		$erreurEquipes = array();
		$tourPrcd = $this->tourPrecedent($tour->id());

		$requeteBase = 'SELECT `id_equipe` FROM `equipe` 
			JOIN `club` ON `id_club` = `club`
			JOIN `parcourir` ON ( (`clubDomicile` = `id_club` AND `clubExterieur` = :club) OR (`clubExterieur` = `id_club` AND `clubDomicile` = :club)) 
			WHERE `id_equipe` IN (
				SELECT `equipe` FROM `jouer` WHERE `poule` = :poule AND `distance` IS NOT NULL
			)';

		foreach ($criteres as $key => $critere) {
		
			if ($critere->id() == 10) {
				
				$requete = $requeteBase;

				foreach ($equipes as $key => $equipe) {
					$requete = $requete . $critere->requete() . ' :commite' . $key;
				}
				
			} else {
				$requete = $requeteBase . $critere->requete();
			}


			$q = $this->_db->prepare($requete);
		
			$q->bindValue(':club', $equipes[0]->club()->id(), PDO::PARAM_INT);
			$q->bindValue(':poule', $poule, PDO::PARAM_INT);

		
			if ($critere->id() == 8) $q->bindValue(':clmtCoupe', $critere->valeur(), PDO::PARAM_INT);
			if ($critere->id() == 10) {
				foreach ($equipes as $key => $equipe) {
					$q->bindValue(':commite' . $key, $equipes[0]->club()->commite(), PDO::PARAM_STR);
				}
			}
			if ($critere->id() == 11) $q->bindValue(':distanceClub', $critere->valeur(), PDO::PARAM_INT);
			if ($critere->id() == 18) $q->bindValue(':clmtCFVB', $critere->valeur(), PDO::PARAM_INT);
			if ($critere->id() == 19) $q->bindValue(':nbKm', $critere->valeur(), PDO::PARAM_INT);


			if ($critere->id() == 7) {
				
				foreach ($equipes as $key => $equipe) {
					
					$requete = $critere->requete();

					$q = $this->_db->prepare($requete);

					$q->bindValue(':tourPrcd', $tourPrcd, PDO::PARAM_INT);
					$q->bindValue(':equipe', $equipe->id(), PDO::PARAM_INT);

					$q->execute();

					$position = 0;
					$count = 0;
					//recupération des valeurs et création des objets
					if ($donnees = $q->fetch(PDO::FETCH_ASSOC)){
						if($key == 0){
							$position = $donnees['classementPoule'];
						} else{
							if($position == $donnees['classementPoule']) $count++;
						}
					}
				}

				if($count >= 2){
					$erreurEquipes[' '.$equipes[1]->id()][0] = true;
					$erreurEquipes[' '.$equipes[1]->id()][$critere->id()] = $critere->valeur();
					$erreurEquipes[' '.$equipes[2]->id()][0] = true;
					$erreurEquipes[' '.$equipes[2]->id()][$critere->id()] = $critere->valeur();
				}

			} else if ($critere->id() == 9) {
				
				foreach ($equipes as $key1 => $equipe1) {
					foreach ($equipes as $key2 => $equipe2) {
						if($key1 != $key2){

							$requete = $critere->requete() . " `equipe` = :equipe" . $key1 . " AND `equipe` = :equipe" . $key2 . ")";

							$q = $this->_db->prepare($requete);

							$q->bindValue(':tour', $tour->id(), PDO::PARAM_INT);
							$q->bindValue(':equipe'.$key1, $equipe1->id(), PDO::PARAM_INT);
							$q->bindValue(':equipe'.$key2, $equipe2->id(), PDO::PARAM_INT);

							$q->execute();

							if($donnees = $q->fetch(PDO::FETCH_ASSOC)){
								$erreurEquipes[' '.$equipes1->id()][0] = true;
								$erreurEquipes[' '.$equipes1->id()][$critere->id()] = $critere->valeur();
								$erreurEquipes[' '.$equipes2->id()][0] = true;
								$erreurEquipes[' '.$equipes2->id()][$critere->id()] = $critere->valeur();
							}
						}
					}
				}

			} else {
				$q->execute();

				//recupération des valeurs et création des objets
				while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
				{
					$erreurEquipes[' '.$donnees['id_equipe']][0] = true;
					$erreurEquipes[' '.$donnees['id_equipe']][$critere->id()] = $critere->valeur();
				}
			}
		}


		return $erreurEquipes;
	}


	//permet de retourner les équipes correspond aux critères transmis (pour DOMICILE et EXEMPTER)
	public function verifierExempter($criteres, $tour)
	{
		$erreurEquipes = array();
		$tourPrcd = $this->tourPrecedent($tour->id());

		$requeteBase = 'SELECT `id_equipe` FROM `equipe` JOIN `club` ON `id_club` = `club`
			WHERE `id_equipe` IN (
				SELECT `equipe` FROM `exempter` WHERE `tour` = :tour
			)';

		foreach ($criteres as $key => $critere) {
			
			$requete = $requeteBase . $critere->requete();

			$q = $this->_db->prepare($requete);
		
			$q->bindValue(':tour', $tour->id(), PDO::PARAM_INT);


			if ($critere->id() == 12) $q->bindValue(':clmtCoupe', $critere->valeur(), PDO::PARAM_INT);
			if ($critere->id() == 13){
				$q->bindValue(':age', $tour->coupe()->age(), PDO::PARAM_INT);
				$q->bindValue(':sexe', $tour->coupe()->sexe(), PDO::PARAM_STR);
				$q->bindValue(':anneeAnt', $tour->coupe()->anneeAnt(), PDO::PARAM_INT);
			}
			if ($critere->id() == 14){
				$q->bindValue(':ageInf', $tour->coupe()->ageInf(), PDO::PARAM_INT);
				$q->bindValue(':sexe', $tour->coupe()->sexe(), PDO::PARAM_STR);
				$q->bindValue(':anneeAnt', $tour->coupe()->anneeAnt(), PDO::PARAM_INT);
			}
			if ($critere->id() == 15) $q->bindValue(':distanceMin', $critere->valeur(), PDO::PARAM_INT);
			if ($critere->id() == 20) $q->bindValue(':clmtCFVB', $critere->valeur(), PDO::PARAM_INT);
 			if ($critere->id() == 21){
 				$q->bindValue(':coupe', $tour->coupe()->id(), PDO::PARAM_INT);
 				$q->bindValue(':tour', $tour->id(), PDO::PARAM_INT);
 			}


 			$q->execute();

 			//recupération des valeurs et création des objets
			while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
			{
				$erreurEquipes[' '][' '.$donnees['id_equipe']][0] = true;
				$erreurEquipes[' '][' '.$donnees['id_equipe']][$critere->id()] = $critere->valeur();
			}

		}


		return $erreurEquipes;
	}
}

?>
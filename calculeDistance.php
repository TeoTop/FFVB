<?php


	function chargerClasseEditeur($classe)
    {
        require 'site/model/' . $classe . '.class.php'; // On inclut la classe correspondante au paramètre passé.
    }

    spl_autoload_register('chargerClasseEditeur');

    //on inclut le fichier gérant l'accés à la base
    require 'site/bdd.php';

    // on ouvre une connexion
    $bdd = ouvre_base();

    //pour revenir à la fin de la première salve d'insertion
    start:


    $clubs = array();

	//on récupère les clubs
	$q = $bdd->query('SELECT `id_club`, `ville`, `commite` FROM `club`');

	//recupération des données et création des objets
	while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
	{
		$clubs[] = new Club($donnees['id_club'], $donnees['ville'], $donnees['commite']);
	}

	$distances = array();

	//on récupère les distances déjà existantes dans la base
	$q = $bdd->query('SELECT `clubDomicile`, `clubExterieur` FROM `parcourir` ORDER BY `clubDomicile`');

	//recupération des données et création des objets
	while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
	{
		$distances[] = array(
			"domicile" => (int) $donnees['clubDomicile'], 
			"exterieur" => (int) $donnees['clubExterieur'], 
		);
	}



	$ok = true;
	$sec = 0;
	$recherche = array();

	// on double boucle sur chaque ville
	foreach ($clubs as $key1 => $club1) {
		foreach ($clubs as $key2 => $club2) {

			// on ne calcule qu'une distance, on insère uniquement (ville1 -> ville2) OU (ville2 -> ville1),
			// mais pas les deux et ne calcule pas le distance d'une ville avec elle-même d'où le >
			if($key2 > $key1){

				// si il n'y a aucune distance dans la base, ok est forcement faux
				if(empty($distances)) $ok = false;

				foreach ($distances as $cle => $distance) {
					
					// pour chaque distance, on vérifie si elle est dans la base (double vérification car 1 seul insertion entre 2 villes)
					if($club1->id() == $distance["domicile"] && $club2->id() == $distance["exterieur"]){
						$ok=true;
						break;
					} else if($club2->id() == $distance["domicile"] && $club1->id() == $distance["exterieur"]){
						$ok=true;
						break;
					} else {
						$ok = false;
					}

				}


				// si ok == faux
				if(!$ok){

					// le club est déjà dans la recherche comme club à domicile alors on ajoute les clubs exterieurs
					// voir en dessus pour la composition du tableau recherche 
					if(isset($recherche[$club1->id()])) {
						$recherche[$club1->id()]["exterieur"][] = $club2->id();
						$recherche[$club1->id()]["destination"] = $recherche[$club1->id()]["destination"].'|'.$club2->ville().'+'.$club2->commite();
					} else {
						// sinon on ajoute le club à domicile et le club exterieur
						$recherche[$club1->id()] = array(
							"origine" => $club1->ville().'+'.$club1->commite(),
							"exterieur" => array($club2->id()),
							"destination" => $club2->ville().'+'.$club2->commite()
						);

						//permet de vérifier le nombre d'élément envoyer car il y a une limite de la part de google
						$sec++;
					}

					$sec++;

					//on remet à true
					$ok = true;
				}

				if($sec >= 90)  break;
			}
		}

		if($sec >= 90)  break;
	}

	/*
		TABLEAU RECHERCHE

		array( 
			id de la ville à domicile => array(
					
					"origine" => composition de l'url pour l'origine de la requete pour google matrix

					"exterieur" => array(
						tableau des id des villes exterieurs vers la ville domicile
					)

					"destination" => composition de l'url pour les destinations de la requete pour google matrix
			)


		)
	*/

	

	$inc = 0;
	$stop = 0;

	// on boucle sur les équipes à domicile de la recherche
	foreach ($recherche as $key => $value) {
		$url = 'http://maps.googleapis.com/maps/api/distancematrix/json?origins='.$value["origine"].
			'&destinations='.$value["destination"].'&mode=driving&language=fr<br/>'; 

		//réponse de google ne JSON
		$response = json_decode(file_get_contents($url));

		// si la reponse est bonne
		if($response->{'status'} == "OK"){
			$idOrigine = $key;

			// on boucle sur chaque equipe exterieur car elles représente une insertion dans la base
			foreach ($value["exterieur"] as $key2 => $value) {
				$idDestination = $value;
				$distance = $response->{'rows'}[0]->{'elements'}[$key2]->{'distance'}->{'value'} / 1000;
				$distance = intval($distance);

				// on prépare la requete d'insertion
				$q = $bdd->prepare('INSERT INTO `parcourir`(`clubExterieur`, `clubDomicile`, `distance`) VALUES (:exterieur,:domicile,:distance)');
				
				$q->bindValue(':exterieur', $idDestination, PDO::PARAM_INT);
				$q->bindValue(':domicile', $idOrigine, PDO::PARAM_INT);
				$q->bindValue(':distance', $distance, PDO::PARAM_INT);

				// on ajoute
				$q->execute();

				echo $idOrigine.' vers '.$idDestination.' -- distance : '.$distance.'<br/>';
				$inc++;

			}
			echo '<br/>';
		} else {
			echo 'Une erreur c\'est produite : '.$response->{'status'}.'</br>';
		}
	}

	// nombre d'éléments insérés 
	echo $inc.' lignes ont été insérées dans la table parcourir';
	

	//vérification du nombre d'élément envoyer à goole durant les 10 dernières secondes et 24h
	// pour l'instant c'est inutile car google s'occupe automatique de l'arret de la requête en cas de dépassement
	if($inc >= 89){
		$stop += $inc;

		echo 'Attendez pour la suite des insertions';
		sleep ( 11 );

		if($stop <= 2403){
			goto start;
		}

		echo 'Attendez 24h pour exécuter la suite des insertions en relançant le script';
	}

?>
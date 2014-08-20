<?php
	function chargerClasseEditeur($classe)
    {
        require 'site/model/' . $classe . '.class.php'; // On inclut la classe correspondante au paramètre passé.
    }

    spl_autoload_register('chargerClasseEditeur');

    require 'site/bdd.php';

    $bdd = ouvre_base();



    $clubs = array();

	//requete SQL avec argument :coupe
	$q = $bdd->query('SELECT `id_club`, `ville`, `commite` FROM `club`');

	//recupération des données et création des objets
	while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
	{
		$clubs[] = new Club($donnees['id_club'], $donnees['ville'], $donnees['commite']);
	}



	$distances = array();

	//requete SQL avec argument :coupe
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

	foreach ($clubs as $key1 => $club1) {
		foreach ($clubs as $key2 => $club2) {
			if($key2 > $key1){

				foreach ($distances as $cle => $distance) {
					
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



				if(!$ok){
					if(isset($recherche[$club1->id()])) {
						$recherche[$club1->id()]["exterieur"][] = $club2->id();
						$recherche[$club1->id()]["destination"] = $recherche[$club1->id()]["destination"].'|'.$club2->ville().'+'.$club2->commite();
					} else {
						$recherche[$club1->id()] = array(
							"origine" => $club1->ville().'+'.$club1->commite(),
							"exterieur" => array($club2->id()),
							"destination" => $club2->ville().'+'.$club2->commite()
						);
						$sec++;
					}

					$sec++;
					$ok = true;
				}

				if($sec >= 90)  break;
			}
		}

		if($sec >= 90)  break;
	}
	
	//sleep ( 11 );
	$inc = 0;

	foreach ($recherche as $key => $value) {
		$url = 'http://maps.googleapis.com/maps/api/distancematrix/json?origins='.$value["origine"].
			'&destinations='.$value["destination"].'&mode=driving&language=fr<br/>'; 
		$response = json_decode(file_get_contents($url));

		if($response->{'status'} == "OK"){
			$idOrigine = $key;

			foreach ($value["exterieur"] as $key2 => $value) {
				$idDestination = $value;
				$distance = $response->{'rows'}[0]->{'elements'}[$key2]->{'distance'}->{'value'} / 1000;
				$distance = intval($distance);

				$q = $bdd->prepare('INSERT INTO `parcourir`(`clubExterieur`, `clubDomicile`, `distance`) VALUES (:exterieur,:domicile,:distance)');
				
				$q->bindValue(':exterieur', $idDestination, PDO::PARAM_INT);
				$q->bindValue(':domicile', $idOrigine, PDO::PARAM_INT);
				$q->bindValue(':distance', $distance, PDO::PARAM_INT);

				$q->execute();

				echo $idOrigine.' vers '.$idDestination.' -- distance : '.$distance.'<br/>';
				$inc++;

			}
			echo '<br/>';
		} else {
			echo 'Une erreur c\'est produite : '.$response->{'status'}.'</br>';
		}
	}

	echo $inc.' lignes ont été insérées dans la table parcourir';

?>
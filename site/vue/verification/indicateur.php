<?php 
/*
*
* Créer par : CHAPON Théo
* Date de modification : 06/08/2014
*
*/

/*
*
* Information sur la page :
* Nom : indicateur.php
* Chemin abs : site\vue\verification
* Information : page permettant d'afficher les erreurs de compostion de poule en fonction des critères utilisés
*
*
*/

//////////////// vérification général /////////////////

    $nbEquipe = count($equipes);
    $nbPouleCree = count($poules);
    $nbExempteCree = count($exemptees);

    $nbEquipeNecessaire = 0;
    $nbPouleNecessaire = 0;
    $repeche = 0;

    if($nbEquipe <= 8){
        $nbEquipeNecessaire = 6;
    } 
    else if($nbEquipe <= 12){
        $nbEquipeNecessaire = 12;
        $nbPouleNecessaire = 4;
    } 
    else if($nbEquipe <= 18){
        $nbEquipeNecessaire = 18;
        $nbPouleNecessaire = 6;
    } 
    else if($nbEquipe <= 27){
        $nbEquipeNecessaire = 27;
        $nbPouleNecessaire = 9;
    } 
    else if($nbEquipe <= 39){
        $nbEquipeNecessaire = 39;
        $nbPouleNecessaire = 13;
    } 
    else if($nbEquipe <= 57){
        $nbEquipeNecessaire = 57;
        $nbPouleNecessaire = 19;
    } 
    else if($nbEquipe <= 84){
        $nbEquipeNecessaire = 84;
        $nbPouleNecessaire = 28;
    }
    else if($nbEquipe <= 126){
        $nbEquipeNecessaire = 126;
        $nbPouleNecessaire = 42;
    }
    else if($nbEquipe <= 189){
        $nbEquipeNecessaire = 189;
        $nbPouleNecessaire = 63;
    }


    $nbPoule = $nbPouleNecessaire;
    $nbPoule4 = 0;
    $nbExempte = 0;

    if( $nbEquipe < $nbEquipeNecessaire ){
        $nbExempte = (($nbEquipeNecessaire - $nbEquipe) * 2);
        $nbPoule = ($nbEquipe - $nbExempte) / 3;
        
        $general = "<pre>- Il faut <b>".$nbPoule." poules</b> pour ce tour et <b>".$nbExempte." équipes exemptées</b>.</pre>\n";

        $verifExempte = $nbExempte - $nbExempteCree;
        if( $verifExempte < 0 ){
        	$general = $general . "<pre>- Il y a <b>".$verifExempte." exempté(s)</b> créée(s) en trop.</pre>\n";
        } else if( $verifExempte > 0 ){
        	$general = $general . "<pre>- Il manque <b>".$verifExempte." exempté(s)</b> pour avoir le bon nombre d'équipe au tour suivant.</pre>\n";
        }
    
    }
    else if( $nbEquipe > $nbEquipeNecessaire ){

        $nbPoule4 = $nbEquipe - $nbEquipeNecessaire;
        $general = "<pre>- Il faut <b>".$nbPoule4." poules</b> de 4 pour ce tour.</pre>\n";

    }
    else {

       	$general = "<pre>- Il faut <b>".$nbPoule." poules</b> pour ce tour.</pre>\n";

    }


    $verifPoule = $nbPoule - $nbPouleCree;
    if( $verifPoule < 0 ){
    	$general = $general . "<pre>- Il y a <b>".$verifPoule." poule(s)</b> créée(s) en trop.</pre>\n";
    } else if( $verifPoule > 0 ){
    	$general = $general . "<pre>- Il manque <b>".$verifPoule." poule(s)</b> pour avoir le bon nombre d'équipe au tour suivant.</pre>\n";
    }


?>

<div id="text">

<?php
if($_SESSION['poule'] == ''){
    echo "<span class=\"titreIndic\"><h3> &nbsp&nbsp Critères généraux : </h3></span>\n";
    echo $general;
    echo "<br/><span class=\"titreIndic\"><h3> &nbsp&nbsp Critères exemptés : </h3></span>\n";
    
    foreach ($_SESSION['erreurEquipes'][' '] as $keyE => $equipe) {
    	
    	if($keyE != 'erreur'){
    		foreach ($equipe as $key => $erreur) {
		    	
    			$cle = intval($keyE);

		    	if ($key == 12) echo "<pre>- L'équipe ".$equipes[$cle]->club()->nom()." ne possède pas au moins ".$erreur." points dans le classement de la coupe.</pre>\n";
				if ($key == 13) echo "<pre>- L'équipe ".$equipes[$cle]->club()->nom()." n'a pas gagné la coupe lors des 5 dernières années.</pre>\n";
				if ($key == 14) echo "<pre>- L'équipe ".$equipes[$cle]->club()->nom()." n'a pas gagné la coupe dans la catégorie inférieur lors de 5 dernières années.</pre>\n";
				if ($key == 15) echo "<pre>- L'équipe ".$equipes[$cle]->club()->nom()." n'est pas isolée, il y a au moins une équipe située à moins de ".$erreur." km.</pre>\n";
				if ($key == 20) echo "<pre>- L'équipe ".$equipes[$cle]->club()->nom()." ne possède pas au moins ".$erreur." points dans le classement CFVB.</pre>\n";
	 			if ($key == 21) echo "<pre>- L'équipe ".$equipes[$cle]->club()->nom()." a déjà été exemptée.</pre>\n";
			
			}
    	}
    	
    }
    
} else {
    echo "<span class=\"titreIndic\"><h3> &nbsp&nbsp Critères domiciles : </h3></span>\n";
    
    foreach ($_SESSION['erreurEquipes'][' '.$_SESSION['poule']->id()] as $keyE => $equipe) {
    	
    	if($keyE != 'erreur'){
    		foreach ($equipe as $key => $erreur) {
		    	
    			$cle = intval($keyE);

		    	if ($key == 1) echo "<pre>- L'équipe ".$equipes[$cle]->club()->nom()." a reçu au tour précédent.</pre>\n";
				if ($key == 2) echo "<pre>- Le club de ".$equipes[$cle]->club()->nom()." reçoit déjà dans une autre catégorie.</pre>\n";
				if ($key == 3) echo "<pre>- L'équipe ".$equipes[$cle]->club()->nom()." a été exemptée au tour précédent.</pre>\n";
				if ($key == 4) echo "<pre>- L'équipe ".$equipes[$cle]->club()->nom()." ne possède pas au plus ".$erreur." points dans le classement CFVB.</pre>\n";
				if ($key == 5) echo "<pre>- Le club de ".$equipes[$cle]->club()->nom()." ne possède pas au moins ".$erreur." équipes engagées en coupe de France.</pre>\n";
	 			if ($key == 6) echo "<pre>- L'équipe ".$equipes[$cle]->club()->nom()." a déjà reçu au moins ".$erreur." fois.</pre>\n";
	 			if ($key == 16) echo "<pre>- L'équipe ".$equipes[$cle]->club()->nom()." ne possède pas au moins ".$erreur." points dans le classement de la coupe.</pre>\n";
	 			if ($key == 17) echo "<pre>- L'équipe ".$equipes[$cle]->club()->nom()." a parcouru moins de ".$erreur." km depuis le début de la coupe.</pre>\n";
			}
    	}
    	
    }


    echo "<br/><span class=\"titreIndic\"><h3> &nbsp&nbsp Critères exterieurs : </h3></span>\n";
    
    foreach ($_SESSION['erreurEquipes'][' '.$_SESSION['poule']->id()] as $keyE => $equipe) {
    	
    	if($keyE != 'erreur'){
    		foreach ($equipe as $key => $erreur) {
		    	
    			$cle = intval($keyE);

		    	if ($key == 7) echo "<pre>- La poule ".$_SESSION['poule']->nom()." est constitué de trois équipes classés 1er/2nd au tour précédent.</pre>\n";
				if ($key == 8) echo "<pre>- L'équipe ".$equipes[$cle]->club()->nom()." ne possède pas au moins ".$erreur." points dans le classement de la coupe.</pre>\n";
				if ($key == 9) echo "<pre>- L'équipe ".$equipes[$cle]->club()->nom()." a déjà affronté une autre équipe présente dans la poule.</pre>\n";
				if ($key == 10) echo "<pre>- L'équipe ".$equipes[$cle]->club()->nom()." est du même département qu'une autre équipe présente dans la poule.</pre>\n";
				if ($key == 11) echo "<pre>- L'équipe ".$equipes[$cle]->club()->nom()." doit parcourir plus de ".$erreur." pour se rendre chez le receveur.</pre>\n";
	 			if ($key == 18) echo "<pre>- L'équipe ".$equipes[$cle]->club()->nom()." ne possède pas au plus ".$erreur." points dans le classement CFVB.</pre>\n";
	 			if ($key == 19) echo "<pre>- L'équipe ".$equipes[$cle]->club()->nom()." a parcouru plus de ".$erreur." km depuis le début de la coupe.</pre>\n";
			
			}
    	}
    	
    }
}

?>

</div>

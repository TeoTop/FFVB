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
* Nom : equipesCritere.php
* Chemin abs : site\vue\
* Information : page permettant de gérer l'affichage des équipes selon les critères
*
*
*/

if($_SESSION['critere']=='domicile'){
    include V . 'edition/equipeCritereDomicile.php';
} else if($_SESSION['critere']=='exterieur'){
    include V . 'edition/equipeCritereExterieur.php';
} else {
    include V . 'edition/equipeCritereExempter.php';
}

?>
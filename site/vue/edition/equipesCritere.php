<?php 
/*
*
* Créer par : CHAPON Théo
*
*/

/*
*
* Information sur la page :
* Nom : equipesCritere.php
* Chemin abs : site\vue\
* Information : page permettant de gérer l'affichage des équipes selon les critères
*
* TOUTES LES VARIABLES $coupes, $tours, $poules ET VARIABLES DE SESSION SONT CHARGEES SOIT DEPUIS editeur.php SOIT DEPUIS
* LA REQUETE AJAX PERMETTANT DE LE RECHARGEMENT DE CETTE PAGE (charger'Page'.php)
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
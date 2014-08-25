<?php 
/*
*
* Créer par : CHAPON Theo
* Date de modification : 09/08/2014
*
**/

/*
*
* Information sur la page :
* Nom : changerCriteres.php
* Chemin abs : site/ajax/verification
* Information : page permettant de recharger la partie critère de l'affichage à partir du critère passé en POST
*
**/

	//ouverture d'un session ATTENTION : le session start DOIT être placé APRES le chargement des classes
	session_start();


	//récupération du critère à afficher
    if(isset($_POST['critere'])){
        $_SESSION['critere'] = $_POST['critere'];
    }
    
?>
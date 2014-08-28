<?php 
/*
*
* Créer par : CHAPON Theo
*
**/

/*
*
* Information sur la page :
* Nom : changerCriteres.php
* Chemin abs : site/ajax/verification
* Information : page permettant de modifier l'affichage de type de critères
*
**/

	//ouverture d'un session ATTENTION : le session start DOIT être placé APRES le chargement des classes
	session_start();


	//récupération du critère à afficher
    if(isset($_POST['critere'])){
        $_SESSION['critere'] = $_POST['critere'];
    }
    
?>
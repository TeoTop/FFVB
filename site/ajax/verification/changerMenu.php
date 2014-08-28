<?php 
/*
*
* Créer par : CHAPON Theo
*
**/

/*
*
* Information sur la page :
* Nom : changerMenu.php
* Chemin abs : site/ajax/verification
* Information : page permettant de modifier l'affichage la partie menu déroulant
*
**/

	//ouverture d'un session ATTENTION : le session start DOIT être placé APRES le chargement des classes
	session_start();


	//récupération du critère à afficher
    if(isset($_POST['liste'])){
        $_SESSION['liste'] = $_POST['liste'];
    }
    
?>
<?php 
/*
*
* Créer par : CHAPON Theo
* Date de modification : 09/08/2013
*
**/

/*
*
* Information sur la page :
* Nom : changerMenu.php
* Chemin abs : site/ajax
* Information : page permettant de recharger la partie menu déroulant
*
**/

	//ouverture d'un session ATTENTION : le session start DOIT être placé APRES le chargement des classes
	session_start();


	//récupération du critère à afficher
    if(isset($_POST['liste'])){
        $_SESSION['liste'] = $_POST['liste'];
    }
    
?>
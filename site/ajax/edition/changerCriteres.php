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
* Nom : changerCriteres.php
* Chemin abs : site/ajax
* Information : page permettant de modifier la valeur du type des critères à afficher en SESSION
*
**/

	//ouverture d'un session ATTENTION : le session start DOIT être placé APRES le chargement des classes
	session_start();


	//récupération du critère à afficher
    if(isset($_POST['critere'])){
        $_SESSION['critere'] = $_POST['critere'];
    }
    
?>
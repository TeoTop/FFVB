<?php 
/*
*
* Créer par : CHAPON Theo
*
**/

/*
*
* Information sur la page :
* Nom : inverserCriteres.php
* Chemin abs : site/ajax
* Information : page permettant de modifier la variable de SESSION 'inverser' qui permet d'inverser la sélection 
* faite par les critères
*
**/

	session_start();


	//si la variable de SESSION est définie et si elle vaut faux, alors on la met à vrai pour que l'inversement s'effectue
    if( isset($_SESSION['inverser']) && !$_SESSION['inverser'] ){
        $_SESSION['inverser'] = true;
    } else {
    	$_SESSION['inverser'] = false;
    }
    
?>
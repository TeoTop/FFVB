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

?>

<div id="text">

<?php
if($_SESSION['poule'] == ''){
    echo "Critère exempté : <br/>\n";
} else {
    echo "Critère domicile : <br/><br/>\n
    Critère exterieur : <br/>\n";
}

?>

</div>

<?php 
/*
*
* Créer par : CHAPON Théo
*
*/

/*
*
* Information sur la page :
* Nom : erreur.php
* Chemin abs : site\vue\
* Information : page d'erreur en cas traficotage de l'url
* Page d'erreur
*
*/
    
    // on supprime les variables de session 
    unset($_SESSION);

?>


<div class="erreur" style="background-color:white; padding:20px;">
    <h1>Une url non valide a été transmise</h1>
    <br/>
    <h3 style="">Vous avez tenté de dépasser les limites, ce n'est pas bien.</h3>
    <h3>Cliquez sur l'une des pages du menu pour revenir sur le droit chemin.</h3>
</div>
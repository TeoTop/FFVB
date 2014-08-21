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
* Nom : top.php
* Chemin abs : site\
* Information : page permettant de définir l'affiche du haut de la
* page ainsi que l'insertion de plusieurs pages de fonctions php
* afin d'éviter un répétition d'appel au fonction (niveau code)
*
*/
?>

<header>
    <a href="index.php" title="Retour à l'accueil">
        <img src="site/img/header.png" alt="Retour à l'accueil"/>
    </a>
</header>
<nav>
    <ul>
        <li><a href="index.php">
            <img src="site/img/accueil.png" alt="Retour à l'accueil"/>
        </a></li>
        <li><a href="?m=navigation&a=editeur">
            <img src="site/img/editeur.png" alt="Page editeur"/>
        </a></li>
        <li><a href="?m=navigation&a=generateur">
            <img src="site/img/generateur.png" alt="Page generateur"/>
        </a></li>
        <li><a href="?m=navigation&a=verificateur">
            <img src="site/img/verificateur.png" alt="Page verificateur"/>
        </a></li>
    </ul>
</nav>
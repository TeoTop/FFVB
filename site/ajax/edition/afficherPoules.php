<?php 
/*
*
* Créer par : CHAPON Theo
* Date de modification : 22/08/2013
*
**/

/*
*
* Information sur la page :
* Nom : afficherPoules.php
* Chemin abs : site/ajax
* Information : page permettant de recharger le modal des poules
*
**/

	define('M', '../../model/');

	//page contenant les fonctions associées à la base de données
 	require '../../bdd.php';
 	
 	function chargerClasse($classe)
	{
	  require M . $classe . '.class.php'; // On inclut la classe correspondante au paramètre passé.
	}

	// On enregistre la fonction en autoload pour qu'elle soit appelée dès qu'on instanciera une classe non déclarée.
	spl_autoload_register('chargerClasse'); 

	//ouverture d'un session ATTENTION : le session start DOIT être placé APRES le chargement des classes
	session_start();


	$manager = new EquipeManager();
	$equipesPoules = $manager->equipesPoules($_SESSION['tour']->id());

	$equipesExemptees = $manager->equipesExemptesNom($_SESSION['tour']->id());


echo '<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h2 class="modal-title">';
echo '<b>Catégorie : </b>' . $_SESSION['coupe']->categorie();
echo '<b class="h2b">Tour : </b>' . $_SESSION['tour']->numero();
echo '<b class="h2b">Date : </b>' . date('d-m-Y', strtotime($_SESSION['tour']->dateTour()));
echo '</h2>
</div>
<div class="modal-body">
<table class="pouleAffiche">';

    $loop = 0;

    //on affiche les catégories, si un des bouttons d'une catégorie est utilisé, 2 nouveaux paramètres sont passés en GET :
    // c->coupe et t->tour
    foreach ($equipesPoules as $key => $poule) {

        if( $loop%2 == 0 ) echo '<tr>';

        echo '<td>
        	<div>
            	<h3>'.$key.'</h3>
            	<hr>';

            foreach ($poule as $key => $equipe) {
            	echo '<span>'.$equipe.'</span>';
            }

        echo '</div>
        </td>';

        if( $loop%2 == 1 ) echo '</tr>';

        $loop++;
    }

    $loop = 1;

    echo '<tr><td colspan="2">';

    	echo '<div class="afficherExempte">
            	<h3>Equipes exemptées</h3>
            	<hr>
            	<span>';

            foreach ($equipesExemptees as $key => $equipe) {
            	echo '<span class="colonne">'.$equipe.'</span>';

            	if( $loop%3 == 0 ) echo '</span><span>';
            	$loop++;
            }

        echo '</span>
        </div>';

    echo '</td></tr>';

	
echo '</table>
</div>';

?>
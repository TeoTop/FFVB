<?php 
/*
*
* Créer par : CHAPON Theo
*
**/

/*
*
* Information sur la page :
* Nom : afficherPoules.php
* Chemin abs : site/ajax
* Information : page permettant de charger le modal des poules générales
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

    // on récupères toutes les équipes dans les poules
	$manager = new EquipeManager();
	$equipesPoules = $manager->equipesPoules($_SESSION['tour']->id());

    //on récupère les exemptés
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

    //on affiche les poules et leurs équipes :
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

    //on affiche les exemptés

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
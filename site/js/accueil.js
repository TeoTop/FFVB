/**
*
* Créer par : CHAPON Théo
* Date de modification : 09/08/2013
*
**/

/**
*
* Information sur la page :
* Nom : accueil.js
* Chemin abs : site\js\
* Information : page JS permettant de définir les fonctions JS de l'accueil.
*
**/

//fonction permettant de recharger les catégories si l'année est modifié
$('#content').on('change', '#selectAnnee', function() {
	$('#content').load('site/ajax/accueil/chargerAccueil.php', { annee: $( '#selectAnnee' ).val() });
});
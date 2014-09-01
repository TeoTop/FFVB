/**
*
* Créer par : CHAPON Théo
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

//fonction permettant de recharger la page d'accueil si l'année est modifiée
$('#content').on('change', '#selectAnnee', function() {
	$('#content').load('site/ajax/accueil/chargerAccueil.php', { annee: $( '#selectAnnee' ).val() });
});
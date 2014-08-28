/**
*
* Créer par : CHAPON Théo
* Date de modification : 09/08/2013
*
**/

/**
*
* Information sur la page :
* Nom : verificateur.js
* Chemin abs : site\js\
* Information : page JS permettant de définir les fonctions JS du vérificateur.
*
**/



/********************* Modifier la coupe et le tour ***************************/

//fonction permettant de recharger la page si une coupe est sélectionnée
$('#content').on('change', '#selectCoupe', function() {

    //on recharge une partie de la page en passant des données en POST.
    $('#content').load('site/ajax/verification/chargerVerificateur.php', { coupe: $( '#selectCoupe' ).val() });

    // !!! cela ne doit pas servir de référence, cette action permet juste de faire suivre l'adresse url 
    //avec le contenu de la page, ce n'est que de l'affichage. Les données à transférer sont passé en POST
    history.pushState({ path: this.path }, '', 
        'http://localhost/ffvb/index.php?m=navigation&a=verificateur&c=' + $( '#selectCoupe' ).val());

});



//fonction permettant de recharger la page si un tour est sélectionné
$('#content').on('change', '#selectTour', function() {
    
    //pas besoin d'indiquer la coupe, celle-ci est stocké en variable de session.
    $('#content').load('site/ajax/verification/chargerVerificateur.php', { coupe: $( '#selectCoupe' ).val(), tour: $( '#selectTour' ).val() });
    
    history.pushState({ path: this.path }, '', 
        'http://localhost/ffvb/index.php?m=navigation&a=verificateur&c=' + $( '#selectCoupe' ).val() + '&t=' + $( '#selectTour' ).val());
  
});



/********************* Menu equipe et poule ******************************/


//cette fonction est activé lorsque l'on clique sur un poule située dans le menu déroulant (onclick="chargerEditionPoule(poule_id)")
function chargerPoule(poule_id) {
    
    $('#poule').load('site/ajax/verification/chargerEditionPoule.php', { poule: poule_id });

    $('#indicateur').load('site/ajax/verification/chargerIndicateur.php');

    

}


//cette fonction est activé lorsque l'on clique sur une équipe située dans le menu déroulant (onclick="chargerEquipe(equipe_id)")
function chargerEquipe(equipe_id) {
    
    // requete HTML à partir d'AJAX : method post vers la page php chargerEquipe situé dans le dossier ajax.
    $.ajax({
        type: 'POST',
        url: 'site/ajax/verification/chargerEquipe.php',
        data: { equipe: equipe_id },
        dataType: 'json',
        timeout: 3000,
        
        success: function(json) {
            if(json.action){
                //l'équipe est dans une poule
                chargerPoule(json.poule);
            }
        },

        error: function() {
            console.log('La requête de chargement d\'équipe n\'a pas abouti'); 
        },
    });
}


//cette fonction est activé lorsque l'on clique sur un onglet du menu déroulant
function changerMenu(type) {
    
    $.ajax({
        type: 'POST',
        url: 'site/ajax/verification/changerMenu.php',
        data: { liste: type },
        timeout: 3000,
        
        success: function(data) {
        },

        error: function() {
            console.log('La requête de modification de menu n\'a pas abouti'); 
        },
    });
}


//cette fonction est activé lorsque l'on clique sur un onglet du menu déroulant
function chargerMenu() {
    
    $('#liste').load('site/ajax/verification/chargerMenu.php');
}



/********************* Editeur de poule *******************************/


//fonction permettant de recharger la page si une poule est sélectionnée
$('#content').on('change', '#selectPoule', function() {

    chargerPoule($( '#selectPoule' ).val());

});



/********************** Critères ***************************/


//cette fonction est activé lorsque l'on clique sur un onglet des critères
function changerCriteres(type) {

    $('#affCritere').attr( 'value', type );
    
    $.ajax({
        type: 'POST',
        url: 'site/ajax/verification/changerCriteres.php',
        data: { critere: type },
        timeout: 3000,
        
        success: function(data) {
        },

        error: function() {
            console.log('La requête de modification de critère n\'a pas abouti'); 
        },
    });
}



// fonction permattant de modifier la valeur d'un critere
function modifierCritere(id, valeur) {
    // requete HTML à partir d'AJAX : method post vers la page php modifierCritere situé dans le dossier ajax.
    $.ajax({
        type: 'POST',
        url: 'site/ajax/verification/modifierCritere.php',
        data: { critere: id, valeur: valeur },
        timeout: 3000,
        
        success: function(data) {
            chargerMenu();

            setTimeout(function(){
                chargerPoule($( '#selectPoule' ).val());
            }, 300);
        },

        error: function() {
            console.log('La requête de modification de critère n\'a pas abouti'); 
        },
    });
}


// détecte le changement de critère pour une checkbox
$('#content').on('change', '.form-horizontal :checkbox', function(e) {

    var valeur; 

    ($("#" + e.target.id).is(":checked")) ? valeur = 1 : valeur = -1;

    if(valeur == 1) {
    	$('#liste span').css('color', 'red');
    } else {
    	$('#liste span').css('color', 'green');
    }

    modifierCritere(e.target.id, valeur);
        
});


//détecte le changement de critère pour un select
$('#content').on('change', '.form-horizontal select', function(e) {

    modifierCritere(e.target.id, e.target.value);

});

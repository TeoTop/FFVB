/**
*
* Créer par : CHAPON Théo
* Date de modification : 09/08/2013
*
**/

/**
*
* Information sur la page :
* Nom : editeur.js
* Chemin abs : site\js\
* Information : page JS permettant de définir les fonctions JS de l'editeur.
*
**/


/********************* Modifier la coupe et le tour ***************************/

//fonction permettant de recharger la page si une coupe est sélectionnée
$('#content').on('change', '#selectCoupe', function() {

    //on recharge une partie de la page en passant des données en POST.
    $('#content').load('site/ajax/chargerEditeur.php', { coupe: $( '#selectCoupe' ).val() });

    // !!! cela ne doit pas servir de référence, cette action permet juste de faire suivre l'adresse url 
    //avec le contenu de la page, ce n'est que de l'affichage. Les données à transférer sont passé en POST
    history.pushState({ path: this.path }, '', 
        'http://localhost/ffvb/index.php?m=navigation&a=editeur&c=' + $( '#selectCoupe' ).val());
});



//fonction permettant de recharger la page si un tour est sélectionné
$('#content').on('change', '#selectTour', function() {
    
    //pas besoin d'indiquer la coupe, celle-ci est stocké en variable de session.
    $('#content').load('site/ajax/chargerEditeur.php', { coupe: $( '#selectCoupe' ).val(), tour: $( '#selectTour' ).val() });
    
    history.pushState({ path: this.path }, '', 
        'http://localhost/ffvb/index.php?m=navigation&a=editeur&c=' + $( '#selectCoupe' ).val() + '&t=' + $( '#selectTour' ).val());
});



/********************* Menu equipe et poule ******************************/


//cette fonction est activé lorsque l'on clique sur un poule située dans le menu déroulant (onclick="chargerEditionPoule(poule_id)")
function chargerPoule(poule_id) {
    
    $('#poule').load('site/ajax/chargerEditionPoule.php', { poule: poule_id });

    $('#equipe').load('site/ajax/chargerEquipesCritere.php');

}


//cette fonction est activé lorsque l'on clique sur une équipe située dans le menu déroulant (onclick="chargerEquipe(equipe_id)")
function chargerEquipe(equipe_id) {
    
    // requete HTML à partir d'AJAX : method post vers la page php chargerEquipe situé dans le dossier ajax.
    $.ajax({
        type: 'POST',
        url: 'site/ajax/chargerEquipe.php',
        data: { equipe: equipe_id },
        dataType: 'json',
        timeout: 3000,
        
        success: function(json) {
            if(json.action){
                //l'équipe est dans une poule
                chargerPoule(json.poule)
            } else {
                //on doit ajouter l'équipe
                actionAjouterEquipe(equipe_id,true);
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
        url: 'site/ajax/changerMenu.php',
        data: { liste: type },
        timeout: 3000,
        
        success: function(data) {
        },

        error: function() {
            console.log('La requête de modification de menu n\'a pas abouti'); 
        },
    });
}



/********************* Editeur de poule *******************************/


//fonction permettant de recharger la page si une poule est sélectionnée
$('#content').on('change', '#selectPoule', function() {

    chargerPoule($( '#selectPoule' ).val());

});


//fonction permettant de créer une nouvelle poule
$('#content').on('click', '#creerPoule', function() {

    // requete HTML à partir d'AJAX : method post vers la page php ajouterPoule situé dans le dossier ajax.
    $.ajax({
        type: 'POST',
        url: 'site/ajax/creerPoule.php',
        dataType: 'json',
        timeout: 3000,
        
        success: function(json) {

            chargerPoule(json.poule);

            $('#liste').load('site/ajax/chargerMenu.php');

        },
        
        error: function() {
            console.log('La requête de création de poule n\'a pas abouti'); 
        },
    });
    
});


//fonction permettant de supprimer la poule affichée
$('#content').on('click', '#supprimerPoule', function() {

    // requete HTML à partir d'AJAX : method post vers la page php supprimerPoule situé dans le dossier ajax.
    $.ajax({
        type: 'POST',
        url: 'site/ajax/supprimerPoule.php',
        dataType: 'json',
        timeout: 3000,
        
        success: function(json) {
            //le set timeout permet de laissé le temps au modal de se supprimer
            setTimeout(function(){
                chargerPoule(json.poule);
                console.log(json.poule);
                $('#liste').load('site/ajax/chargerMenu.php');
            }, 300);
        },
        
        error: function() {
            console.log('La requête de suppression de poule n\'a pas abouti'); 
        },
    });
  
});




/********************** Critères ***************************/


//cette fonction est activé lorsque l'on clique sur un onglet des critères
function changerCriteres(type) {

    $('#affCritere').attr( 'value', type );
    
    $.ajax({
        type: 'POST',
        url: 'site/ajax/changerCriteres.php',
        data: { critere: type },
        timeout: 3000,
        
        success: function(data) {
            setTimeout(function(){
                $('#equipe').load('site/ajax/chargerEquipesCritere.php');
            }, 300);
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
        url: 'site/ajax/modifierCritere.php',
        data: { critere: id, valeur: valeur },
        timeout: 3000,
        
        success: function(data) {
            setTimeout(function(){
                $('#equipe').load('site/ajax/chargerEquipesCritere.php');
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

    modifierCritere(e.target.id, valeur)
        
});


//détecte le changement de critère pour un select
$('#content').on('change', '.form-horizontal select', function(e) {

    modifierCritere(e.target.id, e.target.value)

});




/********************** Equipe critère ***************************/


//cette fonction est activé lorsque l'on clique sur une équipe située dans la liste des équipes (onclick="ajouterEquipe(equipe_id)")
function actionAjouterEquipe(equipe_id, chargement) {
    
    //nous donne la position à partire du nombre de ligne dans la table 
    var lignes = $("#tablePoule > tbody > tr").length + 1;
    var critere = $('#affCritere').val();
    var poule = $( '#selectPoule' ).val();

    //l'ajout provient des équipes triées
    if(typeof(chargement)==='undefined'){
        
        if(critere == 'domicile'){
            
            if(poule == ''){
                $( '#informationTitle' ).text( "Equipe éxempté" );
                $( '#informationBody' ).text( "Vous ne pouvez ajouter d'équipe dans la poule éxempté à partir des critères DOMICILE" );
                $( '#informationModal' ).modal();
            } else {
                if(lignes == 1){
                    ajouterEquipe(equipe_id);
                } else {
                    remplacerEquipe(equipe_id);
                }
            }

        } else if(critere == 'exterieur') {
            if(poule == ''){
                $( '#informationTitle' ).text( "Equipe éxempté" );
                $( '#informationBody' ).text( "Vous ne pouvez ajouter d'équipe dans la poule éxempté à partir des critères EXTERIEUR" );
                $( '#informationModal' ).modal();
            } else {
                if(lignes == 5){
                    $( "#informationTitle" ).text( "Poule complète" );
                    $( "#informationBody" ).text( "Une poule ne peut pas contenir plus de quatre equipes." );
                    $('#informationModal').modal();
                } else if (lignes == 1){
                    $( "#informationTitle" ).text( "Poule non domiciliée" );
                    $( "#informationBody" ).text( "Cette poule ne possède pas encore d\'équipe devant jouer à domicile. Veuillez choisir une équipe à partir des critères DOMICILE" );
                    $('#informationModal').modal();
                } else {
                    ajouterEquipe(equipe_id);
                }
            }

        } else {
            if(poule != ''){
                $( "#informationTitle" ).text( "Equipe éxempté" );
                $( "#informationBody" ).text( "Un exempté ne peut être placé que dans la \"poule\" exempté." );
                $('#informationModal').modal();
            } else {
                ajouterEquipe(equipe_id);
            }
        }
       
    //l'ajout provient du menu déroulant
    } else {

        if(lignes < 5){
            ajouterEquipe(equipe_id);
        } else {
            $( '#informationTitle' ).text( "Poule complète" );
            $( '#informationBody' ).text( "Une poule ne peut pas contenir plus de quatre equipes." );
            $( '#informationModal' ).modal();
        }
    }
}

//permet d'ajouter une équipe à une poule ou à la catégorie exempté
function ajouterEquipe(equipe_id){

    // requete HTML à partir d'AJAX : method post vers la page php ajouterEquipe situé dans le dossier ajax.
    $.ajax({
        type: 'POST',
        url: 'site/ajax/ajouterEquipe.php',
        data: { equipe: equipe_id },
        timeout: 3000,
        
        success: function(data) {
            $('#poule').load('site/ajax/chargerEditionPoule.php');

            $('#equipe').load('site/ajax/chargerEquipesCritere.php');
        },

        error: function() {
            console.log('La requête d\'ajout d\'équipe n\'a pas abouti');
        },
    });
}


//cette fonction s'applique lorsque les critères de sélection pour DOMICILE sont actifs et qu'il y a une équipe déjà présente
//dans la poule
function remplacerEquipe(equipe_id){

    // requete HTML à partir d'AJAX : method post vers la page php remplacerEquipe situé dans le dossier ajax.
    $.ajax({
        type: 'POST',
        url: 'site/ajax/remplacerEquipe.php',
        data: { equipe: equipe_id },
        timeout: 3000,
        
        success: function(data) {
            $('#poule').load('site/ajax/chargerEditionPoule.php');

            $('#equipe').load('site/ajax/chargerEquipesCritere.php');
        },

        error: function(data) {
            console.log('La requête d\'ajout d\'équipe n\'a pas abouti');
        },
    });
}


//cette fonction est activé lorsque l'on clique sur le bouton de supression d'une ligne de poule
function retirerEquipe(equipe_id) {
    
    // requete HTML à partir d'AJAX : method post vers la page php retirerEquipe situé dans le dossier ajax.
    $.ajax({
        type: 'POST',
        url: 'site/ajax/retirerEquipe.php',
        data: { equipe: equipe_id },
        timeout: 3000,
        
        success: function(data) {
            setTimeout(function(){
                $('#poule').load('site/ajax/chargerEditionPoule.php');

                $('#equipe').load('site/ajax/chargerEquipesCritere.php');
            }, 300);
        },

        error: function() {
            console.log('La requête de retirement d\'équipe n\'a pas abouti'); 
        },
    });

}



/********************* Manipulation des modaux *********************************/


//s'applique sur le bouton suppression de poule
$('#content').on('click', '#supprimerPouleBtn', function() {

    //si il y a au moins une ligne dans la poule, on demande une confirmation.
    var lignes = $("#tablePoule > tbody > tr").length;

    if(lignes != 0){
        $('#supprimerPouleModal').modal();
    } else {
        $( '#supprimerPoule' ).trigger( "click" );
    }

});


//cette fonction est activé lorsque l'on clique sur le bouton de supression d'une ligne de poule
function retirerEquipeModal(equipe_id, position) {

    var lignes = $("#tablePoule > tbody > tr").length;

    //si on retire une équipe à domicile et qu'il y a déjà des équipes exterieurs, on demande confirmation
    if( position == 0 && lignes > 1 && $( '#selectPoule' ).val() != ''){
        $('#retirerEquipeModal').modal();
    } else {
        retirerEquipe(equipe_id);
    }
}
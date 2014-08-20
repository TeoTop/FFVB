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

//permet de charger le trie sur les colonnes dans les tables présentant les équipes en fonction des critères
$(function(){
  $('#tableEquipe').tablesorter(); 
});


$('#search').quicksearch('#equipeSearch span');


/********************* Modifier la coupe et le tour ***************************/

//fonction permettant de recharger la page si une coupe est sélectionnée
$( '#selectCoupe' ).change(function () {

  	//on recharge une partie de la page en passant des données en POST. (on indique que la page est recharger ajax = true)
  	$('#content').load('site/vue/editeur.php', { coupe: $( '#selectCoupe' ).val(), ajax: true });

  	// !!! cela ne doit pas servir de référence, cette action permet juste de faire suivre l'adresse url 
    //avec le contenu de la page, ce n'est que de l'affichage. Les données à transférer sont passé en POST
  	history.pushState({ path: this.path }, '', 'http://localhost/ffvbsolo/index.php?m=navigation&a=editeur&c=' + $( '#selectCoupe' ).val());
});



//fonction permettant de recharger la page si un tour est sélectionné
$( '#selectTour' ).change(function () {
	
  	//pas besoin d'indiquer la coupe, celle-ci est stocké en variable de session.
  	$('#content').load('site/vue/editeur.php', { tour: $( '#selectTour' ).val(), ajax: true });
  	
  	history.pushState({ path: this.path }, '', 
  		'http://localhost/ffvbsolo/index.php?m=navigation&a=editeur&c=' + $( '#selectCoupe' ).val() + '&t=' + $( '#selectTour' ).val());
  });



/********************* Menu equipe et poule ******************************/


//cette fonction est activé lorsque l'on clique sur un poule située dans le menu déroulant (onclick="chargerPoule(poule_id)")
function chargerPoule(poule_id) {
    
    $('#content').load('site/vue/editeur.php', { 
        poule: poule_id, 
        ajax: true 
    });
}


//cette fonction est activé lorsque l'on clique sur une équipe située dans le menu déroulant (onclick="chargerEquipe(equipe_id)")
function chargerEquipe(equipe_id) {
    
    // requete HTML à partir d'AJAX : method post vers la page php chargerEquipe situé dans le dossier ajax.
    $.ajax({
        type: 'POST',
        url: 'site/ajax/chargerEquipe.php',
        data: { equipe: equipe_id, tour: $( '#selectTour' ).val() },
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


/********************* Editeur de poule *******************************/


//fonction permettant de recharger la page si une poule est sélectionnée
$( '#selectPoule' ).change(function () {
    
    var poule = null;

    if($( '#selectPoule' ).val() != -1 ) poule = $( '#selectPoule' ).val();

    $('#content').load('site/vue/editeur.php', { 
        poule: poule, 
        liste: $( '#affListe' ).val(), 
        critere: $( '#affCritere' ).val(), 
        ajax: true 
    });
});

//fonction permettant de créer une nouvelle poule
$( '#creerPoule' ).click(function () {

  	// requete HTML à partir d'AJAX : method post vers la page php ajouterPoule situé dans le dossier ajax.
  	$.ajax({
        type: 'POST',
        url: 'site/ajax/creerPoule.php',
        data: { coupe: $( '#selectCoupe' ).val(), tour: $( '#selectTour' ).val() },
        dataType: 'json',
        timeout: 3000,
        
        success: function(json) {
			$('#content').load('site/vue/editeur.php', { 
                poule: json.poule, 
                liste: $( '#affListe' ).val(), 
                critere: $( '#affCritere' ).val(),
                ajax: true 
            });
    	},
        
        error: function() {
            console.log('La requête de création de poule n\'a pas abouti'); 
        },
    });
    
});


//fonction permettant de supprimer la poule affichée
$( '#supprimerPoule' ).click(function () {

  	// requete HTML à partir d'AJAX : method post vers la page php supprimerPoule situé dans le dossier ajax.
  	$.ajax({
        type: 'POST',
        url: 'site/ajax/supprimerPoule.php',
        data: { poule: $( '#selectPoule' ).val(), tour: $( '#selectTour' ).val() },
        dataType: 'json',
        timeout: 3000,
        
        success: function(json) {
            setTimeout(function(){
            	$('#content').load('site/vue/editeur.php', { 
                    poule: json.poule, 
                    liste: $( '#affListe' ).val(),
                    critere: $( '#affCritere' ).val(), 
                    ajax: true 
                });
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
    
    var poule = null;

    $('#affCritere').attr('value',type);

    /*if(type!='exempter'){
        poule = $( '#selectPoule' ).val();
    }*/

    $('#content').load('site/vue/editeur.php', {
        //poule: poule, 
        liste: $( '#affListe' ).val(), 
        critere: $( '#affCritere' ).val(),
        ajax: true 
    });
}



// fonction permattant de modifier la valeur d'un critere
function modifierCritere(id, valeur) {
    // requete HTML à partir d'AJAX : method post vers la page php retirerEquipe situé dans le dossier ajax.
    $.ajax({
        type: 'POST',
        url: 'site/ajax/modifierCritere.php',
        data: { critere: id, valeur: valeur, tour: $( '#selectTour' ).val() },
        timeout: 3000,
        
        success: function(data) {
            setTimeout(function(){
                $('#content').load('site/vue/editeur.php', { 
                    liste: $( '#affListe' ).val(), 
                    critere: $( '#affCritere' ).val(),
                    ajax: true 
                });
            }, 300);
        },

        error: function() {
            console.log('La requête de modification de critère n\'a pas abouti'); 
        },
    });
}


// détecte le change de critère pour une checkbox
$('.form-horizontal :checkbox').change(function(e){

    var valeur;

    ($("#" + e.target.id).is(":checked")) ? valeur = 1 : valeur = -1; 

    modifierCritere(e.target.id, valeur)
        
});


//détecte le changement de critère pour un select
$('.form-horizontal select').change(function(e){

    modifierCritere(e.target.id, e.target.value)

});




/********************** Equipe critère ***************************/


//cette fonction est activé lorsque l'on clique sur une équipe située dans la liste des équipes (onclick="ajouterEquipe(equipe_id)")
function actionAjouterEquipe(equipe_id, chargement) {
    
    //nous donne la position à partire du nombre de ligne dans la table 
    var lignes = $("#tablePoule > tbody > tr").length + 1;
    var critere = $('#affCritere').val();
    var poule = $( '#selectPoule' ).val();

    if(typeof(chargement)==='undefined'){
        
        if(critere == 'domicile'){
            
            if(poule == -1){
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
            if(poule == -1){
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
            if(poule != -1){
                $( "#informationTitle" ).text( "Equipe éxempté" );
                $( "#informationBody" ).text( "Un exempté ne peut être placé que dans la \"poule\" exempté." );
                $('#informationModal').modal();
            } else {
                ajouterEquipe(equipe_id);
            }
        }
       
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
        data: { poule: $( '#selectPoule' ).val(), equipe: equipe_id },
        timeout: 3000,
        
        success: function(data) {
            // !!! on doit indiqué le tour car sinon on chargera le tour le plus récent de la coupe. Le tour est l'indicateur ultime (le plus précis) d'une page
            $('#content').load('site/vue/editeur.php', { 
                liste: $( '#affListe' ).val(), 
                critere: $( '#affCritere' ).val(),
                ajax: true 
            });
        },

        error: function() {
            console.log('La requête d\'ajout d\'équipe n\'a pas abouti');
        },
    });
}


//cette fonction s'applique lorsque les critères de sélection pour DOMICILE sont actifs et qu'il y a une équipe déjà présente
//dans la poule
function remplacerEquipe(equipe_id){
    console.log('aye');
    // requete HTML à partir d'AJAX : method post vers la page php ajouterEquipe situé dans le dossier ajax.
    $.ajax({
        type: 'POST',
        url: 'site/ajax/remplacerEquipe.php',
        data: { poule: $( '#selectPoule' ).val(), equipe: equipe_id },
        timeout: 3000,
        
        success: function(data) {
            // !!! on doit indiqué le tour car sinon on chargera le tour le plus récent de la coupe. Le tour est l'indicateur ultime (le plus précis) d'une page
            $('#content').load('site/vue/editeur.php', { 
                liste: $( '#affListe' ).val(), 
                critere: $( '#affCritere' ).val(),
                ajax: true 
            });
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
        data: { poule: $( '#selectPoule' ).val(), equipe: equipe_id },
        timeout: 3000,
        
        success: function(data) {
            setTimeout(function(){
                $('#content').load('site/vue/editeur.php', { 
                    liste: $( '#affListe' ).val(), 
                    critere: $( '#affCritere' ).val(),
                    ajax: true 
                });
            }, 300);
        },

        error: function() {
            console.log('La requête de retirement d\'équipe n\'a pas abouti'); 
        },
    });

}



/********************* Manipulation des modaux *********************************/


//s'applique sur le bouton suppression de poule
$( '#supprimerPouleBtn' ).click( function() {

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
    if( position == 0 && lignes > 1 && $( '#selectPoule' ).val() != -1){
        $('#retirerEquipeModal').modal();
    } else {
        retirerEquipe(equipe_id);
    }
}

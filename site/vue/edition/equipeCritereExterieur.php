<?php 
/*
*
* Créer par : CHAPON Théo
* Date de modification : 06/08/2013
*
*/

/*
*
* Information sur la page :
* Nom : equipeCritereExterieur.php
* Chemin abs : site\vue\
* Information : page permettant d'afficher les équipes répondants aux critères EXTERIEUR
*
*
*/
?>

<?php
    // on récupère les équipes qualifiées pour le tour de coupe
    $manager = new EquipeManager();
    
    if($_SESSION['poule'] == ''){
        $equipesCritere = $manager->equipesSelonCritere(array(), $_SESSION['tour']);
    } else {
        $equipesPoule = $manager->equipesPoule($_SESSION['poule']->id());
        if(count($equipesPoule) != 0){
            $equipesCritere = $manager->equipesSelonCritereExt($critereExterieur, $_SESSION['tour'], $equipesPoule);
        } else {
            $equipesCritere = $manager->equipesSelonCritere(array(), $_SESSION['tour']);
        }
    }
    
?>

<table class="tablesorter" id="tableEquipe">
<thead>
<tr>
<th class="t-equipe">Equipe</th>
<th class="t-lieu">Lieu/Distance</th>
<th class="t-commite">Commité</th>
<th class="t-region">Region</th>
<th class="t-km">Km</th>
<th class="t-coupe">CFVB</th>
<th class="t-cfvb">Coupe</th>
</tr>
</thead>
<tbody>
    <?php
        foreach ($equipesCritere as $key => $equipe) {
            echo '<tr onclick="actionAjouterEquipe('.$equipe->id().')">
                <td class="t-equipe">'.$equipe->club()->nom().'</td>
                <td class="t-lieu">'.$equipe->club()->ville().'</td>
                <td class="t-commite">'.$equipe->club()->commite().'</td>
                <td class="t-region">'.$equipe->club()->region().'</td>
                <td align="center" class="t-km">'.$equipe->nbKmParcouru().'</td>
                <td align="center" class="t-coupe">'.$equipe->classementCFVB().'</td>
                <td align="center" class="t-cfvb">'.$equipe->classementCoupe().'</td>
            </tr>';
        }
    ?>
</tbody>
</table>

<script>
$(function() {

    $.extend($.tablesorter.themes.bootstrap, {
        // these classes are added to the table. To see other table classes available,
        // look here: http://twitter.github.com/bootstrap/base-css.html#tables
        table      : 'table table-striped table-hover',
        caption    : 'caption',
        header     : 'bootstrap-header', // give the header a gradient background
        footerRow  : '',
        footerCells: '',
        icons      : '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
        sortNone   : 'bootstrap-icon-unsorted',
        sortAsc    : 'icon-chevron-up glyphicon glyphicon-chevron-up',     // includes classes for Bootstrap v2 & v3
        sortDesc   : 'icon-chevron-down glyphicon glyphicon-chevron-down', // includes classes for Bootstrap v2 & v3
        active     : '', // applied when column is sorted
        hover      : '', // use custom css here - bootstrap class may not override it
        filterRow  : '', // filter row class
        even       : '', // odd row zebra striping
        odd        : ''  // even row zebra striping
    });

    // call the tablesorter plugin and apply the uitheme widget
    $("#tableEquipe").tablesorter({
        // this will apply the bootstrap theme if "uitheme" widget is included
        // the widgetOptions.uitheme is no longer required to be set
        theme : "bootstrap",

        widthFixed: true,

        headerTemplate : '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!

        // widget code contained in the jquery.tablesorter.widgets.js file
        // use the zebra stripe widget if you plan on hiding any rows (filter widget)
        widgets : [ "uitheme", "zebra" ],
    });
});
</script>
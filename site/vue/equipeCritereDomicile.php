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
* Nom : equipeCritereDomicile.php
* Chemin abs : site\vue\
* Information : page permettant d'afficher les équipes répondants aux critères DOMICILE
*
* Chaque page php peut potentiellement être découpé en deux partie : une pour son chargement normal, l'autre lorsque celle-ci
* est rechargé par l'intermèdiaire de l'AJAX.
*
*/
?>

<?php
    // on récupère les équipes qualifiées pour le tour de coupe
    $manager = new EquipeManager();
    //$equipesCritere = $manager->retirerEquipesPoules($equipes, $_SESSION['tour']);
    $equipesCritere = $manager->equipesSelonCritere($critereDomicile, $_SESSION['tour']);
?>


<table class="table table-striped table-hover" id="tableEquipe">
<thead>
<tr>
<th class="th-equipe">Equipe</th>
<th class="th-lieu">Lieu/Distance</th>
<th class="th-commite">Commité</th>
<th class="th-region">Region</th>
<th class="th-km">Km parcouru</th>
<th class="th-coupe">Clmt CFVB</th>
<th class="th-cfvb">Clmt Coupe</th>
</tr>
</thead>
<tbody>
    <?php
        foreach ($equipesCritere as $key => $equipe) {
            echo '<tr onclick="actionAjouterEquipe('.$equipe->id().')">
                <td>'.$equipe->club()->nom().'</td>
                <td>'.$equipe->club()->ville().'</td>
                <td>'.$equipe->club()->commite().'</td>
                <td>'.$equipe->club()->region().'</td>
                <td align="center">'.$equipe->nbKmParcouru().'</td>
                <td align="center">'.$equipe->classementCFVB().'</td>
                <td align="center">'.$equipe->classementCoupe().'</td>
            </tr>';
        }
    ?>
</tbody>
</table>
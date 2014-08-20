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
* Nom : editionPoule.php
* Chemin abs : site\vue\
* Information : page permettant d'afficher l'éditeur de poule qui permettra d'effectuer des modifications
*
* Chaque page php peut potentiellement être découpé en deux partie : une pour son chargement normal, l'autre lorsque celle-ci
* est rechargé par l'intermèdiaire de l'AJAX.
*
*/
?>

<?php
    // on récupère les équipes dans la poule si une poule est définie
    $equipesPoule = array();

    if($_SESSION['poule'] != ''){
        $manager = new EquipeManager();
        $equipesPoule = $manager->equipesPoule($_SESSION['poule']->id());
    } else {
        $equipesPoule = $manager->equipesExempte($_SESSION['tour']->id());
    }
?>

<div class="row row-divider">
    <div class="col-md-1"></div>
    <div class="col-md-2">
        <button type="button" class="btn btn-primary" id="creerPoule">Creer</button>
    </div>

    
    <div class="col-md-3">
        <?php 
        if($_SESSION['poule'] == '') echo '<fieldset disabled>';
            echo '<a class="btn btn-danger active" role="button" id="supprimerPouleBtn">Supprimer</a>';
        if($_SESSION['poule'] == '') echo '</fieldset>';
        ?>
    </div>
    

    <div class="col-md-5">
        <select name="selectPoule" class="form-control" id="selectPoule">
            <option value="-1" <?php echo ($_SESSION['poule'] == '' ) ? 'selected' : '' ; ?> >Exemptée</option>
            <?php
                foreach ($poules as $key => $poule) {
                    if($_SESSION['poule'] == ''){
                        echo '<option value="'.$poule->id().'" >'.$poule->nom().'</option>';
                    } else {
                        echo '<option value="'.$poule->id().'" '.(($poule->memeId($_SESSION['poule'])) ? 'selected':'').'>'.
                            $poule->nom().
                            '</option>';
                    }
                }
            ?>
        </select>
    </div>
    <div class="col-md-1"></div>
</div>

<hr>

<table class="table table-striped" id="tablePoule">
<thead>
<tr>
<th class="th-equipe">Equipe</th>
<th class="th-lieu">Lieu/Distance</th>
<th class="th-commite">Commité</th>
<th class="th-region">Region</th>
<th class="th-km">Km parcouru</th>
<th class="th-coupe">Clmt CFVB</th>
<th class="th-cfvb">Clmt Coupe</th>
<th class="th-suppr">Supp</th>
</tr>
</thead>
<tbody>
    <?php
        foreach ($equipesPoule as $key => $equipe) {
            echo '<tr>
                <td>'.$equipe->club()->nom().'</td>
                <td>'.$equipe->club()->ville().'</td>
                <td>'.$equipe->club()->commite().'</td>
                <td>'.$equipe->club()->region().'</td>
                <td align="center">'.$equipe->nbKmParcouru().'</td>
                <td align="center">'.$equipe->classementCFVB().'</td>
                <td align="center">'.$equipe->classementCoupe().'</td>
                <td align="center">
                    <button type="button" class="btn btn-danger btn-xs" onclick="retirerEquipeModal('.$equipe->id().','.$key.')">
                        X
                    </button>
                </td>
            </tr>';
        }
    ?>
</tbody>
</table>
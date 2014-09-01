<?php 
/*
*
* Créer par : CHAPON Théo
*
*/

/*
*
* Information sur la page :
* Nom : editionPoule.php
* Chemin abs : site\vue\
* Information : page permettant d'afficher l'éditeur de poule qui permettra d'effectuer des modifications sur celles-ci
*
* TOUTES LES VARIABLES $coupes, $tours, $poules ET VARIABLES DE SESSION SONT CHARGEES SOIT DEPUIS editeur.php SOIT DEPUIS
* LA REQUETE AJAX PERMETTANT DE LE RECHARGEMENT DE CETTE PAGE (charger'Page'.php)
*
*/

//les poules sont déjà charger depuis la page editeur.php ou par AJAX dans chargerEditionPoule.php

?>

<?php
    // on récupère les équipes dans la poule si une poule est définie
    $equipesPoule = array();
    $manager = new EquipeManager();

    // on regarde si l'on doit afficher une poule ou les exemptés
    if($_SESSION['poule'] != ''){
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

    <!-- bouton de suppression -->
    <div class="col-md-3">
        <?php 
            if($_SESSION['poule'] == '') {
                echo '<a class="btn btn-danger active" role="button" onclick="retirerEquipe(\'all\')">Supprimer</a>';
            } else {
                echo '<a class="btn btn-danger active" role="button" id="supprimerPouleBtn">Supprimer</a>';
            }
        ?>
    </div>
    

    <!-- liste déroulante des poules -->
    <div class="col-md-3">
        <select name="selectPoule" class="form-control" id="selectPoule">
            <option value="" <?php echo ($_SESSION['poule'] == '' ) ? 'selected' : '' ; ?> >Exemptée</option>
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
    <div class="col-md-2">
        <button type="button" class="btn btn-info" id="afficherPoules">Apperçu</button>
    </div>
</div>

<hr>

<!-- affichage des équipes dans la poule ou parmis les exemptés -->
<table class="table table-striped" id="tablePoule">
    <thead>
        <tr>
            <th class="t-equipe">Equipe</th>
            <th class="t-lieu">Lieu/Distance</th>
            <th class="t-commite">Commité</th>
            <th class="t-region">Region</th>
            <th class="t-km">Km</th>
            <th class="t-coupe">CFVB</th>
            <th class="t-cfvb">Coupe</th>
            <th >Supp</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($equipesPoule as $key => $equipe) {
                echo '<tr>
                    <td class="t-equipe">'.$equipe->club()->nom().'</td>
                    <td class="t-lieu">'.$equipe->club()->ville().'</td>
                    <td class="t-commite">'.$equipe->club()->commite().'</td>
                    <td class="t-region">'.$equipe->club()->region().'</td>
                    <td align="center" class="t-km">'.$equipe->nbKmParcouru().'</td>
                    <td align="center" class="t-coupe">'.$equipe->classementCFVB().'</td>
                    <td align="center" class="t-cfvb">'.$equipe->classementCoupe().'</td>
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
<?php 
/*
*
* Créer par : CHAPON Théo
* Date de modification : 06/08/2014
*
*/

/*
*
* Information sur la page :
* Nom : editionPoule.php
* Chemin abs : site\vue\verification
* Information : page permettant d'afficher l'éditeur de poule sans pouvoir faire de modification
*
*
*/
?>

<?php
    // on récupère les équipes dans la poule si une poule est définie
    $equipesPoule = array();
    $manager = new EquipeManager();

    if($_SESSION['poule'] != ''){
        $equipesPoule = $manager->equipesPoule($_SESSION['poule']->id());
    } else {
        $equipesPoule = $manager->equipesExempte($_SESSION['tour']->id());
    }

?>

<div class="row row-divider">
    <div class="col-md-2"></div>
    <div class="col-md-8">
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
    <div class="col-md-2"></div>
</div>

<hr>

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
</tr>
</thead>
<tbody>
    <?php
        foreach ($equipesPoule as $key => $equipe) {
            $poule = '';
            if($_SESSION['poule'] != ''){
                $poule = $_SESSION['poule']->id();
            }


            if( isset($_SESSION['equipesCritere'][' '.$poule][' '.$equipe->id()]) ){
                echo '<tr>';
            } else {
                echo '<tr style="color:red">';
            }

            echo'
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
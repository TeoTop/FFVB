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
* Nom : menuDeroulant.php
* Chemin abs : site\vue\
* Information : page permettant d'afficher les equipes et les poules sélectionnables
*
* Chaque page php peut potentiellement être découpé en deux partie : une pour son chargement normal, l'autre lorsque celle-ci
* est rechargé par l'intermèdiaire de l'AJAX.
*
*/
?>

<?php
    // on récupère les équipes qualifiées pour le tour de coupe
    $manager = new EquipeManager();
    $equipes = $manager->equipesTour($_SESSION['tour']->id());
?>


<div class="col-xs-12 recherche">
  <input class="form-control" type="search" id="search" placeholder="Chercher"/>
  <span class="glyphicon glyphicon-search"></span>
</div>

<br/><br/>


<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#equipe" onclick="$('#affListe').attr('value','equipe')">
                    Equipes
                </a>
            </h4>
        </div>
        <div id="equipe" class="panel-collapse collapse <?php echo ($affListe=='equipe') ? 'in':''; ?>">
            <div class="panel-body" id="equipeSearch">
                <?php
                    foreach ($equipes as $key => $equipe) {
                        echo '<span onclick="chargerEquipe('.$equipe->id().')">'.$equipe->club()->nom().'</span>';
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#poule" onclick="$('#affListe').attr('value','poule')">
                    Poules
                </a>
            </h4>
        </div>
        <div id="poule" class="panel-collapse collapse <?php echo ($affListe=='poule') ? 'in':''; ?>">
            <div class="panel-body" id="equipeSearch">
                <span onclick="chargerPoule('')">Exemptée</span>
                <?php
                    foreach ($poules as $key => $poule) {
                        echo '<span onclick="chargerPoule('.$poule->id().')">'.$poule->nom().'</span>';
                    }
                ?>
            </div>
        </div>
    </div>
</div>
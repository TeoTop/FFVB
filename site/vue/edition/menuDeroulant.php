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
* Information : page permettant d'afficher les equipes et les poules sélectionnables sous forme de menu déroulant
*
*
*/

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
                <a data-toggle="collapse" data-parent="#accordion" href="#menuEquipe" onclick="changerMenu('equipe')">
                    Equipes
                </a>
            </h4>
        </div>
        <div id="menuEquipe" class="panel-collapse collapse <?php echo ($_SESSION['liste']=='equipe') ? 'in':''; ?>">
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
                <a data-toggle="collapse" data-parent="#accordion" href="#menuPoule" onclick="changerMenu('poule')">
                    Poules
                </a>
            </h4>
        </div>
        <div id="menuPoule" class="panel-collapse collapse <?php echo ($_SESSION['liste']=='poule') ? 'in':''; ?>">
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

<script>
    $('#search').quicksearch('#equipeSearch span');
</script>
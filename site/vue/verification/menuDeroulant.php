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
* Nom : menuDeroulant.php
* Chemin abs : site\vue\verification
* Information : page permettant d'afficher les equipes et les poules sélectionnables sous forme de menu déroulant
*
*
*/
 
///////////////// verification ////////////////////////////

    unset($_SESSION['equipesCritere']);
    $_SESSION['equipesCritere'] = array();


    $manager = new CritereManager();
    $critereDomicile = $manager->criteresType($_SESSION['tour']->id(), 'domicile');

    $critereExterieur = $manager->criteresType($_SESSION['tour']->id(), 'exterieur');

    $critereExempter = $manager->criteresType($_SESSION['tour']->id(), 'exempter');

        

    $manager = new PouleManager();

    // on récupère les équipes qualifiées pour le tour de coupe
    $manager = new EquipeManager();
    $equipes = $manager->equipesTour($_SESSION['tour']->id());



    $nonClasses = $manager->equipeNonClassee($_SESSION['tour']->id());



    // echo $manager->verifierDomicile($critereDomicile, $_SESSION['tour']);
    $_SESSION['equipesCritere'] = array_merge($_SESSION['equipesCritere'],
        $manager->verifierDomicile($critereDomicile, $_SESSION['tour'])); 


    $_SESSION['equipesCritere'] = array_merge($_SESSION['equipesCritere'],
        $manager->verifierExempter($critereExempter, $_SESSION['tour']));

    $exemptees = $manager->equipesExempte($_SESSION['tour']->id()); 

    if(isset($_SESSION['equipesCritere'][' ']) && count($exemptees) == count($_SESSION['equipesCritere'][' '])){
        $_SESSION['equipesCritere'][' ']['erreur'] = false;
    } else {
        $_SESSION['equipesCritere'][' ']['erreur'] = true;
    }
    

    foreach ($poules as $key => $poule) {

        $equipesPoule = $manager->equipesPoule($poule->id());

        if(!empty($equipesPoule)){

            if(!isset($_SESSION['equipesCritere'][' '.$poule->id()])) $_SESSION['equipesCritere'][' '.$poule->id()] = array();
           

            $_SESSION['equipesCritere'][' '.$poule->id()] = array_merge($_SESSION['equipesCritere'][' '.$poule->id()],
                $manager->verifierExterieur($critereExterieur, $_SESSION['tour'], $poule->id(), $equipesPoule));


            if( count($equipesPoule) == count($_SESSION['equipesCritere'][' '.$poule->id()]) && count($equipesPoule) > 2 ){
                $_SESSION['equipesCritere'][' '.$poule->id()]['erreur'] = false;
            } else {
                $_SESSION['equipesCritere'][' '.$poule->id()]['erreur'] = true;
            }

        } else {

            $_SESSION['equipesCritere'][' '.$poule->id()]['erreur'] = true;

        }
    }

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
                        echo '<span class="'.$equipe->id().'" onclick="chargerEquipe('.$equipe->id().')"
                            '.((in_array(strval($equipe->id()), $nonClasses, true)) ? 'style="color:red;"':'').'>'.
                            $equipe->club()->nom()
                        .'</span>';
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
                <?php
                
                    echo '<span onclick="chargerPoule(\'\')" '
                                .( ($_SESSION['equipesCritere'][' ']['erreur']) ? 'style="color:red;"':'' ).'>'.
                                    'Exemptée</span>';
                
                    foreach ($poules as $key => $poule) {
                        echo '<span onclick="chargerPoule('.$poule->id().')" '
                                .( ($_SESSION['equipesCritere'][' '.$poule->id()]['erreur']) ? 'style="color:red;"':'' ).'>'
                                        .$poule->nom().'</span>';
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    $('#search').quicksearch('#equipeSearch span');
</script>
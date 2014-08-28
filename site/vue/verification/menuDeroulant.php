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

    unset($_SESSION['erreurEquipes']);
    $_SESSION['erreurEquipes'] = array();


    $manager = new CritereManager();
    $critereDomicile = $manager->criteresTypeVerif('domicile');

    $critereExterieur = $manager->criteresTypeVerif('exterieur');

    $critereExempter = $manager->criteresTypeVerif('exempter');


    
    // on récupère les équipes qualifiées pour le tour de coupe
    $manager = new EquipeManager();
    $equipes = $manager->equipesTour($_SESSION['tour']->id());



/////////////// vérification equipe du tour //////////////////////

    $nonClasses = $manager->equipeNonClassee($_SESSION['tour']->id());



/////////////// vérification poule du tour //////////////////////

    // echo $manager->verifierDomicile($critereDomicile, $_SESSION['tour']);
    $_SESSION['erreurEquipes'] = array_merge($_SESSION['erreurEquipes'],
        $manager->verifierDomicile($critereDomicile, $_SESSION['tour'])); 


    $_SESSION['erreurEquipes'] = array_merge($_SESSION['erreurEquipes'],
        $manager->verifierExempter($critereExempter, $_SESSION['tour']));

    $exemptees = $manager->equipesExempte($_SESSION['tour']->id()); 


    if(!isset($_SESSION['erreurEquipes'][' '])) $_SESSION['erreurEquipes'][' '] = array();


    if( count($_SESSION['erreurEquipes'][' ']) == 0 ){
        $_SESSION['erreurEquipes'][' ']['erreur'] = false;
    } else {
        $_SESSION['erreurEquipes'][' ']['erreur'] = true;
    }

    
    //poules provient soit de verificateur.php, soit la requete AJAX (chargerMenuDeroulant.php)
    foreach ($poules as $key => $poule) {

        $equipesPoule = $manager->equipesPoule($poule->id());

        if(!empty($equipesPoule)){

            if(!isset($_SESSION['erreurEquipes'][' '.$poule->id()])) $_SESSION['erreurEquipes'][' '.$poule->id()] = array();
           

            $_SESSION['erreurEquipes'][' '.$poule->id()] = array_merge($_SESSION['erreurEquipes'][' '.$poule->id()],
                $manager->verifierExterieur($critereExterieur, $_SESSION['tour'], $poule->id(), $equipesPoule));


            if( count($_SESSION['erreurEquipes'][' '.$poule->id()]) == 0 && count($equipesPoule) > 2 ){
                $_SESSION['erreurEquipes'][' '.$poule->id()]['erreur'] = false;
            } else {
                $_SESSION['erreurEquipes'][' '.$poule->id()]['erreur'] = true;
            }

        } else {

            $_SESSION['erreurEquipes'][' '.$poule->id()]['erreur'] = true;

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
                                .( ($_SESSION['erreurEquipes'][' ']['erreur']) ? 'style="color:red;"':'' ).'>'.
                                    'Exemptée</span>';
                
                    foreach ($poules as $key => $poule) {
                        echo '<span onclick="chargerPoule('.$poule->id().')" '
                                .( ($_SESSION['erreurEquipes'][' '.$poule->id()]['erreur']) ? 'style="color:red;"':'' ).'>'
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
<?php 
/*
*
* Créer par : CHAPON Théo
*
*/

/*
*
* Information sur la page :
* Nom : menuDeroulant.php
* Chemin abs : site\vue\verification
* Information : page permettant d'afficher les equipes et les poules sélectionnables sous forme de menu déroulant
*
* TOUTES LES VARIABLES $coupes, $tours, $poules ET VARIABLES DE SESSION SONT CHARGEES SOIT DEPUIS editeur.php SOIT DEPUIS
* LA REQUETE AJAX PERMETTANT DE LE RECHARGEMENT DE CETTE PAGE (charger'Page'.php)
*
*/
 
///////////////// verification ////////////////////////////

    // on établit le tableau d'erreur

    unset($_SESSION['erreurEquipes']);
    $_SESSION['erreurEquipes'] = array();


    // on récupère tous les critères sélectionnés
    $manager = new CritereManager();
    $critereDomicile = $manager->criteresTypeVerif('domicile');

    $critereExterieur = $manager->criteresTypeVerif('exterieur');

    $critereExempter = $manager->criteresTypeVerif('exempter');


    
    // on récupère les équipes qualifiées pour le tour de coupe
    $manager = new EquipeManager();
    $equipes = $manager->equipesTour($_SESSION['tour']->id());



/////////////// vérification equipe du tour //////////////////////

    // on check si des équipes ne sont pas classées
    $nonClasses = $manager->equipeNonClassee($_SESSION['tour']->id());



/////////////// vérification poule du tour //////////////////////

    // on récupère les erreurs des critères domiciles
    $_SESSION['erreurEquipes'] = array_merge($_SESSION['erreurEquipes'],
        $manager->verifierDomicile($critereDomicile, $_SESSION['tour'])); 

    // on récupère les erreurs des critères exemptés
    $_SESSION['erreurEquipes'] = array_merge($_SESSION['erreurEquipes'],
        $manager->verifierExempter($critereExempter, $_SESSION['tour']));

    // on récupère les équipes exemptées
    $exemptees = $manager->equipesExempte($_SESSION['tour']->id()); 

    // si il n'y avait aucune erreur parmis les exemptés, on initialise un tableau vide
    if(!isset($_SESSION['erreurEquipes'][' '])) $_SESSION['erreurEquipes'][' '] = array();

    // on regarde si le nombre d'erreur est à zéro parmis les exemptés
    if( count($_SESSION['erreurEquipes'][' ']) == 0 ){
        $_SESSION['erreurEquipes'][' ']['erreur'] = false;
    } else {
        $_SESSION['erreurEquipes'][' ']['erreur'] = true;
    }

    
    // on boucle sur chaque poule pour vérifier les critères exterieurs
    foreach ($poules as $key => $poule) {

        // on récupère les équipes de la poule
        $equipesPoule = $manager->equipesPoule($poule->id());

        // si la poule n'est pas vide
        if(!empty($equipesPoule)){

            // on regarde si il y avait déjà des erreurs sur cette poule provenant de l'équipe à domicile
            if(!isset($_SESSION['erreurEquipes'][' '.$poule->id()])) $_SESSION['erreurEquipes'][' '.$poule->id()] = array();
           
            // on vérifie les équipes de la poules avec les critères exterieurs
            $_SESSION['erreurEquipes'][' '.$poule->id()] = array_merge($_SESSION['erreurEquipes'][' '.$poule->id()],
                $manager->verifierExterieur($critereExterieur, $_SESSION['tour'], $poule->id(), $equipesPoule));

            // on regarde si il y a des erreurs dans la poule et que celle-ci possède au moins  équipes
            if( count($_SESSION['erreurEquipes'][' '.$poule->id()]) == 0 && count($equipesPoule) > 2 ){
                $_SESSION['erreurEquipes'][' '.$poule->id()]['erreur'] = false;
            } else {
                $_SESSION['erreurEquipes'][' '.$poule->id()]['erreur'] = true;
            }

        } else {
            // si la poule est vide, il y a forcement une erreur
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
                        //si l'équipe n'est pas classé, on l'affiche en rouge
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
                    //si il y a une erreur dans la poule on l'affiche en rouge
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
    // on active la recherche rapide
    $('#search').quicksearch('#equipeSearch span');
</script>
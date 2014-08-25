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
* Nom : verificateur.php
* Chemin abs : site\vue\
* Information : page de vérification des poules
* Page permettant de vérifier si les poules respectent bien les critères
*
*/


    // permet de définir l'année actuel, si non définie, pour récupérer les coupes.
    if (!isset($_SESSION['annee'])) {
        $_SESSION['annee'] = date("Y");
        
        if(date("n") <= 7) $_SESSION['annee']--;
    } 


/////////////////// gestion de la coupe /////////////////////


    //on récupère notre gestionnaire de données de la base pour l'objet Coupe
    $manager = new CoupeManager();
    // on récupère les coupes présentent dans la base pour telle année
    $coupes = $manager->coupes($_SESSION['annee']);

    $change = true;

    //on test les valeurs qui sont envoyées
    if(isset($_GET['c'])){                      //on récupère la coupe passée en GET ( depuis l'accueil )
       
        $coupe = $_GET['c'];
    
    } else if(isset($_POST['coupe'])){          // on récupère la coupe passé en POST ( sélection de la coupe )
       
        $coupe = $_POST['coupe'];
    
    } else if(!isset($_SESSION['coupe'])){          // on charge la première coupe si on arrive sur la page ( chargement régulier depuis l'index )
        
        $coupe = current($coupes)->id();
    
    } else {
        $coupe = $_SESSION['coupe']->id();
        $change = false;
    }


    // si coupe n'est pas numeric et qu'elle ne figure pas dans la base, on affice la page d'erreur
    if( !(is_numeric($coupe) && $manager->existe($coupe)) ){
        unset($_SESSION);
        include V . 'erreur.php';
        die();
    }


    // on place l'objet coupe en variable de session
    $_SESSION['coupe'] = $manager->coupe($coupe);
    


/////////////////// gestion du tour ////////////////////////
    

    // on récupère le tour le plus avancé de chaque catégorie de coupe
    $manager = new TourManager();
    $tours = $manager->tours($_SESSION['coupe']);

    if(isset($_GET['t'])){     

        //on ne peut pas avoir de tour si la coupe n'est pas sélectionner avec GET
        if(!isset($_GET['c'])){     
            unset($_SESSION);
            include V . 'erreur.php';
            die();
        }

        $tour = $_GET['t'];
    
    } else if(isset($_POST['tour'])) {              //on a passer le tour en paramètre, une coupe est déjà sélectionné (sélection du tour)
       
        $tour = $_POST['tour'];
    
    } else if( !isset($_SESSION['tour']) || $change ){    //on vient de modifier la coupe ou de passer la uniquement la coupe en param
        
        $tour = end($tours)->id();

    } else {
        $tour = $_SESSION['tour']->id();
    }


    // si coupe n'est pas un int et qu'elle ne figure pas dans la base, on affice la page d'erreur
    if( !(is_numeric($tour) && $manager->existe($coupe, $tour)) ){
        unset($_SESSION);
        include V . 'erreur.php';
        die();
    }

    $_SESSION['tour'] = $manager->tour($tour, $_SESSION['coupe']);
    


//////////////////// gestion de la poule ///////////////////////////


    // on récupère les poules du tour de coupe
    $manager = new PouleManager();
    $poules = $manager->poules($_SESSION['tour']->id());

    //récupération de la poule à afficher, si il n'y en a pas, on affiche la poule exempté
    if(!isset($_SESSION['poule']) || $change){
        if(!empty($poules)){

            $_SESSION['poule'] = reset($poules);

        } else {

            $_SESSION['poule'] = '';

        }
    }




/////////////////// gestion de l'affichage //////////////////////////

    //récupération de l'affichage au niveau des critères
    if(!isset($_SESSION['critere'])){
        $_SESSION['critere'] = 'domicile';
    }



    //récupération de l'affichage au niveau du menu déroulant
    if(!isset($_SESSION['liste'])){
        $_SESSION['liste'] = 'equipe';
    }


?>

<!-- pour le javascript -->
<input type="hidden" id="affCritere" value="<?php echo $_SESSION['critere'] ?>">

<div class="haut">

    <div class="liste" id="liste">
    	<?php
    		include V . 'verification/menuDeroulant.php';
        ?>
    </div>
    
    <div class="edition">
        <div class="competition">
            <?php
        		include V . 'verification/tourSelect.php';
            ?>
        </div>
        
        <div class="critere">
        	<?php
                include V . 'verification/criteres.php';
            ?>
        </div>
            
    </div>
</div>

<div class="poule" id="poule">
    <?php
        include V . 'verification/editionPoule.php';
    ?>
</div>

<!--<div class="indicateur" id="indicateur">
    <?php
        //include V . 'verification/indicateur.php';
    ?>
</div>-->

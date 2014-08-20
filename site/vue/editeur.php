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
* Nom : editeur.php
* Chemin abs : site\vue\
* Information : page d'edition des tours de coupe
* Page permettant de créer et de gérer les poules lors des tours de coupes
*
* Chaque page php peut potentiellement être découpé en deux partie : une pour son chargement normal, l'autre lorsque celle-ci
* est rechargé par l'intermèdiaire de l'AJAX.
*
*/

?>

<?php
    // permet de savoir si cette page a été recharger à partir d'une requete AJAX
    if(isset($_POST['ajax']) && $_POST['ajax'] == true){
    	define('V', '../vue/');

        function chargerClasseEditeur($classe)
        {
            require '../model/' . $classe . '.class.php'; // On inclut la classe correspondante au paramètre passé.
        }

        spl_autoload_register('chargerClasseEditeur');

        require '../bdd.php';
    }


    //ouverture d'un session ATTENTION : le session start DOIT être placé APRES le chargement des classes
    session_start();


	// permet de définir l'année actuel, si non définie, pour récupérer les coupes.
    if (!isset($_SESSION['annee'])) {
        $_SESSION['annee'] = date("Y");
        
        if(date("n") <= 7) $_SESSION['annee']--;
    } 


/////////////////// gestion de la coupe /////////////////////

    // on récupère les coupes présentent dans la base pour telle année
    $manager = new CoupeManager();
    $coupes = $manager->coupes($_SESSION['annee']);

    if(isset($_GET['c'])){                      //on récupère la coupe passée en GET ( depuis l'accueil )
       
        $_SESSION['coupe'] = $manager->coupe($_GET['c']);
    
    } else if(isset($_POST['coupe'])){          // on récupère la coupe passé en POST ( sélection de la coupe )
       
        $_SESSION['coupe'] = $manager->coupe($_POST['coupe']);
    
    } else if(!isset($_POST['ajax'])){          // on charge la première coupe si on arrive sur la page ( chargement régulier depuis l'index )
    	
        $_SESSION['coupe'] = current($coupes);
    }


/////////////////// gestion du tour ////////////////////////
    
    // on récupère le tour le plus avancé de chaque catégorie de coupe
    $manager = new TourManager();
    $tours = $manager->tours($_SESSION['coupe']);

    if(isset($_GET['c']) && isset($_GET['t'])){     //on ne peut pas avoir de tour si la coupe n'est pas sélectionner avec GET
        
        $_SESSION['tour'] = $manager->tour($_GET['t'], $_SESSION['coupe']);
    
    } else if(isset($_POST['tour'])) {              //on a passer le tour en paramètre, une coupe est déjà sélectionné (sélection du tour)
       
        $_SESSION['tour'] = $manager->tour($_POST['tour'], $_SESSION['coupe']);
    
    } else if(isset($_GET['c']) || isset($_POST['coupe'])){    //on vient de modifier la coupe ou de passer la uniquement la coupe en param
	    
        $_SESSION['tour'] = end($tours);
    }
    

//////////////////// gestion de la poule ///////////////////////////

    // on récupère les poules du tour de coupe
    $manager = new PouleManager();
    $poules = $manager->poules($_SESSION['tour']->id());

    //récupération de la poule à afficher, poule = "" quand on a supprimer la dernière poule
    if(isset($_POST['poule'])){
    
        if($_POST['poule'] != ''){
            $_SESSION['poule'] = $manager->poule($_POST['poule']);
        } else {
            $_SESSION['poule'] = $_POST['poule'];
        }

    } else {

        if(!empty($poules)){

            if( isset($_GET['c']) || isset($_GET['coupe']) || isset($_GET['tour']) ) 
                // $poules provient de la vue menuDeroulant
                $_SESSION['poule'] = reset($poules);

        } else {
            $_SESSION['poule'] = '';
        }

    }



/////////////////// gestion de l'affichage //////////////////////////


    //récupération de l'affichage au niveau du menu déroulant
    if(isset($_POST['liste'])){
        $affListe = $_POST['liste'];
    } else {
        $affListe = 'equipe';
    }

    //récupération de l'affichage au niveau des critères
    if(isset($_POST['critere'])){
        $affCritere = $_POST['critere'];
    } else {
        $affCritere = 'domicile';
    }

    //on récupère l'ordre pour savoir comment trier les equipes
    if(isset($_POST['ordre'])){
        $ordre = $_POST['ordre'];
    } else {
        $ordre = 'nom';
    }
?>

<!-- Permet de sauvgarder l'affichage actuel lors du rechargement par AJAX -->
<input type="hidden"  id="affListe"  value=<?php echo $affListe; ?> />
<input type="hidden"  id="affCritere"  value="<?php echo $affCritere; ?>" />

<!-- Modal permettant de signaler la suppression d'une poule non vide -->
<div class="modal fade" id="supprimerPouleModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content attention">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
                <h4 class="modal-title">Suppression de poule non vide</h4>
            </div>
            <div class="modal-body">
                <p>Cette poule n'est pas vide. Voulez-vous quand même la supprimer?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal" id="supprimerPoule">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal permettant de signaler la suppression de l'équipe à domicile alors que la poule contient des équipes exterieurs -->
<div class="modal fade" id="retirerEquipeModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content attention">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
                <h4 class="modal-title">Suppression d'une équipe domicile</h4>
            </div>
            <div class="modal-body">
                <p>Vous souhaitez retirer l'équipe qui doit recevoir, cette action va retirer la totalité des équipes dans cette poule. Voulez-vous continuer?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal" onclick="retirerEquipe('all')">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal permettant d'afficher des informations -->
<div class="modal fade" role="dialog" id="informationModal">
    <div class="modal-dialog">
        <div class="modal-content information">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
                <h4 class="modal-title" id="informationTitle"></h4>
            </div>
            <div class="modal-body" id="informationBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>



<div class="haut">

    <div class="liste">
    	<?php
    		include V . 'menuDeroulant.php';
        ?>
    </div>
    
    <div class="edition">
        <div class="competition">
            <?php
        		include V . 'tourSelect.php';
            ?>
        </div>
        
        <div class="critere">
        	<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				
                <li <?php echo ($affCritere=='domicile') ? 'class="active"':''; ?> onclick="changerCriteres('domicile')">
                    <a href="#domicile" role="tab" data-toggle="tab">Domicile</a>
                </li>

				<li <?php echo ($affCritere=='exterieur') ? 'class="active"':''; ?> onclick="changerCriteres('exterieur')">
                    <a href="#exterieur" role="tab" data-toggle="tab">Exterieur</a>
                </li>

				<li <?php echo ($affCritere=='exempter') ? 'class="active"':''; ?> onclick="changerCriteres('exempter')">
                    <a href="#exempter" role="tab" data-toggle="tab">Exempter</a>
                </li>

			</ul>

			<!-- Tab panes -->
			<div class="tab-content">

				<div class="tab-pane fade <?php echo ($affCritere=='domicile') ? 'in active':''; ?>" id="domicile">
					<?php
		        		include V . 'critereDomicile.php';
		            ?>
				</div>

				<div class="tab-pane fade <?php echo ($affCritere=='exterieur') ? 'in active':''; ?>" id="exterieur">
					<?php
		        		include V . 'critereExterieur.php';
		            ?>
				</div>

				<div class="tab-pane fade <?php echo ($affCritere=='exempter') ? 'in active':''; ?>" id="exempter">
					<?php
		        		include V . 'critereExempter.php';
		            ?>
				</div>

			</div>
        </div>
            
    </div>
</div>

<div class="equipe">
    <?php
        if($affCritere=='domicile'){
            include V . 'equipeCritereDomicile.php';
        } else if($affCritere=='exterieur'){
            include V . 'equipeCritereExterieur.php';
        } else {
            include V . 'equipeCritereExempter.php';
        }
    ?>
</div>

<div class="poule">
    <?php
        include V . 'editionPoule.php';
    ?>
</div>


<?php
    //si on recharge la page avec de l'AJAX, le script associé n'est plus actif, il faut donc le recharger lui aussi.
    if(isset($_POST['ajax']) && $_POST['ajax'] == true){
        echo '<script type="text/javascript" src="site/js/jquery.tablesorter.min.js"></script>';
        echo '<script type="text/javascript" src="site/js/jquery.quicksearch.js"></script>';
        echo '<script type="text/javascript" src="site/js/editeur.js"></script>';
    }
?>
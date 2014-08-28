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
* Nom : tourSelect.php
* Chemin abs : site\vue\
* Information : page permettant d'afficher les coupes et tours sélectionnables
*
* TOUTES LES VARIABLES $coupes, $tours, $poules ET VARIABLES DE SESSION SONT CHARGEES SOIT DEPUIS editeur.php SOIT DEPUIS
* LA REQUETE AJAX PERMETTANT DE LE RECHARGEMENT DE CETTE PAGE (charger'Page'.php)
*
*/
?>

<div class="form-group">

	<label for="petiteEquipe" class="col-md-2">Coupe :</label>
	<div class="col-md-4">
		<select class="form-control" id="selectCoupe">
			<?php
		    	foreach ($coupes as $key => $coupe) {
		    		//on regarde si c'est celui qui est en session
		            echo '<option value="'.$coupe->id().'" '.(( $coupe->memeId($_SESSION['coupe']) ) ? 'selected':'').'>'.
		            		$coupe->categorie().
		            	'</option>';
		        }
		    ?>
		</select>
	</div>

	<label for="petiteEquipe" class="col-md-2">Tour :</label>
	<div class="col-md-4">
		<select class="form-control" id="selectTour">
		    <?php
		    	foreach ($tours as $key => $tour) {
		    		//on regarde si c'est celui qui est en session
		            echo '<option value="'.$tour->id().'" '.(( $tour->memeId($_SESSION['tour']) ) ? 'selected':'').'>'.
		            		'tour '.$tour->numero().
		            	'</option>';
		        }
		    ?>
		</select>
	</div>
</div>

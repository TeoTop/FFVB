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
* Information : page permettant d'afficher les coupes et tours séectionnables
*
* Chaque page php peut potentiellement être découpé en deux partie : une pour son chargement normal, l'autre lorsque celle-ci
* est rechargé par l'intermèdiaire de l'AJAX.
*
*/
?>

<div class="form-group">

	<label for="petiteEquipe" class="col-md-2">Coupe :</label>
	<div class="col-md-4">
		<select class="form-control" id="selectCoupe">
			<?php
		    	foreach ($coupes as $key => $coupe) {
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
		            echo '<option value="'.$tour->id().'" '.(( $tour->memeId($_SESSION['tour']) ) ? 'selected':'').'>'.
		            		'tour '.$tour->numero().
		            	'</option>';
		        }
		    ?>
		</select>
	</div>
</div>

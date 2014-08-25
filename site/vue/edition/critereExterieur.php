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
* Nom : critereExterieur.php
* Chemin abs : site\vue\
* Information : page permettant d'afficher les critères pour sélectionner l'équipe qui va jouer à l'extèrieur
*
*
*/


	// on récupère les critères utilsées pour ce tour de coupe et ce type de critère
    $manager = new CritereManager();
    $critereExterieur = $manager->criteresType($_SESSION['tour']->id(), 'exterieur');
?>

<form class="form-horizontal" role="form" id="exterieurForm">

	<div class="form-group">
		<div class="col-md-6">
			<label class="checkbox-inline">
				<input type="checkbox" name="affronter" id="9" value="true"
					<?php echo ($manager->selectionner($critereExterieur, 9)) ? 'checked' : '' ; ?> > Affrontement préalable
			</label>
		</div>

		<div class="col-md-6">
			<label class="checkbox-inline">
				<input type="checkbox" name="memeDepart" id="10" value="true"
					<?php echo ($manager->selectionner($critereExterieur, 10)) ? 'checked' : '' ; ?> > Même département
			</label>
		</div>
	</div>

	<div class="form-group">
		<label for="posPrcd" class="col-md-4">Position tour prcd :</label>
		<div class="col-md-2">
			<select name="posPrcd" class="form-control posPrcd" id="7">
				<option value="-1" <?php echo ($manager->selectionnerOption($critereExterieur, 7, -1)) ? 'selected' : '' ; ?> >
				</option>
				<option value="1" <?php echo ($manager->selectionnerOption($critereExterieur, 7, 1)) ? 'selected' : '' ; ?> >
					1
				</option>
				<option value="2" <?php echo ($manager->selectionnerOption($critereExterieur, 7, 2)) ? 'selected' : '' ; ?> >
					2
				</option>

			</select>
		</div>
		
		<label for="equipeForte" class="col-md-4">Equipe forte :</label>
		<div class="col-md-2">
			<select name="equipeForte" class="form-control equipeForte" id="8">
				<option value="-1" <?php echo ($manager->selectionnerOption($critereExterieur, 8, -1)) ? 'selected' : '' ; ?> >
				</option>
				<option value="500" <?php echo ($manager->selectionnerOption($critereExterieur, 8, 500)) ? 'selected' : '' ; ?> >
					500
				</option>
				<option value="600" <?php echo ($manager->selectionnerOption($critereExterieur, 8, 600)) ? 'selected' : '' ; ?> >
					600
				</option>
				<option value="700" <?php echo ($manager->selectionnerOption($critereExterieur, 8, 700)) ? 'selected' : '' ; ?> >
					700
				</option>
				<option value="800" <?php echo ($manager->selectionnerOption($critereExterieur, 8, 800)) ? 'selected' : '' ; ?> >
					800
				</option>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label for="distance" class="col-md-4">Distance à parcourir :</label>
		<div class="col-md-3">
			<select name="distance" class="form-control distance" id="11">
				<option value="-1" <?php echo ($manager->selectionnerOption($critereExterieur, 11, -1)) ? 'selected' : '' ; ?> >
				</option>
				<option value="150" <?php echo ($manager->selectionnerOption($critereExterieur, 11, 150)) ? 'selected' : '' ; ?> >
					150
				</option>
				<option value="400" <?php echo ($manager->selectionnerOption($critereExterieur, 11, 400)) ? 'selected' : '' ; ?> >
					400
				</option>
				<option value="600" <?php echo ($manager->selectionnerOption($critereExterieur, 11, 600)) ? 'selected' : '' ; ?> >
					600
				</option>
				<option value="2000" <?php echo ($manager->selectionnerOption($critereExterieur, 11, 2000)) ? 'selected' : '' ; ?> >
					2000
				</option>
			</select>
		</div>
	</div>

</form>
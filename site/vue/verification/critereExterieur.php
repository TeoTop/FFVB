<?php 
/*
*
* Créer par : CHAPON Théo
* Date de money_format(format, number)dification : 06/08/2014
*
*/

/*
*
* Information sur la page :
* Nom : critereExterieur.php
* Chemin abs : site\vue\verification
* Information : page permettant d'afficher les critères pour sélectionner l'équipe qui va jouer à l'extèrieur
*
*
*/

	$manager = new CritereManager();
    $aideExterieur = $manager->criteresTypeAll('exterieur');
?>

<form class="form-horizontal" role="form" id="exterieurForm">

	<div class="form-group">
		<div class="col-md-6">
			<label class="checkbox-inline" title="<?php echo $manager->aide($aideExterieur, 9); ?>">
				<input type="checkbox" name="affronter" id="9" value="true"
					<?php echo ($manager->selectionner($critereExterieur, 9)) ? 'checked' : '' ; ?> > Affrontement préalable
			</label>
		</div>

		<div class="col-md-6">
			<label class="checkbox-inline" title="<?php echo $manager->aide($aideExterieur, 10); ?>">
				<input type="checkbox" name="memeDepart" id="10" value="true"
					<?php echo ($manager->selectionner($critereExterieur, 10)) ? 'checked' : '' ; ?> > Même département
			</label>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6">
			<label class="checkbox-inline" title="<?php echo $manager->aide($aideExterieur, 7); ?>">
				<input type="checkbox" name="posPrcd" id="7" value="true"
					<?php echo ($manager->selectionner($critereExterieur, 7)) ? 'checked' : '' ; ?> > Position tour prcd
			</label>
		</div>
		
		<label for="nbKm" class="col-md-3" title="<?php echo $manager->aide($aideExterieur, 19); ?>">Km parcouru :</label>
		<div class="col-md-3">
			<select name="nbKm" class="form-control nbKm" id="19">
				<option value="-1" <?php echo ($manager->selectionnerOption($critereExterieur, 19, -1)) ? 'selected' : '' ; ?> >
				</option>
				<option value="200" <?php echo ($manager->selectionnerOption($critereExterieur, 19, 200)) ? 'selected' : '' ; ?> >
					200
				</option>
				<option value="500" <?php echo ($manager->selectionnerOption($critereExterieur, 19, 500)) ? 'selected' : '' ; ?>>
					500
				</option>
				<option value="700" <?php echo ($manager->selectionnerOption($critereExterieur, 19, 700)) ? 'selected' : '' ; ?>>
					700
				</option>
				<option value="1000" <?php echo ($manager->selectionnerOption($critereExterieur, 19, 1000)) ? 'selected' : '' ; ?>>
					1000
				</option>
				<option value="1400" <?php echo ($manager->selectionnerOption($critereExterieur, 19, 1400)) ? 'selected' : '' ; ?>>
					1400
				</option>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label for="clsCoupe" class="col-md-3" title="<?php echo $manager->aide($aideExterieur, 8); ?>">Cls coupe :</label>
		<div class="col-md-3">
			<select name="clsCoupe" class="form-control cls" id="8">
				<option value="-1" <?php echo ($manager->selectionnerOption($critereExterieur, 8, -1)) ? 'selected' : '' ; ?> >
				</option>
				<option value="300" <?php echo ($manager->selectionnerOption($critereExterieur, 8, 300)) ? 'selected' : '' ; ?> >
					300
				</option>
				<option value="500" <?php echo ($manager->selectionnerOption($critereExterieur, 8, 500)) ? 'selected' : '' ; ?>>
					500
				</option>
				<option value="600" <?php echo ($manager->selectionnerOption($critereExterieur, 8, 600)) ? 'selected' : '' ; ?>>
					600
				</option>
				<option value="700" <?php echo ($manager->selectionnerOption($critereExterieur, 8, 700)) ? 'selected' : '' ; ?>>
					700
				</option>
				<option value="800" <?php echo ($manager->selectionnerOption($critereExterieur, 8, 800)) ? 'selected' : '' ; ?>>
					800
				</option>
				<option value="900" <?php echo ($manager->selectionnerOption($critereExterieur, 8, 900)) ? 'selected' : '' ; ?>>
					900
				</option>
			</select>
		</div>

		
		<label for="clsCFVB" class="col-md-3" title="<?php echo $manager->aide($aideExterieur, 18); ?>">Cls CFVB :</label>
		<div class="col-md-3">
			<select name="clsCFVB" class="form-control cls" id="18">
				<option value="-1" <?php echo ($manager->selectionnerOption($critereExterieur, 18, -1)) ? 'selected' : '' ; ?> >
				</option>
				<option value="500" <?php echo ($manager->selectionnerOption($critereExterieur, 18, 500)) ? 'selected' : '' ; ?> >
					500
				</option>
				<option value="1000" <?php echo ($manager->selectionnerOption($critereExterieur, 18, 1000)) ? 'selected' : '' ; ?>>
					1000
				</option>
				<option value="1500" <?php echo ($manager->selectionnerOption($critereExterieur, 18, 1500)) ? 'selected' : '' ; ?>>
					1500
				</option>
				<option value="2000" <?php echo ($manager->selectionnerOption($critereExterieur, 18, 2000)) ? 'selected' : '' ; ?>>
					2000
				</option>
				<option value="2500" <?php echo ($manager->selectionnerOption($critereExterieur, 18, 2500)) ? 'selected' : '' ; ?>>
					2500
				</option>
				<option value="3000" <?php echo ($manager->selectionnerOption($critereExterieur, 18, 3000)) ? 'selected' : '' ; ?>>
					3000
				</option>
				<option value="4000" <?php echo ($manager->selectionnerOption($critereExterieur, 18, 4000)) ? 'selected' : '' ; ?>>
					4000
				</option>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label for="distance" class="col-md-4" title="<?php echo $manager->aide($aideExterieur, 11); ?>">Distance à parcourir :</label>
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
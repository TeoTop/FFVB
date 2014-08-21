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
* Nom : critereExempter.php
* Chemin abs : site\vue\
* Information : page permettant d'afficher les critères pour sélectionner les équipes qui seront exemptées
*
*
*/


	// on récupère les critères utilsées pour ce tour de coupe et ce type de critère
    $manager = new CritereManager();
    $critereExempter = $manager->criteresType($_SESSION['tour']->id(), 'exempter');
?>

<form class="form-horizontal" role="form" id="exempterForm">
	<div class="form-group">
		<div class="col-md-6">
			<label class="checkbox-inline">
				<input type="checkbox" name="vainqueur" id="13" value="true"
					<?php echo ($manager->selectionner($critereExempter, 13)) ? 'checked' : '' ; ?> > Vainqueur
			</label>
		</div>

		<div class="col-md-6">
			<label class="checkbox-inline">
				<input type="checkbox" name="vainqueurInf" id="14" value="true"
					<?php echo ($manager->selectionner($critereExempter, 14)) ? 'checked' : '' ; ?> > Vainqueur inférieur
			</label>
		</div>
	</div>

	<div class="form-group">
		<label for="avba" class="col-md-4">Classement Coupe :</label>
		<div class="col-md-3">
			<select name="avba" class="form-control avba" id="12">
				<option value="-1" <?php echo ($manager->selectionnerOption($critereExempter, 12, -1)) ? 'selected' : '' ; ?> >
				</option>
				<option value="500" <?php echo ($manager->selectionnerOption($critereExempter, 12, 500)) ? 'selected' : '' ; ?> >
					500
				</option>
				<option value="600" <?php echo ($manager->selectionnerOption($critereExempter, 12, 600)) ? 'selected' : '' ; ?> >
					600
				</option>
				<option value="700" <?php echo ($manager->selectionnerOption($critereExempter, 12, 700)) ? 'selected' : '' ; ?> >
					700
				</option>
				<option value="800" <?php echo ($manager->selectionnerOption($critereExempter, 12, 800)) ? 'selected' : '' ; ?> >
					800
				</option>
			</select>
		</div>
	</div>
		
	<div class="form-group">
		<label for="equipeIsolee" class="col-md-3">Equipe isolée :</label>
		<div class="col-md-3">
			<select name="equipeIsolee" class="form-control" id="15">
				<option value="-1" <?php echo ($manager->selectionnerOption($critereExempter, 15, -1)) ? 'selected' : '' ; ?> >
				</option>
				<option value="150" <?php echo ($manager->selectionnerOption($critereExempter, 15, 150)) ? 'selected' : '' ; ?> >
					150
				</option>
				<option value="200" <?php echo ($manager->selectionnerOption($critereExempter, 15, 200)) ? 'selected' : '' ; ?> >
					200
				</option>
				<option value="300" <?php echo ($manager->selectionnerOption($critereExempter, 15, 300)) ? 'selected' : '' ; ?> >
					300
				</option>
				<option value="500" <?php echo ($manager->selectionnerOption($critereExempter, 15, 500)) ? 'selected' : '' ; ?> >
					500
				</option>
			</select>
		</div>
	</div>
</form>
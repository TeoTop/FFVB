<?php 
/*
*
* Créer par : CHAPON Théo
*
*/

/*
*
* Information sur la page :
* Nom : critereExempter.php
* Chemin abs : site\vue\
* Information : page permettant d'afficher les critères pour sélectionner les équipes qui seront exemptées
*
* TOUTES LES VARIABLES $coupes, $tours, $poules ET VARIABLES DE SESSION SONT CHARGEES SOIT DEPUIS editeur.php SOIT DEPUIS
* LA REQUETE AJAX PERMETTANT DE LE RECHARGEMENT DE CETTE PAGE (charger'Page'.php)
*
*/


	// on récupère les critères utilsées pour ce tour de coupe et ce type de critère
    $manager = new CritereManager();
    $critereExempter = $manager->criteresType('exempter', $_SESSION['inverser']);
    $aideExempter = $manager->criteresTypeAll('exempter');

    //pour chaque critère, on regarde si celui-ci est sélectionné
?>

<form class="form-horizontal" role="form" id="exempterForm">
	<div class="form-group">
		<div class="col-md-3">
			<label class="checkbox-inline" title="<?php echo $manager->aide($aideExempter, 13); ?>">
				<input type="checkbox" name="vainqueur" id="13" value="true"
					<?php echo ($manager->selectionner($critereExempter, 13)) ? 'checked' : '' ; ?> > Vainqueur
			</label>
		</div>

		<div class="col-md-5">
			<label class="checkbox-inline"  title="<?php echo $manager->aide($aideExempter, 14); ?>">
				<input type="checkbox" name="vainqueurInf" id="14" value="true"
					<?php echo ($manager->selectionner($critereExempter, 14)) ? 'checked' : '' ; ?> > Vainqueur inférieur
			</label>
		</div>

		<div class="col-md-4">
			<label class="checkbox-inline" title="<?php echo $manager->aide($aideExempter, 21); ?>">
				<input type="checkbox" name="dejaExempter" id="21" value="true"
					<?php echo ($manager->selectionner($critereExempter, 21)) ? 'checked' : '' ; ?> > Déjà exempté
			</label>
		</div>
	</div>

	<div class="form-group">
		<label for="clsCoupe" class="col-md-3" title="<?php echo $manager->aide($aideExempter, 16); ?>">Cls coupe :</label>
		<div class="col-md-3">
			<select name="clsCoupe" class="form-control cls" id="16">
				<option value="-1" <?php echo ($manager->selectionnerOption($critereExempter, 16, -1)) ? 'selected' : '' ; ?> >
				</option>
				<option value="300" <?php echo ($manager->selectionnerOption($critereExempter, 16, 300)) ? 'selected' : '' ; ?> >
					300
				</option>
				<option value="500" <?php echo ($manager->selectionnerOption($critereExempter, 16, 500)) ? 'selected' : '' ; ?>>
					500
				</option>
				<option value="600" <?php echo ($manager->selectionnerOption($critereExempter, 16, 600)) ? 'selected' : '' ; ?>>
					600
				</option>
				<option value="700" <?php echo ($manager->selectionnerOption($critereExempter, 16, 700)) ? 'selected' : '' ; ?>>
					700
				</option>
				<option value="800" <?php echo ($manager->selectionnerOption($critereExempter, 16, 800)) ? 'selected' : '' ; ?>>
					800
				</option>
				<option value="900" <?php echo ($manager->selectionnerOption($critereExempter, 16, 900)) ? 'selected' : '' ; ?>>
					900
				</option>
			</select>
		</div>

		
		<label for="clsCFVB" class="col-md-3" title="<?php echo $manager->aide($aideExempter, 20); ?>">Cls CFVB :</label>
		<div class="col-md-3">
			<select name="clsCFVB" class="form-control cls" id="20">
				<option value="-1" <?php echo ($manager->selectionnerOption($critereExempter, 20, -1)) ? 'selected' : '' ; ?> >
				</option>
				<option value="500" <?php echo ($manager->selectionnerOption($critereExempter, 20, 500)) ? 'selected' : '' ; ?> >
					500
				</option>
				<option value="1000" <?php echo ($manager->selectionnerOption($critereExempter, 20, 1000)) ? 'selected' : '' ; ?>>
					1000
				</option>
				<option value="1500" <?php echo ($manager->selectionnerOption($critereExempter, 20, 1500)) ? 'selected' : '' ; ?>>
					1500
				</option>
				<option value="2000" <?php echo ($manager->selectionnerOption($critereExempter, 20, 2000)) ? 'selected' : '' ; ?>>
					2000
				</option>
				<option value="2500" <?php echo ($manager->selectionnerOption($critereExempter, 20, 2500)) ? 'selected' : '' ; ?>>
					2500
				</option>
				<option value="3000" <?php echo ($manager->selectionnerOption($critereExempter, 20, 3000)) ? 'selected' : '' ; ?>>
					3000
				</option>
				<option value="4000" <?php echo ($manager->selectionnerOption($critereExempter, 20, 4000)) ? 'selected' : '' ; ?>>
					4000
				</option>
			</select>
		</div>
	</div>
		
	<div class="form-group">
		<label for="equipeIsolee" class="col-md-3" title="<?php echo $manager->aide($aideExempter, 15); ?>">Equipe isolée :</label>
		<div class="col-md-3">
			<select name="equipeIsolee" class="form-control equipeIsolee" id="15">
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
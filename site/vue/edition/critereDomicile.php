<?php 
/*
*
* Créer par : CHAPON Théo
*
*/

/*
*
* Information sur la page :
* Nom : critereDomicile.php
* Chemin abs : site\vue\
* Information : page permettant d'afficher les critères pour sélectionner l'équipe qui va jouer à domicile
*
* TOUTES LES VARIABLES $coupes, $tours, $poules ET VARIABLES DE SESSION SONT CHARGEES SOIT DEPUIS editeur.php SOIT DEPUIS
* LA REQUETE AJAX PERMETTANT DE LE RECHARGEMENT DE CETTE PAGE (charger'Page'.php)
*
*/


	// on récupère les critères utilsées pour ce tour de coupe et ce type de critère
    $manager = new CritereManager();
    $critereDomicile = $manager->criteresType('domicile');
    $aideDomicile = $manager->criteresTypeAll('domicile');


    //pour chaque critère, on regarde si celui-ci est sélectionné
?>

<form class="form-horizontal" role="form" id="domicileForm">
	<div class="form-group">
		<div class="col-md-6">
			<label class="checkbox-inline" title="<?php echo $manager->aide($aideDomicile, 1); ?>">
				<input type="checkbox" name="tourPrcd" id="1" value="true"
					<?php echo ($manager->selectionner($critereDomicile, 1)) ? 'checked' : '' ; ?> > Reçu tour précédent
			</label>
		</div>

		<div class="col-md-6">
			<label class="checkbox-inline" title="<?php echo $manager->aide($aideDomicile, 2); ?>">
				<input type="checkbox" name="clubRecpetion" id="2"
					<?php echo ($manager->selectionner($critereDomicile, 2)) ? 'checked' : '' ; ?> > Club en réception
			</label>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6 exempteTourPrcd">
			<label class="checkbox-inline" title="<?php echo $manager->aide($aideDomicile, 3); ?>">
				<input type="checkbox" name="exempteTourPrcd" id="3"
				<?php echo ($manager->selectionner($critereDomicile, 3)) ? 'checked' : '' ; ?> > Exempté tour précédent
			</label>
		</div>

		
		<label for="nbKm" class="col-md-3" title="<?php echo $manager->aide($aideDomicile, 17); ?>">Km parcouru :</label>
		<div class="col-md-3">
			<select name="nbKm" class="form-control nbKm" id="17">
				<option value="-1" <?php echo ($manager->selectionnerOption($critereDomicile, 17, -1)) ? 'selected' : '' ; ?> >
				</option>
				<option value="200" <?php echo ($manager->selectionnerOption($critereDomicile, 17, 200)) ? 'selected' : '' ; ?> >
					200
				</option>
				<option value="500" <?php echo ($manager->selectionnerOption($critereDomicile, 17, 500)) ? 'selected' : '' ; ?>>
					500
				</option>
				<option value="700" <?php echo ($manager->selectionnerOption($critereDomicile, 17, 700)) ? 'selected' : '' ; ?>>
					700
				</option>
				<option value="1000" <?php echo ($manager->selectionnerOption($critereDomicile, 17, 1000)) ? 'selected' : '' ; ?>>
					1000
				</option>
				<option value="1400" <?php echo ($manager->selectionnerOption($critereDomicile, 17, 1400)) ? 'selected' : '' ; ?>>
					1400
				</option>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label for="clsCoupe" class="col-md-3" title="<?php echo $manager->aide($aideDomicile, 16); ?>">Cls coupe :</label>
		<div class="col-md-3">
			<select name="clsCoupe" class="form-control cls" id="16">
				<option value="-1" <?php echo ($manager->selectionnerOption($critereDomicile, 16, -1)) ? 'selected' : '' ; ?> >
				</option>
				<option value="300" <?php echo ($manager->selectionnerOption($critereDomicile, 16, 300)) ? 'selected' : '' ; ?> >
					300
				</option>
				<option value="500" <?php echo ($manager->selectionnerOption($critereDomicile, 16, 500)) ? 'selected' : '' ; ?>>
					500
				</option>
				<option value="600" <?php echo ($manager->selectionnerOption($critereDomicile, 16, 600)) ? 'selected' : '' ; ?>>
					600
				</option>
				<option value="700" <?php echo ($manager->selectionnerOption($critereDomicile, 16, 700)) ? 'selected' : '' ; ?>>
					700
				</option>
				<option value="800" <?php echo ($manager->selectionnerOption($critereDomicile, 16, 800)) ? 'selected' : '' ; ?>>
					800
				</option>
				<option value="900" <?php echo ($manager->selectionnerOption($critereDomicile, 16, 900)) ? 'selected' : '' ; ?>>
					900
				</option>
			</select>
		</div>

		
		<label for="clsCFVB" class="col-md-3" title="<?php echo $manager->aide($aideDomicile, 4); ?>">Cls CFVB :</label>
		<div class="col-md-3">
			<select name="clsCFVB" class="form-control cls" id="4">
				<option value="-1" <?php echo ($manager->selectionnerOption($critereDomicile, 4, -1)) ? 'selected' : '' ; ?> >
				</option>
				<option value="500" <?php echo ($manager->selectionnerOption($critereDomicile, 4, 500)) ? 'selected' : '' ; ?> >
					500
				</option>
				<option value="1000" <?php echo ($manager->selectionnerOption($critereDomicile, 4, 1000)) ? 'selected' : '' ; ?>>
					1000
				</option>
				<option value="1500" <?php echo ($manager->selectionnerOption($critereDomicile, 4, 1500)) ? 'selected' : '' ; ?>>
					1500
				</option>
				<option value="2000" <?php echo ($manager->selectionnerOption($critereDomicile, 4, 2000)) ? 'selected' : '' ; ?>>
					2000
				</option>
				<option value="2500" <?php echo ($manager->selectionnerOption($critereDomicile, 4, 2500)) ? 'selected' : '' ; ?>>
					2500
				</option>
				<option value="3000" <?php echo ($manager->selectionnerOption($critereDomicile, 4, 3000)) ? 'selected' : '' ; ?>>
					3000
				</option>
				<option value="4000" <?php echo ($manager->selectionnerOption($critereDomicile, 4, 4000)) ? 'selected' : '' ; ?>>
					4000
				</option>
			</select>
		</div>
	</div>

	<label for="equipeEngage" class="col-md-4" title="<?php echo $manager->aide($aideDomicile, 5); ?>">Equipes engagés :</label>
		<div class="col-md-2">
			<select name="equipeEngage" class="form-control equipeEngage" id="5">
				<option value="-1" <?php echo ($manager->selectionnerOption($critereDomicile, 5, -1)) ? 'selected' : '' ; ?> >
				</option>
				<option value="1" <?php echo ($manager->selectionnerOption($critereDomicile, 5, 1)) ? 'selected' : '' ; ?>>
					1
				</option>
				<option value="2" <?php echo ($manager->selectionnerOption($critereDomicile, 5, 2)) ? 'selected' : '' ; ?>>
					2
				</option>
				<option value="3" <?php echo ($manager->selectionnerOption($critereDomicile, 5, 3)) ? 'selected' : '' ; ?>>
					3
				</option>
				<option value="4" <?php echo ($manager->selectionnerOption($critereDomicile, 5, 4)) ? 'selected' : '' ; ?>>
					4
				</option>
				<option value="5" <?php echo ($manager->selectionnerOption($critereDomicile, 5, 5)) ? 'selected' : '' ; ?>>
					5
				</option>
				<option value="6" <?php echo ($manager->selectionnerOption($critereDomicile, 5, 6)) ? 'selected' : '' ; ?>>
					6
				</option>
				<option value="7" <?php echo ($manager->selectionnerOption($critereDomicile, 5, 7)) ? 'selected' : '' ; ?>>
					7
				</option>
				<option value="8" <?php echo ($manager->selectionnerOption($critereDomicile, 5, 8)) ? 'selected' : '' ; ?>>
					8
				</option>
			</select>
		</div>

	<div class="form-group">
		<label for="nombreReception" class="col-md-4" title="<?php echo $manager->aide($aideDomicile, 6); ?>">Nombre réception :</label>
		<div class="col-md-2">
			<select name="nombreReception" class="form-control nombreReception" id="6">
				<option value="-1" <?php echo ($manager->selectionnerOption($critereDomicile, 6, -1)) ? 'selected' : '' ; ?> >
				</option>
				<option value="1" <?php echo ($manager->selectionnerOption($critereDomicile, 6, 1)) ? 'selected' : '' ; ?>>
					1
				</option>
				<option value="2" <?php echo ($manager->selectionnerOption($critereDomicile, 6, 2)) ? 'selected' : '' ; ?>>
					2
				</option>
				<option value="3" <?php echo ($manager->selectionnerOption($critereDomicile, 6, 3)) ? 'selected' : '' ; ?>>
					3
				</option>
			</select>
		</div>
		
	</div>
</form>
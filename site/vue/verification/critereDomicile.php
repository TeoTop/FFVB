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
* Nom : critereDomicile.php
* Chemin abs : site\vue\verification
* Information : page permettant d'afficher les critères pour sélectionner l'équipe qui va jouer à domicile
*
*
*/

	$manager = new CritereManager();

?>

<form class="form-horizontal" role="form" id="domicileForm">
	<div class="form-group">
		<div class="col-md-6">
			<label class="checkbox-inline">
				<input type="checkbox" name="tourPrcd" id="1" value="true"
					<?php echo ($manager->selectionner($critereDomicile, 1)) ? 'checked' : '' ; ?> > Reçu tour précédent
			</label>
		</div>

		<div class="col-md-6">
			<label class="checkbox-inline">
				<input type="checkbox" name="clubRecpetion" id="2"
					<?php echo ($manager->selectionner($critereDomicile, 2)) ? 'checked' : '' ; ?> > Club en réception
			</label>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6 exempteTourPrcd">
			<label class="checkbox-inline">
				<input type="checkbox" name="exempteTourPrcd" id="3"
				<?php echo ($manager->selectionner($critereDomicile, 3)) ? 'checked' : '' ; ?> > Exempté tour prcd
			</label>
		</div>

		
			<label for="petiteEquipe" class="col-md-3">Petite equipe :</label>
		<div class="col-md-3">
			<select name="petiteEquipe" class="form-control petiteEquipe" id="4">
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
			</select>
		</div>
	</div>

	<label for="equipeEngage" class="col-md-4">Equipes engagés :</label>
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
		<label for="nombreReception" class="col-md-4">Nombre réception :</label>
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
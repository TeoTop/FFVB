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
* Nom : criteres.php
* Chemin abs : site\vue\
* Information : page permettant de gérer l'affichage des critères
*
*
*/


?>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
	
    <li <?php echo ($_SESSION['critere']=='domicile') ? 'class="active"':''; ?> onclick="changerCriteres('domicile')">
        <a href="#domicile" role="tab" data-toggle="tab">Domicile</a>
    </li>

	<li <?php echo ($_SESSION['critere']=='exterieur') ? 'class="active"':''; ?> onclick="changerCriteres('exterieur')">
        <a href="#exterieur" role="tab" data-toggle="tab">Exterieur</a>
    </li>

	<li <?php echo ($_SESSION['critere']=='exempter') ? 'class="active"':''; ?> onclick="changerCriteres('exempter')">
        <a href="#exempter" role="tab" data-toggle="tab">Exempter</a>
    </li>

</ul>

<!-- Tab panes -->
<div class="tab-content">

	<div class="tab-pane fade <?php echo ($_SESSION['critere']=='domicile') ? 'in active':''; ?>" id="domicile">
		<?php
    		include V . 'critereDomicile.php';
        ?>
	</div>

	<div class="tab-pane fade <?php echo ($_SESSION['critere']=='exterieur') ? 'in active':''; ?>" id="exterieur">
		<?php
    		include V . 'critereExterieur.php';
        ?>
	</div>

	<div class="tab-pane fade <?php echo ($_SESSION['critere']=='exempter') ? 'in active':''; ?>" id="exempter">
		<?php
    		include V . 'critereExempter.php';
        ?>
	</div>

</div>
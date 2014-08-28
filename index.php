<?php

/**
*
* Créer par : CHAPON Théo
*
**/

/**
*
* Information sur la page :
* Nom : index.php
* Chemin abs : 
* Information : page permettant la génération du code correspondant à l'adresse demandé dans le navigateur
**/

//pour le développement
//ini_set('display_errors', 'on');

// définition des constantes permettant de naviguer vers un dossier
// (utile la création de chemin d'accées vers un fichier)
define('C', 'site/controleur/');	
define('V', 'site/vue/');
define('M', 'site/model/');

// zone horaire : PARIS
date_default_timezone_set('Europe/Paris') or die();
error_reporting(-1);

?>

<!DOCTYPE HTML>
<html lang="fr">

  	<head>
  		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="Content-Language" content="fr">
	    <title>FFVB - Coupe de France Jeune</title>
	    
	    <!-- On charge les fichiers CSS et JS nécessaire -->
	    <link href="site/css/main.css" rel="stylesheet">
	    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
	    <link rel="stylesheet" href="site/css/theme.bootstrap.css">

	    <?php
	    	//on écrit le fichier css correspondant à la page chargée
			if (isset($_GET['m']) && !empty($_GET['m']) && !is_array($_GET['m']) && preg_match('/^[a-zA-Z0-9-_]+$/', $_GET['m'])){
				require C . "css.php";
			} else {
				echo '<link href="site/css/accueil.css" rel="stylesheet">';
			 }
		?>

	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->	    

	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	    <script type="text/javascript" src="site/js/jquery.quicksearch.js"></script>
    </head>

	<body>	

		<?php
	    	//page contenant les fonctions associées à la base de données
		 	include 'site/bdd.php';
		 	
		 	function chargerClasse($classe)
			{
			  require M . $classe . '.class.php'; // On inclut la classe correspondante au paramètre passé.
			}

			// On enregistre la fonction en autoload pour qu'elle soit appelée dès qu'on instanciera une classe non déclarée.
			spl_autoload_register('chargerClasse'); 

			//ouverture d'un session ATTENTION : le session start DOIT être placé APRES le chargement des classes
			session_start();
	    ?>	

		<div class="container"> <!--div principale-->
			<?php	
				require "site/menu.php"; // affihce le menu
			?>
			<div class="content" id="content">
				
				<?php	
					// is_valid($_GET) or die('get');
					// m est le "module" a chargé = correpond à la page
					if (isset($_GET['m']) && !empty($_GET['m']) && !is_array($_GET['m']) && preg_match('/^[a-zA-Z0-9-_]+$/', $_GET['m'])) {
						$file = C . $_GET['m'] . ".php";
						is_file($file) or die();
						include $file;
					} else {
						require V . "accueil.php";  // on charge la page d'accueil par default
					}
				?>

			</div>
			
			<?php
				require "site/bas_de_page.php";
			?>

	    </div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	    <script type="text/javascript" src="site/js/jquery.tablesorter.min.js"></script>
	    <script type="text/javascript" src="site/js/jquery.tablesorter.widgets.min.js"></script>

	    <div id="script">
		    <?php
		    	// on écrit le fichier JS qui correspond à la page chargée
				if (isset($_GET['m']) && !empty($_GET['m']) && !is_array($_GET['m']) && preg_match('/^[a-zA-Z0-9-_]+$/', $_GET['m'])){
					require C . "js.php";
				} else {
					echo '<script type="text/javascript" src="site/js/accueil.js"></script>';
				 }
			?>
		</div>

	</body>
</html>


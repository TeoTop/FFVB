<?php

/**
*
* Créer par : CHAPON Théo
*
**/

/**
*
* Information sur la page :
* Nom : bdd.php
* Chemin abs : site\
* Information : fonctions permettant d'ouvrir un accées à la BDD
* et à refermer la session.
*
**/

//on ouvre une connexion à la base
function ouvre_base() {
	
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	try{
		// à modifier selon la base utilisée
		$bdd = new PDO('mysql:host=localhost;dbname=ffvb_gpa', 'root', '', $pdo_options);
	}
	catch(PDOException $e)
	{
		echo ($e->getMessage());
	 }
	
	$bdd->query('SET NAMES utf8');
	return $bdd;
}

//si on a besoin de redéfinir un tableau avec 0 comme index de départ
function reArrayFiles(&$file_post) {

	$file_ary = array();
	$file_count = count($file_post['name']);
	$file_keys = array_keys($file_post);

	for ($i=0; $i<$file_count; $i++) {
		foreach ($file_keys as $key) {
			$file_ary[$i][$key] = $file_post[$key][$i];
		}
	}

	return $file_ary;
}

?>
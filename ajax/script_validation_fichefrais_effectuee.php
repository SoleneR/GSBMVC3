<?php
	// Connexion à la base de données
	include("../include/fct.inc.php");
	include("../include/class.pdogsb.inc.php");
	$pdo = PdoGsb::getPdoGsb();
	extract($_POST);

    // lancement de la fonction permettant de changer les valeurs des montants des frais forfaitisés dans la base de données
 	$validerFiche = $pdo->changeEtatFicheFraisToValidate($id,$mois,$montantTotal);
?>
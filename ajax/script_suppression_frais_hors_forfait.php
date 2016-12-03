<?php
	// Connexion à la base de données
	include("../include/fct.inc.php");
	include("../include/class.pdogsb.inc.php");
	$pdo = PdoGsb::getPdoGsb();
	extract($_POST);

    // lancement de la fonction permettant de mettre la fiche de frais en validée
 	$validerSuppressionFraisHorsForfait = $pdo->updateSuppressionLigneFraisHorsForfait($idLigneFraisHF, $motif);
?>
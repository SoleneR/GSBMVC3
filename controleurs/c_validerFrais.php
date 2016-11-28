<?php $id = $_SESSION['idVisiteur'];
include("vues/v_sommaire.php");

$action = $_REQUEST['action'];
switch($action){
	case 'afficherFormulaireValidationFicheFrais':{
                $visiteursAvecFicheCloturee = $pdo->getTousVisiteursAvecFicheCloturee();           
		include("vues/v_validerFrais.php");
		break;
	}
}
?>
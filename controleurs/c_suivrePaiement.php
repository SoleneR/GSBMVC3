<?php
include("vues/v_sommaire.php");

$idVisiteur = $_SESSION['idVisiteur'];

$action = $_REQUEST['action'];
switch($action){
	case 'suivrePaiement':{
          $lesVisiteurs=$pdo->getLesVisiteursASuivre();
          
          include("vues/v_listeVisiteur.php");
          break;  
        }
        case 'voirFicheFrais': {
            $lesVisiteurs=$pdo->getLesVisiteursASuivre();
            $leVisiteur = $_REQUEST['idVisiteur'];  
            $listeFicheVisiteur=$pdo->getFichesFraisUtilisateurSuiviePaiement($leVisiteur);
            
            include("vues/v_listeVisiteur.php");
            include("vues/v_listeFicheVisiteur.php"); 
            break;
        }
        case'detailFicheVisiteur':{
            $lesVisiteurs=$pdo->getLesVisiteursASuivre();
            $leVisiteur = $_REQUEST['idVisiteur']; 
            $leMois = $_REQUEST['mois'];
                $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteur,$leMois);
		$lesFraisForfait= $pdo->getLesFraisForfait($leVisiteur,$leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur,$leMois);
                $libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
            include("vues/v_listeVisiteur.php");
            include("vues/v_detailFicheVisiteur.php");
            break;
        }




}




?>
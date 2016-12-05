<?php
include("vues/v_sommaire.php");
$action = $_REQUEST['action'];
switch($action)
{
	case 'selectionnerFicheFrais':
	{
		$laDate = $_REQUEST['date'];
		$leId = $_REQUEST['id'];
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($leId,$laDate);
		$lesFraisForfait= $pdo->getLesFraisForfait($leId,$laDate);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leId,$laDate);
		$nomVisiteur = $lesInfosFicheFrais['nom'];
		$prenomVisiteur = $lesInfosFicheFrais['prenom'];
		$numAnnee =substr( $laDate,0,4);
		$numMois =substr( $laDate,4,2);
		$libEtat = $lesInfosFicheFrais['libEtat'];		
		$montantValide = $lesInfosFicheFrais['montantValide'];
		if($montantValide = '0.00')
		{
			//$montantValide = $pdo->getLeMontantValide($leId,$laDate,);
			$montantValide = 'non calculé';
		}
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("vues/v_etatFrais.php");
		break;
	}
	
	case 'voirListeFichesFrais':
	{
		$lesInfos=$pdo->getLesFichesCloturees();
		include("vues/v_listeFichesCloturees.php");
		break;
	}	

	case 'modifierFraisForfaitises':
	{
			if($_POST['ETP'])
			{
				$pdo->majLigneFraisForfait($_POST['ETP'] , $_POST['idVisiteur'] , $_POST['date'] , 'ETP');
			}	
			if($_POST['KM'])
			{
				$pdo->majLigneFraisForfait($_POST['KM'] , $_POST['idVisiteur'] , $_POST['date'] , 'KM');
			}	
			if($_POST['NUI'])
			{
				$pdo->majLigneFraisForfait($_POST['NUI'] , $_POST['idVisiteur'] , $_POST['date'] , 'NUI');
			}	
			if($_POST['REP'])
			{
				$pdo->majLigneFraisForfait($_POST['REP'] , $_POST['idVisiteur'] , $_POST['date'] , 'REP');
			}
			echo "<h2>Opérations effectuées avec succès</h2>";		
			break;		
	}

	case 'supprimerFrais': 
	{
		if($_POST['motif'] && $_POST['id'])
		{
        	$pdo->supprimerFraisHorsForfaitComptable($_POST['id'], $_POST['motif']);
        	echo "<h2>Opérations effectuées avec succès</h2>";
        }
        else
        {
        	echo "<h3 class='text-danger'>Erreur : veuillez entrer un motif de suppression</h3>";
        }
		break;
	}

	case 'validerFicheFrais':
	{
		if($_REQUEST['id'] && $_REQUEST['date']) 
		{
			$pdo->validerFicheFrais($_GET['id'], $_GET['date']);
			echo "<h2>Opérations effectuées avec succès</h2>";
		}
	}
}
?>

<?php
	// Connexion à la base de données
	include("../include/fct.inc.php");
	include("../include/class.pdogsb.inc.php");
	$pdo = PdoGsb::getPdoGsb();
	extract($_POST);

	$moisAnnee = $mois;
	$annee = substr($mois, 0, 4);
    $mois = substr($mois, 4, 6);
    $tabMois = array('', 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'aôut', 'septembre', 'octobre', 'novembre', 'décembre');
    
    if(substr($mois, 0, 1) == '0')
    {
        $mois = substr($mois, 1, 2);
    }

    $montantTotalFraisForfait = 0;
    $montantTotalFraisHorsForfait = 0;

    // Execution de la fonction permettant de recevoir les détails de la fiche de frais à valider
    $detailsForfait = $pdo->getTousInfosMontantFicheFraisForfait($idVisiteur, $moisAnnee);
    $detailsHorsForfait = $pdo->getTousInfosMontantFicheFraisHorsForfait($idVisiteur, $moisAnnee);

    $content = "<input name='idVisiteurFicheAValider' style='display: none' value='".$idVisiteur."'/>";
    $content .= "<input name='moisAnneeVisiteurFicheAValider' style='display: none' value='".$moisAnnee."'/>";
    $content .= "<div id='motifSuppressionLigneHorsForfait'></div>";

	$content .= "<h3 style='color: rgba(0,0,0,.7); font-family: Impact;'>Les détails de la fiche frais à valider : </h3><br/>";
	//$content .= $details;
	$content .= "<p>Identité du visiteur : ".$nom." ".$prenom."</p>";
	$content .= "<p>Date de la fiche de frais : ".ucfirst($tabMois[$mois])." ".$annee."</p><br/>";

	$content .= "<a href='#' name='modifierMontantFraisForfait'><span class='modifierFicheFrais'> > Modifier les montants des frais forfaitisés</span></a>";
	$content .= "<a href='#' name='annulerModifierMontantFraisForfait' style='display: none;'><span class='modifierFicheFrais'> < Annuler la modification des frais forfaitisés</span></a>";
	$content .= "<p>Tableau des frais forfaitisés :</p>";
	$content .= "<table class='table table-bordered' style='font-size: 1em;'><thead><th>Etape</th><th>Montant</th><th>Quantite</th><th>Montant Total</th></thead>";

	foreach ($detailsForfait as $unDetail)
	{	
		$montantTotalFraisForfait += $unDetail['montantCalculeParQuantite'];
		$content .= "<tbody class='ligneFicheFraisForfaisCloturee'>";
		$content .= "<td>".$unDetail['libelle']."</td>";
		$content .= "<td name='fraisForfaitAffichable'>".$unDetail['montant']."</td>";
		$content .= "<td name='fraisForfaitModifiable' style='display: none;'><input type='text' class='modifMontantInput' id='montant".$unDetail['id']."' value='".$unDetail['montant']."'/></td>";
		$content .= "<td>".$unDetail['quantite']."</td>";
		$content .= "<td>".$unDetail['montantCalculeParQuantite']."</td>";
		$content .= "</tbody>";
	}

	$content .= "<td></td><td><a name='btn_validation_modification_frais_forfait' style='display: none;' href='#'><input class='btn-validation-modification' type='submit' value='Valider'/></a></td><td></td><td style='background-color: rgba(0,0,0,.3);'>".$montantTotalFraisForfait."</td>";
	$content .= "</table>";

	$content .= "<br/>";
	$content .= "<a href='#' name='supprimerLigneFraisHorsForfait'><span class='modifierFicheFrais'> > Supprimer une ligne de frais hors forfait</span></a>";
	$content .= "<a href='#' name='annulerSupprimerLigneFraisHorsForfait' style='display: none;'><span class='modifierFicheFrais'> < Annuler la suppression de frais hors forfait</span></a>";
	$content .= "<p>Tableau des frais hors forfaitisés :</p>";
	$content .= "<table class='table table-bordered' style='font-size: 1em;'><thead><th>Date</th><th>Libelle</th><th>Montant</th><th name='btnSupprimerLigneFraisHorsF' style='display: none'>Supprimer une ligne</th></thead>";

	foreach ($detailsHorsForfait as $unDetail)
	{	
		$date = explode("-",$unDetail['date']);
		if(substr($date[1], 0, 1) == '0')
    	{
        	$date[1] = substr($date[1], 1, 2);
    	}

		$montantTotalFraisHorsForfait += $unDetail['montant'];
		$content .= "<tbody class='ligneFicheFraisForfaisCloturee'>";
		$content .= "<td id='date".$unDetail['id']."'>".$date[2]." ".ucfirst($tabMois[$date[1]])." ".$date[0]."</td>";
		$content .= "<td id='libelle".$unDetail['id']."'>".$unDetail['libelle']."</td>";
		$content .= "<td id='montant".$unDetail['id']."'>".$unDetail['montant']."</td>";
		$content .= "<td name='btnSupprimerLigneFraisHorsF' style='display: none'><a id='lhf".$unDetail['id']."' name='btn_suppression_frais_hors_forfait' href='#'><input class='btn-suppression' type='submit' value='Supprimer'/></a></td>";
		$content .= "</tbody>";
	}

	$content .= "<td></td><td></td><td style='background-color: rgba(0,0,0,.3);'>".$montantTotalFraisHorsForfait."</td>";
	$content .= "</table>";

	$content .= "<br/>";
	$montantTotalValide = $montantTotalFraisForfait + $montantTotalFraisHorsForfait;
	$content .= "Le montant validé total est de : ".$montantTotalValide." €";

	$content .= "<a name='btn_validation_fiche_frais' href='#'><input class='btn-validation' type='submit' value='Valider'/></a>";
	$content .= "<a name='btn_annulation_fiche_frais' href='#'><input class='btn-annulation' type='submit' value='Annuler'/></a>";
	$content .= "<input name='montantTotalVisiteurFicheAValider' style='display: none' value='".$montantTotalValide."'/>";

	echo $content;
?>
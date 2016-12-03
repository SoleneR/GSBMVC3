$(document).ready(function() 
{
    $("#divCacheValidation").hide();

    $("a[name=modifEtatLigneFicheFrais]").click(function(e) 
	{
        e.stopPropagation();
        e.preventDefault();
		
        document.getElementById('divCacheValidation').innerHTML = "";
        var id = $(this).attr('id');
        var numligne = id.substr(6);
        var nom = $("#ficheDuVisiteurNom" + numligne).html();
        var prenom = $("#ficheDuVisiteurPrenom" + numligne).html();
        var moisAnnee = $("#ficheDuVisiteurMoisAnnee" + id).html();
     
        $.post("./ajax/script_validation_fichefrais.php",
            {          
                "idVisiteur" :numligne,
                "nom" :nom,
                "prenom" :prenom,
                "mois" :moisAnnee
            },
        retourDetailsValidation
            );
    });
    
    
	
    function retourDetailsValidation(data)
	{
        $("#divCacheValidation").fadeIn();
        var div = document.createElement('div');
        div.innerHTML = data;
        document.getElementById('divCacheValidation').appendChild(div);

        $("a[name=modifierMontantFraisForfait]").click(function(e) 
        {
            e.stopPropagation();
            e.preventDefault();

            $("td[name=fraisForfaitAffichable]").hide();
            $("td[name=fraisForfaitModifiable]").show();
            $("a[name=btn_validation_modification_frais_forfait]").show();
            $("a[name=modifierMontantFraisForfait]").hide();
            $("a[name=annulerModifierMontantFraisForfait]").show();

            $("a[name=btn_validation_modification_frais_forfait]").click(function(e) 
            {
                e.stopPropagation();
                e.preventDefault();

                var montantETP = $("#montantETP").val();
                var montantKM = $("#montantKM").val();
                var montantNUI = $("#montantNUI").val();
                var montantREP = $("#montantREP").val();

                $.post("./ajax/script_modification_frais_forfait.php",
                {          
                    "montantETP" :montantETP,
                    "montantKM" :montantKM,
                    "montantNUI" :montantNUI,
                    "montantREP" :montantREP
                },
                    retourValidationModificationFraisForfait
                );
            });

            function retourValidationModificationFraisForfait(data)
            {
                document.getElementById('ficheFraisValidee').innerHTML = "Les modifications ont été pris en compte.";
                $("#ficheFraisValidee").fadeIn().delay('2000').fadeOut();
                $('#divCacheValidation').hide();

                var numligne = $("input[name=idVisiteurFicheAValider]").val();
                var nom = $("#ficheDuVisiteurNom" + numligne).html();
                var prenom = $("#ficheDuVisiteurPrenom" + numligne).html();
                var moisAnnee = $("input[name=moisAnneeVisiteurFicheAValider]").val();
                
                document.getElementById('divCacheValidation').innerHTML = "";

                $.post("./ajax/script_validation_fichefrais.php",
                {          
                    "idVisiteur" :numligne,
                    "nom" :nom,
                    "prenom" :prenom,
                    "mois" :moisAnnee
                },
                    retourDetailsValidation
                );                 
            }

            $("a[name=annulerModifierMontantFraisForfait]").click(function(e) 
            {
                e.stopPropagation();
                e.preventDefault();

                $("td[name=fraisForfaitModifiable]").hide();
                $("a[name=btn_validation_modification_frais_forfait]").hide();
                $("td[name=fraisForfaitAffichable]").show();
                $("a[name=annulerModifierMontantFraisForfait]").hide();
                $("a[name=modifierMontantFraisForfait]").show();
            });
        });

        $("a[name=supprimerLigneFraisHorsForfait]").click(function(e) 
        {
            e.stopPropagation();
            e.preventDefault();

            $("a[name=supprimerLigneFraisHorsForfait]").hide();
            $("a[name=annulerSupprimerLigneFraisHorsForfait]").show();
            $("th[name=btnSupprimerLigneFraisHorsF]").show();
            $("td[name=btnSupprimerLigneFraisHorsF]").show();

            $("a[name=annulerSupprimerLigneFraisHorsForfait]").click(function(e) 
            {
                e.stopPropagation();
                e.preventDefault();

                $("a[name=annulerSupprimerLigneFraisHorsForfait]").hide();
                $("a[name=supprimerLigneFraisHorsForfait]").show();
                $("th[name=btnSupprimerLigneFraisHorsF]").hide();
                $("td[name=btnSupprimerLigneFraisHorsF]").hide();
            });

            $("a[name=btn_suppression_frais_hors_forfait]").click(function(e) 
            {
                e.stopPropagation();
                e.preventDefault();

                var idLigneFraisHF = $(this).attr('id').substr(3);
                var dateLigneFraisHF = $("#date" + idLigneFraisHF).html();
                var libelleLigneFraisHF = $("#libelle" + idLigneFraisHF).html();
                var montantLigneFraisHF = $("#montant" + idLigneFraisHF).html();
                //alert(idLigneFraisHF + ' ' + dateLigneFraisHF + ' ' + libelleLigneFraisHF + ' ' + montantLigneFraisHF);

                document.getElementById('motifSuppressionLigneHorsForfait').innerHTML = "<h5 style='font-family: Impact'>Détails de la ligne de frais hors forfait à supprimer :</h5><br/><p>Date : " + dateLigneFraisHF +"</p><p>Libelle : " + libelleLigneFraisHF +"</p><p>Montant : " + montantLigneFraisHF +" €</p><i>Insérez le motif de la suppression :</i><br/><textarea id='motifSuppr' rows='3' cols='50'></textarea><br/><div name='motifInconnu' style='display: none; color: rgba(200,50,50,.7);'><br/>Veuillez entrez un motif avant de valider</div><br/><a name='btn_validation_motif_suppression_frais_hf' href='#'><input class='btn-validation' type='submit' value='Valider'/></a><a name='btn_annulation_motif_suppression_frais_hf' href='#'><input class='btn-annulation' type='submit' value='Annuler'/></a>";

                $("#motifSuppressionLigneHorsForfait").fadeIn();

                $("a[name=btn_validation_motif_suppression_frais_hf]").click(function(e) 
                {
                    var motif = $("#motifSuppr").val();
                    $("div[name=motifInconnu]").hide();

                    if(motif == "")
                    {
                        $("div[name=motifInconnu]").show();
                    }

                    else
                    {
                        //alert(motif + ' ' + idLigneFraisHF);
                        $.post("./ajax/script_suppression_frais_hors_forfait.php",
                        {          
                            "motif" :motif,
                            "idLigneFraisHF" :idLigneFraisHF
                        },
                            retourValidationSuppressionLigneFraisHF
                        ); 
                    }   
                });

                $("a[name=btn_annulation_motif_suppression_frais_hf]").click(function(e) 
                {
                    $("#motifSuppressionLigneHorsForfait").fadeOut();
                });

                function retourValidationSuppressionLigneFraisHF(data)
                {
                    document.getElementById('ficheFraisValidee').innerHTML = "La ligne frais hors forfait a bien été supprimée.";
                    $("#ficheFraisValidee").fadeIn().delay('2000').fadeOut();
                    $("#motifSuppressionLigneHorsForfait").delay('2000').fadeOut();

                    var numligne = $("input[name=idVisiteurFicheAValider]").val();
                    var nom = $("#ficheDuVisiteurNom" + numligne).html();
                    var prenom = $("#ficheDuVisiteurPrenom" + numligne).html();
                    var moisAnnee = $("input[name=moisAnneeVisiteurFicheAValider]").val();

                    document.getElementById('divCacheValidation').innerHTML = "";

                    $.post("./ajax/script_validation_fichefrais.php",
                    {          
                        "idVisiteur" :numligne,
                        "nom" :nom,
                        "prenom" :prenom,
                        "mois" :moisAnnee
                    },
                        retourDetailsValidation
                    );
                }
            });
        });


        $("a[name=btn_annulation_fiche_frais]").click(function(e) 
        {
            e.stopPropagation();
            e.preventDefault();

            retourAnnulation();
        });

        $("a[name=btn_validation_fiche_frais]").click(function(e) 
        {
            e.stopPropagation();
            e.preventDefault();

            var id = $("input[name=idVisiteurFicheAValider]").val();
            var mois = $("input[name=moisAnneeVisiteurFicheAValider").val();
            var montantTotal = $("input[name=montantTotalVisiteurFicheAValider").val();

            $.post("./ajax/script_validation_fichefrais_effectuee.php",
            {          
                "id" :id,
                "mois" :mois,
                "montantTotal" :montantTotal
            },
                retourValidationEffectuee
            );

        });

        function retourValidationEffectuee(data)
        {
            if(data == "succes")
            {
                retourAnnulation();
            }

            else 
            {
                $("#divCacheValidation").fadeOut();
                document.getElementById('ficheFraisValidee').innerHTML = "La fiche de frais a bien été validée.";
                $("#ficheFraisValidee").fadeIn().delay('2000').fadeOut();
                setTimeout("window.location='index.php?uc=validerFrais&action=afficherFormulaireValidationFicheFrais'", 3000);
            }
        }

        function retourAnnulation()
        {
            $("#divCacheValidation").fadeOut();
            document.getElementById('ficheFraisNonValidee').innerHTML = "La fiche de frais n'a pas été validée.";
            $("#ficheFraisNonValidee").fadeIn().delay('2000').fadeOut();
        }
    }
});
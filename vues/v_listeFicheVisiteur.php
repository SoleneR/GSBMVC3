<h2>Liste fiche visiteur</h2>
<form class="form-inline" action="index.php?uc=suivrePaiement&action=detailFicheVisiteur" method="post">   
    <div class="corpsForm">  
        <fieldset>	 
            <legend>Fiche à sélectionner: </legend>
            <div class="form-group">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th> mois</th>   
                            <th >montantValide</th>  
                            <th>date Modif</th>  
                            <th>Etat</th> 
                            <th>Voir les détails</th>
                        </tr>
                    </thead>
                    <tbody>  
                        <?php
                        
                         
                       foreach ($listeFicheVisiteur as $uneFicheVisiteur) 
                            {
                            ?>
                            <tr>


    <?php
    
    $idVisiteur = $uneFicheVisiteur['idVisiteur'];
    $mois = $uneFicheVisiteur['mois']; 
    $montantValide = $uneFicheVisiteur['montantValide'];
    $dateModif = $uneFicheVisiteur['dateModif'];
    $etat = $uneFicheVisiteur['idEtat'];
    ?>

                                <td><?php echo $mois ?></td>    
                                <td><?php echo $montantValide ?></td>
                                <td><?php echo $dateModif ?></td>
                                <td><?php echo $etat ?></td>
                        <input type="hidden" name="idVisiteur" value="<?php echo $idVisiteur ?>">
                         <td> <button type="submit" class="btn btn-primary" name="mois" value="<?php echo $uneFicheVisiteur['mois'] ?>">Voir les détails</button>  </td>
                                                                                               


                        </tr>
    <?php
  
}
?>

                    </tbody>
                </table>

            </div>
        </fieldset>	 
    </div>       
</form>
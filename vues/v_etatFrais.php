<?php 
//version comptable
if($_SESSION['type']=='Comptable')
{
  echo '<h2>Fiche de frais du mois ' . $numMois."-". $numAnnee . " de " . $prenomVisiteur . " " . $nomVisiteur . '     ' ;
  echo "<a href='index.php?uc=validerFicheFrais&action=validerFicheFrais&id=$leId&date=$laDate' class='btn btn-primary btn-sm' role='button'>Valider la fiche</a>" .'</h2>';
  ?>
  <p>
      <strong>Etat : </strong>   
        <?php echo $libEtat?> depuis le <?php echo $dateModif?> <br> 
      <strong> Montant des frais :</strong> 
      <span class="label label-info">  
        <?php echo $montantValide?> 
      </span>         
  </p>
  <form class="form-vertical" method="POST" action="index.php?uc=validerFicheFrais&action=modifierFraisForfaitises">
    <table class="table table-bordered">
      <caption>Eléments forfaitisés </caption>
        <thead>
          <tr>
            <?php
            foreach($lesFraisForfait as $unFraisForfait) 
            {
              $libelle = $unFraisForfait['libelle'];
            ?>	
              <th> <?php echo $libelle?></th>
              <?php
            }
              ?>
          </tr>
        </thead>
        <tbody>
          <tr>
            <?php
            foreach($lesFraisForfait as $unFraisForfait) 
            {
              $idFrais = $unFraisForfait['idfrais'];
            	$quantite = $unFraisForfait['quantite'];
              $date = $unFraisForfait['date'];
            ?>
              <td class="qteForfait"> <input class="form-control"  name="<?php echo $idFrais; ?>" type="number" value='' placeholder="<?php echo $quantite; ?>"> </td>
             <?php
            }
            ?>
          </tr>
        </tbody>
    </table>
     <input class="form-control"  name="idVisiteur" type="hidden" value="<?php echo $leId; ?>">
     <input class="form-control"  name="date" type="hidden" value="<?php echo $date; ?>">     
      <div class="piedForm">
        <p> 
          <button type="submit" class="btn btn-primary">Modifier</button>
          <button type="reset" class="btn btn-primary">Annuler</button>
        </p> 
      </div>
  </form>
  
  <?php 
  if (!empty($lesFraisHorsForfait)) 
  { 
  ?>
    <table class="table table-bordered">
      <caption>Descriptif des éléments hors forfait (<?php echo $nbJustificatifs ?> justificatifs reçus )
      </caption>
      <thead>
         <tr>           
            <th class="date">Date</th>
            <th class="libelle">Libellé</th>
            <th class='montant'>Montant</th>              
            <th class='motif'>Motif de suppression</th>
            <th class='action'>Action</th>   
               
         </tr>
      </thead>
      <tbody>
        <?php      
        foreach($lesFraisHorsForfait as $unFraisHorsForfait) 
        {
          $id = $unFraisHorsForfait['id'];
        	$date = $unFraisHorsForfait['date'];
        	$libelle = $unFraisHorsForfait['libelle'];
        	$montant = $unFraisHorsForfait['montant'];
        ?>
          <tr>
            <form class="form-vertical" method="POST" action="index.php?uc=validerFicheFrais&action=supprimerFrais">
              <td><?php echo $date; ?></td>
              <td><?php echo $libelle; ?></td>
              <td><?php echo $montant; ?></td>       
              <input class="form-control"  name="id" type="hidden" value="<?php echo $id; ?>">       
              <td> <input class="form-control"  name="motif" type="text" value='' placeholder="Saisissez le motif"></td>
              <td><?php echo '<button type="submit" class="btn btn-primary btn-md">Supprimer</button>' ?></td>
            </form>  
          </tr>        
        <?php 
        }
        ?>
      </tbody>
    </table>    
     <?php 
   }
  else 
  {
    echo "<strong>Il n'y a pas d'élément hors forfait pour ce mois.</strong>";
  }
  ?>
  </div>
<?php } 








// Version visiteur
else
{
  ?>
  <p>
      <strong>Etat : </strong>   
      <?php echo $libEtat?> depuis le <?php echo $dateModif?> <br> 
      <strong> Montant des frais :</strong> <span class="label label-info">  <?php echo $montantValide?> </span>            
  </p>
  <table class="table table-bordered">
    <caption>Eléments forfaitisés </caption>
      <thead>
        <tr>
          <?php
          foreach($lesFraisForfait as $unFraisForfait) 
          {
            $libelle = $unFraisForfait['libelle'];
          ?>  
            <th> <?php echo $libelle?></th>
            <?php
          }
            ?>
        </tr>
      </thead>
      <tbody>
        <tr>
          <?php
          foreach($lesFraisForfait as $unFraisForfait) 
          {
            $quantite = $unFraisForfait['quantite'];
          ?>
            <td class="qteForfait"><?php echo $quantite?> </td>
           <?php
          }
          ?>
        </tr>
      </tbody>
  </table><br>

  <?php 
  if (!empty($lesFraisHorsForfait)) 
  { 
  ?>
    <table class="table table-bordered">
      <caption>Descriptif des éléments hors forfait (<?php echo $nbJustificatifs ?> justificatifs reçus )
      </caption>
      <thead>
         <tr>
            <th class="date">Date</th>
            <th class="libelle">Libellé</th>
            <th class='montant'>Montant</th>                
         </tr>
      </thead>
      <tbody>
        <?php      
        foreach($lesFraisHorsForfait as $unFraisHorsForfait) 
        {
          $date = $unFraisHorsForfait['date'];
          $libelle = $unFraisHorsForfait['libelle'];
          $montant = $unFraisHorsForfait['montant'];
        ?>
          <tr>
            <td><?php echo $date ?></td>
            <td><?php echo $libelle ?></td>
            <td><?php echo $montant ?></td>
          </tr>        
        <?php 
        }
        ?>
      </tbody>
    </table>
     <?php 
   }
  else 
  {
    echo "<strong>Vous n'avez pas d'élément hors forfait pour ce mois.</strong>";
  }
  ?>
  </div>
<?php } ?>














<?php 
 $visiteur ="";
if (isset($_POST["idVisiteur"]))
{
   
    $visiteur = $_POST["idVisiteur"];
   

}
 
?> 
<h2>Suivie paiement fiche frais</h2>
      <form class="form-inline" action="index.php?uc=suivrePaiement&action=voirFicheFrais" method="post">  
      <div class="corpsForm">  
      <fieldset>	 
        <legend>Visiteur à sélectionner: </legend>
        <div class="form-group">
        <label for="visiteur">Visiteur :</label> 
        <select id="idVisit" name="idVisiteur" class="form-control">
      
		<?php	
                
           foreach ($lesVisiteurs as $unVisiteur)
			{
			         
				
				if($unVisiteur['id'] == $visiteur ){
				?>
                               
				<option selected value="<?php echo $unVisiteur['id']; ?>"><?php echo  $unVisiteur['nom'] ?> </option>
				<?php 
				}
				else{ ?>
				<option value="<?php echo $unVisiteur['id'] ?>"><?php echo  $unVisiteur['nom'] ?> </option>
				<?php 
                               
				}
			
			}
           
	  ?>
            
        </select> 
        <button type="submit" class="btn btn-primary">Valider</button>        
       </div>
      </fieldset>	 
      </div>       
      </form>
      
<h2>Valider une fiche de frais</h2>
<form class="form-inline" action="indexemple .php?uc=validerFicheFrais&action=voirListeFichesFrais" method="post">   
	<div class="corpsForm">
		<fieldset>	 
		    <legend>Utilisateurs ayant des fiches de frais cloturées :</legend>				
				<?php
				if(!empty($lesInfos))
				{
					?>
			    <table align="center" class=" table table-bordered">
				   <tr>
			    		<th>Id</th>
			    		<th>Nom</th>
			    		<th>Prénom</th>
			    		<th>Date Fiche</th>
			    		<th>Action</th>
				   </tr>
				<?php
					foreach ($lesInfos as $uneFiche)
					{		
						$id = $uneFiche['id'];
						$date = $uneFiche['date'];
						?>					
						<tr> 
							<td><?php echo $uneFiche['id']; ?></td> 
							<td><?php echo $uneFiche['nom'];?></td>
							<td><?php echo $uneFiche['prenom'];?></td>
							<td><?php echo $uneFiche['mois'] . '-' . $uneFiche['an'];  ?></td>
							<td><?php echo "<a href='index.php?uc=validerFicheFrais&action=selectionnerFicheFrais&id=$id&date=$date' class='btn btn-primary' role='button'>Accéder à la fiche</a>" ?></td>
						</tr>
												
					<?php }	?>	
					</table>	
				<?php 								
				}
				else
				{
						?>
						
						Aucune fiche de frais à valider
				<?php 
				}
				?>
		    </table>
		</fieldset>	 
	</div>       
</form>
  

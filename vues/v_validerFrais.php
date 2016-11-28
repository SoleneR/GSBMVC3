<h2>Valider une fiche de frais :</h2>

  <div class="divCacheValidation" id="divCacheValidation"></div>
  <div class="ficheFraisValidee" id="ficheFraisValidee"></div>
  <div class="ficheFraisNonValidee" id="ficheFraisNonValidee"></div>

<form class="form-vertical" action="">
      <div class="corpsForm">

          <label>Visiteurs ayant des fiches frais à l'état "clôturée" :</label>
          <br/>
          
          <?php
            if (empty($visiteursAvecFicheCloturee))
            {
                echo "Aucune fiche de frais à valider.";
            }
            
            else 
            {          
          ?>
          
          <table class="table table-bordered">
              <thead>
                  <th>Nom d'utilisateur :</th>
                  <th>Mois :</th>
                  <th style="width : 250px;">Modifier l'état de la fiche</th>
              </thead>
              
              <br/>
              
           <?php
           $var = "";
           
         foreach ( $visiteursAvecFicheCloturee as $unVisiteur ) 
	{          
            //var_dump($unVisiteur); 
            echo "<tbody class='ligneFicheFraisForfaisCloturee' id='ligne'".$unVisiteur['mois'].$unVisiteur['id'].">";
            if ($var != $unVisiteur['id'])
            {         
                echo "<td>".$unVisiteur['nom']." ".$unVisiteur['prenom']."</td>";       
                echo "<td id='ficheDuVisiteurNom".$unVisiteur['id']."' style='display: none;'>".$unVisiteur['nom']."</td>";
                echo "<td id='ficheDuVisiteurPrenom".$unVisiteur['id']."' style='display: none;'>".$unVisiteur['prenom']."</td>"; 
            }
            
             else 
             {
                 echo "<td></td>";
             }

            $annee = substr($unVisiteur['mois'], 0, 4);
            $mois = substr($unVisiteur['mois'], 4, 6);

            if(substr($mois, 0, 1) == '0')
            {
              $mois = substr($mois, 1, 2);
            }

            $tabMois = array('', 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'aôut', 'septembre', 'octobre', 'novembre', 'décembre');
            echo "<td>".ucfirst($tabMois[$mois])." ".$annee."</td>";
            echo "<td id='ficheDuVisiteurMoisAnnee".$unVisiteur['mois'].$unVisiteur['id']."' style='display: none;'>".$unVisiteur['mois']."</td>"; 
            
            //parcourir les lignes résultats tant que le visiteur a encore des fiches frais cloturées.
            
            echo "<td><a href='#' name='modifEtatLigneFicheFrais' id='".$unVisiteur['mois'].$unVisiteur['id']."'>";
            echo "<input style='border-color: rgba(50,50,50,.3); box-shadow: 0 0 5px rgba(0,0,0,.7); width: 80%; margin-left: 20px;' class='btn-success' type='submit' value='Valider'/></a></td>";  
            echo "</tbody>";

            $var = $unVisiteur['id'];
        }
            ?>
          </table>
         
<?php 
            }
    if (isset($_REQUEST['erreurs'])&& $_REQUEST['erreurForm']=="FraisForfait") 
    {    
        foreach($_REQUEST['erreurs'] as $erreur)
            {
             echo '<h3 class="text-danger">'.$erreur.'</h3>';
            }
     }
?>      
   </div>
   </form>
     

  
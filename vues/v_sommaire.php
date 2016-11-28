    <!-- Division pour le sommaire -->
<div class="row">
      
    <nav class='col-md-2'>
        
        <h4>
            <?php echo $_SESSION['prenom']."  ".$_SESSION['nom']?>
            
        </h4>
           
        <ul class="list-unstyled">
			
           <li>
              <a href="index.php?uc=gererFrais&action=saisirFrais" title="Saisie fiche de frais ">Saisie fiche de frais</a>
           </li>
           <li>
              <a href="index.php?uc=etatFrais&action=selectionnerMois" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
           </li>
           
           <!-- Si l'utilisateur est un comptable alors afficher cette fonctionnalité -->
           <?php 
            if($_SESSION['type'] == 'C')
            {
           ?>
           
           <li>
              <a href="index.php?uc=validerFrais&action=afficherFormulaireValidationFicheFrais" title="Validation de fiche de frais">Valider fiche de frais</a>
           </li>
           
           <?php        
          }
           ?>          
           <?php
          // $info =$pdo->getInfosVisiteur($login,$mdp);
           if($_SESSION['type'] == 'C')
           {
           ?>
           <li>
              <a href="index.php?uc=inscriptionNouveauVisiteur&action=demandeInscription" title="inscription">Inscription nouveau visiteur</a>
           </li>
           <?php
           }
           ?>
            <?php 
           if($_SESSION['type'] == "C")
          {
               ?>
           <li>
              <a href="index.php?uc=suivrePaiement&action=suivrePaiement" title="Se déconnecter">Suivie paiement fiche frais</a>
           </li>
        <?php }?>
 	   <li>
              <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
           </li>
          
         </ul>
        
    </nav>
    <div id="contenu" class="col-md-10">
   
        
    
    

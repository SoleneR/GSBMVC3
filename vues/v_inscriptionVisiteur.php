<div class="row">
               
    <div class ="col-md-12 col-md-offset-2" id="contenu">
<?php 
if (isset($_REQUEST['erreurs'])) 
    {    
        foreach($_REQUEST['erreurs'] as $erreur)
            {
             echo '<h3 class="text-danger">'.$erreur.'</h3>';
            }
     }
?>
      <form class="form-vertical" method="POST" action="index.php?uc=inscriptionNouveauVisiteur&action=valideInscription">
         <fieldset>
             <legend>Veuillez inscrire les informations du visiteur: </legend>
   	 <div class="form-group"> 	
         <label for="id">Id </label>
         <div class="row">
             <div class="col-xs-12 col-sm-6 col-md-4">
             <input class="form-control"  id="id" type="text" name="id"  size="5"placeholder="id" required>
            </div>
         </div>
         </div>
         <div class="form-group"> 
	 <label for="nom">Nom </label>
         <div class="row">
             <div class="col-xs-12 col-sm-6 col-md-4">
             <input class="form-control" id="nom"  type="text"  name="nom" size="30" placeholder="nom" required>
            </div>
         </div>
         </div>
             <div class="form-group"> 
	 <label for="prenom">Prenom </label>
         <div class="row">
             <div class="col-xs-12 col-sm-6 col-md-4">
             <input class="form-control" id="prenom"  type="text"  name="prenom" size="30"  placeholder="prenom" required>
            </div>
         </div>
         </div>
             <label for="adresse">Adresse </label>
         <div class="row">
             <div class="col-xs-12 col-sm-6 col-md-4">
             <input class="form-control" id="adresse"  type="text"  name="adresse" size="30"  placeholder="adresse" required>
            </div>
         </div>
         
            <label for="cp">Code postale </label>
         <div class="row">
             <div class="col-xs-12 col-sm-6 col-md-4">
             <input class="form-control" id="cp"  type="text"  name="cp" size="30"  placeholder="cp" required>
            </div>
         </div>
         
            <label for="ville">Ville </label>
         <div class="row">
             <div class="col-xs-12 col-sm-6 col-md-4">
             <input class="form-control" id="ville"  type="text"  name="ville" size="30" placeholder="ville" required>
            </div>
         </div>
            <label for="dateembauche">Date d'embauche </label>
         <div class="row">
             <div class="col-xs-12 col-sm-6 col-md-4">
             <input class="form-control" id="dateEmbauche"  type="date"  name="dateEmbauche"  required>
            </div>
         </div>
            <BR>
          <button type="submit" class="btn btn-primary">Valider</button>
          <button type="reset" class="btn btn-primary">annuler</button>
          <button type="reset" class="btn btn-primary">Retour</button>
         </fieldset>
      </form>

    </div>
</div>
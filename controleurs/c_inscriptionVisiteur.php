<?php

    if (!isset($_REQUEST['action'])) 
    {
        $_REQUEST['action'] = 'demandeConnexion';
    }
    $action = $_REQUEST['action'];
    switch($action)
    {
	case 'demandeInscription':{
		include("vues/v_inscriptionVisiteur.php");break;
	}
	case 'valideInscription':{
		$id = $_REQUEST['id'];
		$nom = $_REQUEST['nom'];
                $prenom = $_REQUEST['prenom'];
                $adresse = $_REQUEST['adresse'];
                $cp = $_REQUEST['cp'];
                $ville = $_REQUEST['ville'];
                $dateEmbauche = $_REQUEST['dateEmbauche'];
     
   if($id =! "" && $nom != "" && $prenom!=""){     
        $login = $prenom[0].$nom;                    
        $mdp="";
        for($i= 1;$i<=4;$i++){
            $n=rand(0,120); 
            $mdp=$mdp.chr($n);
        }
        
    $pdo->insertionUtilisateur($login, $mdp, $id);
    $pdo->inscriptionVisiteur($id,$nom, $prenom,$login ,$adresse, $cp, $ville, $dateEmbauche); 
    afficheValidationVisiteur($login, $mdp, $id, $nom, $prenom, $adresse, $cp, $ville, $dateEmbauche);
    }
    
    else{
        alert("Erreur de création du nouveau visiteur");
        
    }  
        }
}
?>


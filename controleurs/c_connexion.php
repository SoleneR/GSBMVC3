<?php
if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion';
}
$action = $_REQUEST['action'];
switch($action){
	case 'demandeConnexion':{
		include("vues/v_connexion.php");  //bger
		break;
	}
	case 'valideConnexion':{
		$login = $_REQUEST['login'];
		$mdp = $_REQUEST['mdp'];
                
                               
            $info =$pdo->getInfosVisiteur($login,$mdp);
           
             if($info['type']== 'V')
             {
                 $visiteur = $pdo->getConnexionVisiteur($login,$mdp);
                        $id = $visiteur['idVisit'];
			$nom =  $visiteur['nom'];
			$prenom = $visiteur['prenom'];
                        $derniereCo = $visiteur['derniereConnexion'];
			 
			connecter($id,$nom,$prenom,$derniereCo);
			
                        $pdo->UpdateDate($id);
                        include("vues/v_sommaire.php");
		
             }    
             else if ($info['type']== 'C'){
                 $comptable = $pdo->getConnexionComptable($login,$mdp);
			$id = $comptable['id'];
			$nom =  $comptable['nom'];
			$prenom = $comptable['prenom'];
                        $derniereCo = $comptable['derniereConnexion'];
                        
			connecter($id,$nom,$prenom,$derniereCo);
			
                        $pdo->UpdateDate($id);
                        include("vues/v_sommaire.php");
		
                }
            else{               
			ajouterErreur("Login ou mot de passe incorrect","connexion");
            }
            
            break;
	}
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>
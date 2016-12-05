<?php
if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion';
}
$action = $_REQUEST['action'];
switch($action){
	case 'demandeConnexion':{
		include("vues/v_connexion.php");  
		break;
	}
	case 'valideConnexion':{
		$login = $_REQUEST['login'];
		$mdp = md5($_REQUEST['mdp']);
                               
                $info =$pdo->getInfosVisiteur($login,$mdp);
                
           
            if($info['type']== 'V')
            {
                 $visiteur = $pdo->getConnexionVisiteur($login,$mdp);
                        $id = $visiteur['idVisit'];
			$nom =  $visiteur['nom'];
			$prenom = $visiteur['prenom'];
                        $derniereCo = $visiteur['derniereConnexion'];
			$type = $visiteur['type'];
			
                        connecter($id,$nom,$prenom,$type,$derniereCo);
			
                        $pdo->UpdateDate($login);
                        include("vues/v_sommaire.php");
		
            }    
            else if ($info['type']== 'C')
            {
                 $comptable = $pdo->getConnexionComptable($login,$mdp);
			$id = $comptable['id'];
			$nom =  $comptable['nom'];
			$prenom = $comptable['prenom'];
                        $type = $comptable['type'];
                        $derniereCo = $comptable['derniereConnexion'];
                        
			connecter($id,$nom,$prenom,$type,$derniereCo);
			
                        $pdo->UpdateDate($login);
                        include("vues/v_sommaire.php");
		
            }
            else
            {               
		msgErreurCnx("connexion");
                include("vues/v_connexion.php");
            }
            
            break;
	}
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>
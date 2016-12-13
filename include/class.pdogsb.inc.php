<?php
/** 
 * Classe d'accès aux données. 
 
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 
 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb{   		
      	private $serveur='mysql:host=localhost';
      	private $bdd='dbname=gsb_frais_new3';   		
      	private $user='userGsb' ;    		
      	private $mdp='secret' ;	
        private $monPdo; //objet de connection à la bdd
	    private static $monPdoGsb=null; //instance unique de la classe


/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
	private function __construct(){
            $this->monPdo = new PDO($this->serveur.';'.$this->bdd, $this->user, $this->mdp,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION)); 
            $this->monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
            $this->monPdo = null;
	}


/**
 * Fonction statique qui crée l'unique instance de la classe 
 * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
 * @return l'unique objet de la classe PdoGsb
 */
	public  static function getPdoGsb(){
		if(self::$monPdoGsb==null){
			self::$monPdoGsb= new PdoGsb();
		}
		return self::$monPdoGsb;  
	}


/**
 * Retourne les informations d'un visiteur 
 * @param $login 
 * @param $mdp
 * @return l'id, le nom et le prénom sous la forme d'un tableau associatif 
*/
	public function getInfosVisiteur($login, $mdp){
            $req = "SELECT * FROM utilisateur where login=:login and mdp=:mdp";
            $rs = $this->monPdo->prepare($req);
            $rs->bindParam(':login', $login); 
            $rs->bindParam(':mdp', $mdp);
            $rs->execute();
            $ligne = $rs->fetch();
            return $ligne;
	}

        
        public function getIdVisiteur($id){
            $req = "SELECT id FROM visiteur";
            $rs = $this->monPdo->prepare($req);
            $rs->execute();
            $ligne = $rs->fetch();
            return $ligne;
        }
        
        
        public function getConnexionVisiteur($login, $mdp)
        {
            $req= "SELECT utilisateur.login AS loginUser, utilisateur.mdp, utilisateur.derniereConnexion, visiteur.id AS idVisit, visiteur.nom, visiteur.prenom, utilisateur.type FROM 
                    utilisateur INNER JOIN visiteur ON utilisateur.login = visiteur.login
                    where utilisateur.login=:login and utilisateur.mdp=:mdp";
			$rs = $this->monPdo->prepare($req);
			$rs->bindParam(':login', $login); 
	        $rs->bindParam(':mdp', $mdp);
	        $rs->execute();
			$ligne = $rs->fetch();
			return $ligne;
        }
        
        public function getConnexionComptable($login, $mdp)
        {
            $req= "SELECT utilisateur.login AS login, utilisateur.mdp, utilisateur.derniereConnexion, comptable.id AS id, comptable.nom, comptable.prenom, utilisateur.type FROM 
                    utilisateur INNER JOIN comptable ON utilisateur.login = comptable.login
                    where utilisateur.login=:login and utilisateur.mdp=:mdp";
			$rs = $this->monPdo->prepare($req);
			$rs->bindParam(':login', $login); 
	        $rs->bindParam(':mdp', $mdp);
	        $rs->execute();
			$ligne = $rs->fetch();
			return $ligne;
        }
        
        public function updateDate($login)
        {
            $req= "UPDATE utilisateur
                   SET derniereConnexion = NOW() 
                   where login='$login'";

            $rs = $this->monPdo->exec($req);
        }
        

        //Ajout d'un visiteur 
        function inscriptionVisiteur($id,$nom, $prenom,$login, $adresse, $cp, $ville, $dateEmbauche){
           $req = "insert into visiteur (id, nom,prenom,login,adresse,cp,ville, dateEmbauche)
                     values ('$id','$nom', '$prenom','$login','$adresse','$cp','$ville','$dateEmbauche')";
            $rs = $this->monPdo->query($req); 
           
            
        }

        //Ajout d'un utilisateur
         function insertionUtilisateur($login, $mdp){
            $req = " insert into utilisateur (login, mdp,type)
                     VALUES ('$login', md5('$mdp'),'V')";
            $rs = $this->monPdo->query($req);
           
        }
/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait
 * concernées par les deux arguments
 * La boucle foreach ne peut être utilisée ici car ON procède
 * à une modification de la structure itérée - transformation du champ date-
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif 
*/
	public function getLesFraisHorsForfait($idVisiteur,$mois)
	{
	    $req = "SELECT * FROM lignefraishorsforfait WHERE lignefraishorsforfait.idvisiteur ='$idVisiteur' 
		AND lignefraishorsforfait.mois = :mois AND supprime = '0'";	
		$res = $this->monPdo->prepare($req);
		$res->bindParam(':mois', $mois); 
	    $res->execute();
		$lesLignes = $res->fetchAll();
		$nbLignes = count($lesLignes);
		for ($i=0; $i<$nbLignes; $i++)
		{
			$date = $lesLignes[$i]['date'];
			$lesLignes[$i]['date'] =  dateAnglaisVersFrancais($date);
		}
		return $lesLignes; 
	}


/**
 * Retourne le nombre de justificatif d'un visiteur pour un mois donné 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return le nombre entier de justificatifs 
*/
	public function getNbjustificatifs($idVisiteur, $mois){
		$req = "SELECT fichefrais.nbjustificatifs AS nb FROM  fichefrais where fichefrais.idvisiteur =:idVisiteur and fichefrais.mois = :mois";
		$res = $this->monPdo->prepare($req);
		$res->bindParam(':idvisiteur', $idvisiteur); 
	    $res->bindParam(':mois', $mois);
	    $res->execute();
		$laligne = $res->fetch();
		return $laLigne['nb'];
	}


/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
 * concernées par les deux arguments 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return l'id, le libelle et la quantité sous la forme d'un tableau associatif 
*/
	public function getLesFraisForfait($idVisiteur, $mois)
	{
		$req = "SELECT fraisforfait.id AS idfrais, fraisforfait.libelle AS libelle, 
		lignefraisforfait.quantite AS quantite, lignefraisforfait.mois AS date FROM lignefraisforfait INNER JOIN fraisforfait 
		ON fraisforfait.id = lignefraisforfait.idfraisforfait
		WHERE lignefraisforfait.idvisiteur =:idVisiteur AND lignefraisforfait.mois=:mois
		ORDER BY lignefraisforfait.idfraisforfait";	
		$res = $this->monPdo->prepare($req);
		$res->bindParam(':idVisiteur', $idVisiteur); 
	    $res->bindParam(':mois', $mois);
	    $res->execute();
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}


/**
 * Retourne tous les id de la table FraisForfait 
 * @return un tableau associatif 
*/
	public function getLesIdFrais(){
		$req = "SELECT fraisforfait.id AS idfrais FROM fraisforfait order by fraisforfait.id";
		$res = $this->monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}


/**
 * Met à jour la table ligneFraisForfait 
 * Met à jour la table ligneFraisForfait pour un visiteur et
 * un mois donné en enregistrant les nouveaux montants 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
 * @return un tableau associatif 
*/
	public function majFraisForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
		foreach($lesCles AS $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "UPDATE lignefraisforfait set lignefraisforfait.quantite = :qte
			where lignefraisforfait.idvisiteur = :idVisiteur and lignefraisforfait.mois = :mois
			and lignefraisforfait.idfraisforfait = :unIdFrais";
			$res = $this->monPdo->prepare($req);
			$res->bindParam(':qte', $qte); 
	    	$res->bindParam(':idVisiteur', $idVisiteur);
	    	$res->bindParam(':mois', $mois);
	    	$res->bindParam(':unIdFrais', $unIdFrais);
	    	$res->execute();
		}
		
	}


/**
 * met à jour le nombre de justificatifs de la table ficheFrais
 * pour le mois et le visiteur concerné 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs){
		$req = "UPDATE fichefrais set nbjustificatifs = $nbJustificatifs 
		where fichefrais.idvisiteur = :idVisiteur and fichefrais.mois = :mois";
			$res = $this->monPdo->prepare($req);
	    	$res->bindParam(':idVisiteur', $idVisiteur);
			$res->bindParam(':mois', $mois); 
	    	$res->execute();	
	}


/**
 * Teste si un visiteur possède une fiche de frais pour le mois passé en argument 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return vrai ou faux 
*/	
	public function estPremierFraisMois($idVisiteur,$mois)
	{
		$ok = false;
		$req = "SELECT count(*) AS nblignesfrais FROM fichefrais 
		where fichefrais.mois = :mois and fichefrais.idvisiteur = :idVisiteur";
		$res = $this->monPdo->prepare($req);
	    $res->bindParam(':mois', $mois);
		$res->bindParam(':idVisiteur', $idVisiteur); 
	    $res->execute();
		$laLigne = $res->fetch();
		if($laLigne['nblignesfrais'] == 0){
			$ok = true;
		}
		return $ok;
	}


/**
 * Retourne le dernier mois en cours d'un visiteur 
 * @param $idVisiteur 
 * @return le mois sous la forme aaaamm
*/	
	public function dernierMoisSaisi($idVisiteur){
		$req = "SELECT max(mois) AS dernierMois FROM fichefrais where fichefrais.idvisiteur = :idVisiteur";
		$res = $this->monPdo->prepare($req);
		$res->bindParam(':idVisiteur', $idVisiteur); 
	    $res->execute();
		$laLigne = $res->fetch();
		$dernierMois = $laLigne['dernierMois'];
		return $dernierMois;
	}
	

/**
 * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et un mois donnés 
 * récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, crée une nouvelle fiche de frais
 * avec un idEtat à 'CR' et crée les lignes de frais forfait de quantités nulles 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function creeNouvellesLignesFrais($idVisiteur,$mois){
		$dernierMois = $this->dernierMoisSaisi($idVisiteur);
		$laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur,$dernierMois);
		if($laDerniereFiche['idEtat']=='CR')
		{
			$this->majEtatFicheFrais($idVisiteur, $dernierMois,'CL');				
		}
		$req = "INSERT INTO fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
		values(:idVisiteur,:mois,0,0,now(),'CR')";
		$res = $this->monPdo->prepare($req);
		$res->bindParam(':idVisiteur', $idVisiteur); 
		$res->bindParam(':mois', $mois); 
	    $res->execute();
		$lesIdFrais = $this->getLesIdFrais();
		foreach($lesIdFrais AS $uneLigneIdFrais){
			$unIdFrais = $uneLigneIdFrais['idfrais'];
			$req = "INSERT INTO lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite) 
			values(:idVisiteur,:mois,:unIdFrais,0)";
				$res = $this->monPdo->prepare($req);
				$res->bindParam(':idVisiteur', $idVisiteur); 
				$res->bindParam(':mois', $mois); 
				$res->bindParam(':unIdFrais', $unIdFrais); 
			    $res->execute();
		 }
	}


/** ERREUR
 * Crée un nouveau frais hors forfait pour un visiteur un mois donné
 * à partir des informations fournies en paramètre 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $libelle : le libelle du frais
 * @param $date : la date du frais au format français jj//mm/aaaa
 * @param $montant : le montant
*/
	public function creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$date,$montant){
		$dateFr = dateFrancaisVersAnglais($date);
                $libEchap = $this->monPdo->quote($libelle);
		$req = "insert into lignefraishorsforfait 
		values('','$idVisiteur','$mois',$libEchap,'$dateFr','$montant')";
                $this->monPdo->exec($req);
	}


/**
 * Supprime le frais hors forfait dont l'id est passé en argument 
 * @param $idFrais 
*/
	public function supprimerFraisHorsForfait($idFrais){
		$req = "delete FROM lignefraishorsforfait where lignefraishorsforfait.id =:idFrais ";
		$res = $this->monPdo->prepare($req);
		$res->bindParam(':idFrais', $idFrais); 
		$res->execute();
	}

        
//affichage pour un visiteur des fiches de frais des 12 derniers mois qui sont validés ou remboursés 
        public function getLesVisiteursASuivre(){
            //VA RB
            $req ="SELECT visiteur.id, visiteur.nom , fichefrais.idVisiteur,fichefrais.mois "
                    . "FROM Etat inner join fichefrais on Etat.id = fichefrais.idEtat"
                    . " inner join visiteur on fichefrais.idVisiteur = visiteur.id where fichefrais.idEtat ='VA' OR fichefrais.idEtat ='RB'"
                    . "ORDER BY `fichefrais`.`mois` DESC LIMIT 0 , 12";
            $res = $this->monPdo->query($req);
		$laLigne = $res->fetchAll();
		return $laLigne;
        }
        
  	public function getFichesFraisUtilisateurSuiviePaiement($idVisiteur){
	    $req = "SELECT * FROM fichefrais WHERE idVisiteur = :idVisiteur AND (idEtat = 'VA' || idEtat = 'RB') ORDER BY `fichefrais`.`mois` DESC LIMIT 0 , 12";
	    $res = $this->monPdo->prepare($req);
		$res->bindParam(':idVisiteur', $idVisiteur); 
		$res->execute();
	    return $res;        
    }

       
/**
 * Retourne les mois pour lesquel un visiteur a une fiche de frais 
 * @param $idVisiteur 
 * @return un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant 
*/
	public function getLesMoisDisponibles($idVisiteur){
		$req = "SELECT fichefrais.mois AS mois FROM  fichefrais where fichefrais.idvisiteur =:idVisiteur order by fichefrais.mois desc ";
		$res = $this->monPdo->prepare($req);
		$res->bindParam(':idVisiteur', $idVisiteur); 
		$res->execute();
		$lesMois =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
		     "mois"=>"$mois",
		    "numAnnee"  => "$numAnnee",
			"numMois"  => "$numMois"
             );
			$laLigne = $res->fetch(); 		
		}
		return $lesMois;
	}


/**
 * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donné 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état 
*/	
	public function getLesInfosFicheFrais($idVisiteur,$mois)
	{
		$req = "SELECT idVisiteur,  nom, prenom, ficheFrais.idEtat AS idEtat, ficheFrais.dateModif AS dateModif, ficheFrais.nbJustificatifs AS nbJustificatifs, 
			ficheFrais.montantValide AS montantValide, etat.libelle AS libEtat FROM  fichefrais INNER JOIN Etat ON ficheFrais.idEtat = Etat.id 
			INNER JOIN visiteur ON fichefrais.idVisiteur=visiteur.id
			WHERE fichefrais.idvisiteur =:idVisiteur AND fichefrais.mois = :mois";
		$res = $this->monPdo->prepare($req);
		$res->bindParam(':idVisiteur', $idVisiteur); 
		$res->bindParam(':mois', $mois); 
		$res->execute();
		$laLigne = $res->fetch();
		return $laLigne;
	}


/**
 * Modifie l'état et la date de modification d'une fiche de frais 
 * Modifie le champ idEtat et met la date de modif à aujourd'hui
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 */
	public function majEtatFicheFrais($idVisiteur,$mois,$etat){
		$req = "UPDATE ficheFrais set idEtat = :etat, dateModif = now() 
		where fichefrais.idvisiteur =:idVisiteur and fichefrais.mois = :mois";
		$res = $this->monPdo->prepare($req);
		$res->bindParam(':etat', $etat); 
		$res->bindParam(':idVisiteur', $idVisiteur); 
		$res->bindParam(':mois', $mois); 
		$res->execute();
	}


/**
 * Retourne les utilisateurs pour lesquel un ou plusieurs mois ont  été cloturés
 * @param  
 * @return un tableau ASsociatif contenant l'id, le nom, le prenom, et le mois, l'année et la date
*/
	public function getLesFichesCloturees()
	{
		$req = "SELECT id, nom, prenom, SUBSTR(fichefrais.mois,1,4) AS an, SUBSTR(fichefrais.mois,5) AS mois, mois AS date FROM visiteur INNER JOIN fichefrais ON visiteur.id=fichefrais.idVisiteur WHERE idEtat= 'CL'
		ORDER BY nom ASC, prenom DESC, date DESC";
		$res = $this->monPdo->query($req);
		$lesInfos = $res->fetchAll();
		return $lesInfos;
	}


/**
 * Modifie l'état de la fiche de frais pour la mettre en validée, met a jour la date et le montant
 * Modifie le champ idEtat et montantValide
 * @param $id,$date 
 */
    public function validerFicheFrais($id,$mois) //,$montantValide
    {
        $req ="UPDATE fichefrais SET dateModif = NOW(), idEtat = 'VA' WHERE idVisiteur = :id AND mois = :mois"; //AND montantValide = $montantValide
        $res = $this->monPdo->prepare($req);
		$res->bindParam(':id', $id);
		$res->bindParam(':mois', $mois); 
		$res->execute();
    }

/**
 * Supprime virtuellement le frais hors forfait dont l'id est passé en argument
 * @param $idFrais 
*/
	public function supprimerFraisHorsForfaitComptable($idFrais,$motif) 
	{
		$req = "UPDATE lignefraishorsforfait SET supprime = '1',  motifSuppresion = :motif WHERE id =:idFrais ";
		$res = $this->monPdo->prepare($req);
		$res->bindParam(':motif', $motif);
		$res->bindParam(':idFrais', $idFrais); 
		$res->execute();
	}


/**
 * Modifie les valeurs des éléments forfaitisée d'une fiche de frais cloturée
 * Modifie les champs Forfait Etape, Frais Kilométrique, Nuitée Hôtel, Repas Restaurant 
 * @param $valeur
 * @param $idVisiteur
 * @param $date
 * @param $champ
 */ 
	public function majLigneFraisForfait($valeur, $idVisiteur, $date, $champ)
	{
		$req = "UPDATE lignefraisforfait SET quantite = :valeur
		WHERE idVisiteur = :idVisiteur AND mois = :date AND idFraisforfait =:champ";
		$res = $this->monPdo->prepare($req);
		$res->bindParam(':valeur', $valeur);
		$res->bindParam(':idVisiteur', $idVisiteur); 
		$res->bindParam(':date', $date); 
		$res->bindParam(':champ', $champ); 
		$res->execute();
	}

}
?>

<?php

date_default_timezone_set('Europe/Paris');

$show = new show();
class show
{
	function showError($error)
	{
		echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.$error.'</div>';
	}
	function showSuccess($success)
	{
		echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.$success.'</div>';
	}
}


function actualisation_session($bdd){ // Fonction qui permet d'actualiser les informations
    if(isset($_SESSION['utilisateur']) && !empty($_SESSION['utilisateur'])) 
	{
		$user_id = $_SESSION['utilisateur']['user_id'];

		$requete = $bdd->prepare("SELECT * FROM joueurs WHERE user_id = '$user_id'");
		$requete->execute();
		$reponse=$requete->fetch();
		$_SESSION['utilisateur']= $reponse;	
	}
}

function checkpseudo($pseudo, $bdd)
{
	$pseudo = htmlentities($pseudo, ENT_NOQUOTES, 'utf-8');
    $pseudo = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $pseudo);
    $pseudo = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $pseudo); // pour les ligatures e.g. '&oelig;'
    $pseudo = preg_replace('#&[^;]+;#', '', $pseudo); // supprime les autres caractères
    $pseudo = preg_replace('#[^[:alnum:]]#u', '', $pseudo);
	
    if($pseudo == '') return 'empty';
    else if(strlen($pseudo) < 3) return 'tooshort';
    else if(strlen($pseudo) > 32) return 'toolong';
    else
    {
        $preparation = $bdd->query("SELECT COUNT(*) AS nbr FROM joueurs WHERE user_pseudo = '".$pseudo."'");
		$result = $preparation->fetch();
		
        if($result['nbr'] > 0) return 'exists';
        else return 'ok';
		
    }
}

 			function remove_accent($str)
		{
		  $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð',
		                'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã',
		                'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ',
		                'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ',
		                'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę',
		                'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī',
		                'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ',
		                'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ',
		                'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 
		                'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 
		                'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ',
		                'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');

		  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O',
		                'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c',
		                'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u',
		                'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D',
		                'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g',
		                'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K',
		                'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o',
		                'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S',
		                's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W',
		                'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i',
		                'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
		  return str_replace($a, $b, $str);
		}	
		
		function slug($titre)
		{
		  echo mb_strtolower(preg_replace(array('/[^a-zA-Z0-9 \'-]/', '/[ -\']+/', '/^-|-$/'),
		  array('', '-', ''), remove_accent($titre)));
		}

		function slug_r($titre)
		{
		  return mb_strtolower(preg_replace(array('/[^a-zA-Z0-9 \'-]/', '/[ -\']+/', '/^-|-$/'),
		  array('', '-', ''), remove_accent($titre)));
		}

function checkText($texte)
{
	$texte = htmlentities($texte, ENT_NOQUOTES, 'utf-8');
	
    if(strlen($texte) < 1) return 'empty';
    else if(strlen($texte) < 5) return 'tooshort';
    else if(strlen($texte) > 1500) return 'toolong';
    else return 'ok';
}

function checkmdp($mdp)
{
    if($mdp == '') return 'empty';
    else if(strlen($mdp) < 4) return 'tooshort';
    else if(strlen($mdp) > 50) return 'toolong';
     
    else return 'ok';

}

function checkmdpS($mdp, $mdp2)
{
    if($mdp != $mdp2 && $mdp != '' && $mdp2 != '') return 'different';
    else return checkmdp($mdp);
}

function checkmail($user_mail, $bdd)
{
    if($user_mail == '') return 'empty';
    else if(!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#is', $user_mail)) return 'isnt';
     
    else
    {
        $preparation = $bdd->query("SELECT COUNT(*) AS nbr FROM joueurs WHERE user_mail = '".$user_mail."'");
        $result = $preparation->fetch();
		
        if($result['nbr'] > 0) return 'exists';
        else return 'ok';
    }
}
function checkmail_compte($user_mail, $bdd)
{
    if($user_mail == '') return 0;
    else if(!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#is', $user_mail)) return 1;
     
    else
    {
        $preparation = $bdd->query("SELECT COUNT(*) AS nbr FROM joueurs WHERE user_mail = '".$user_mail."'");
        $result = $preparation->fetch();
		
        if($result['nbr'] > 0) return 2;
        else return 3;
    }
}

function checkDestinataire($user_pseudo, $bdd)
{
        $preparation = $bdd->query("SELECT COUNT(*) AS nbr FROM joueurs WHERE user_pseudo = '".$user_pseudo."'");
        $result = $preparation->fetch();
		
        if($result['nbr'] ==! 0) return 1;
        else return 0;
}

function checkmailS($user_mail, $user_mail2)
{
    if($user_mail != $user_mail2 && $user_mail != '' && $user_mail2 != '') return 'different';
    else return 'ok';
}


	function url_exists($url_a_tester)
	{
		$F=@fopen($url_a_tester,"r");
	
		return ($F)? 1 : 0;
	}



function ChaineAleatoire($nbcar)
				{
					$chaine = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
				
					srand((double)microtime()*1000000);
				
					$variable='';
						
					for($i=0; $i<$nbcar; $i++) $variable .= $chaine{rand()%strlen($chaine)};
					return $variable;
				}
function ChiffreAleatoire($nbcar)
				{
					$chaine = '0123456789';
				
					srand((double)microtime()*1000000);
				
					$variable='';
						
					for($i=0; $i<$nbcar; $i++) $variable .= $chaine{rand()%strlen($chaine)};
					return $variable;
				}
				
function variable($var)
{
	//$var = htmlentities( trim( $var, " \0" ), ENT_NOQUOTES );
    //$var = mysql_real_escape_string( $var );
    return mysql_real_escape_string(htmlspecialchars($var));
}

		function rang_vote($bdd){ // Fonction qui permet d'actualiser les informations
			if(isset($_SESSION['utilisateur']) && !empty($_SESSION['utilisateur'])) 
			{
				$id = $_SESSION['utilisateur']['user_id'];
		
				$requete = $bdd->prepare("SELECT * FROM joueurs ORDER BY vote DESC");
				$requete->execute();
		
				$i = 1;
				while($resultats = $requete->fetch(PDO::FETCH_OBJ))
				{
					if ($_SESSION['utilisateur']['user_pseudo'] == $resultats->user_pseudo)
					{
						if ($i == 1) { echo $i .' er'; }
						if ($i > 1) { echo $i .' ème'; }
					}
				$i++;
				}
			}
		}	
		
function taille($fichier){
	$infos_image = getImageSize($fichier); 
		
	$largeur = $infos_image[0]; // largeur de l'image
	$hauteur = $infos_image[1]; // hauteur de l'image
	return $hauteur * $largeur;
}

function historique_object($user_id, $bdd)
{
	$requete = $bdd->prepare("SELECT * FROM boutique WHERE user_id = :user_id");
	$requete->bindParam(':user_id',  $user_id, PDO::PARAM_INT);
	$requete->execute();
	$reponse=$requete->fetch();
	return $reponse['nom'];
	// nom de l'objet
}
function grade_semi($groupe)
{
	switch ($groupe) 
	{
		case 'Administrateur':
			echo '<div style="color: #BE0000"> '.$groupe.' </div>';
			break;

		case 'Game-Master':
		case 'Moderateur' :
				case 'Gmtech' :

			echo '<div style="color: rgb(255, 163, 0)"> '.$groupe.' </div>';
			break;

		case 'Animateur' :
		case 'Animatrice':
			echo '<div style="color: #0000BE"> '.$groupe.' </div>';
			break;

		case 'Seigneur':
			echo '<div style="color: #FEFE3F"> '.$groupe.' </div>';
			break;

		case 'Noble':
			echo '<div style="color: #00BEBE"> '.$groupe.' </div>';
			break;

		case 'Marchand':
			echo '<div style="color: #BE00BE"> '.$groupe.' </div>';
			break;

		case 'Villageois':
			echo '<div style="color: #BEBEBE"> '.$groupe.' </div>';
			break;

		case 'Vip' :
		case 'Guerrier' :
		case 'Heros':
			echo '<div style="color: #3FFE3F"> '.$groupe.' </div>';
			break;

		case 'Architecte' :
		case 'Maire' :
		case 'MaireAdjoint':
			echo '<div style="color: #3FFEFE"> '.$groupe.' </div>';
			break;
		
		default :
		echo $groupe;

	}
}

 						 		function rang_vote_profil($pseudo, $bdd)
								{ 
						
									$requete = $bdd->prepare("SELECT * FROM joueurs ORDER BY vote DESC");
									$requete->execute();
							
									$i = 1;
									while($resultats_2 = $requete->fetch(PDO::FETCH_OBJ))
									{
										if (strtolower($pseudo) == strtolower($resultats_2->user_pseudo))
										{
											if ($i == 1) { return $i .' er'; }
											elseif ($i > 1) { return $i .' ème'; }
											else return $i;
										}
									$i++;
								}
							}	

function grade_faction($groupe)
{
	switch ($groupe) 
	{
		case 'Administrateur':
			echo '<div style="color: #BE0000"> '.$groupe.' </div>';
			break;
			
		case 'Game-Master' :
		case 'Moderateur' :
		case 'Gmtech' :
			echo '<div style="color: rgb(255, 163, 0)"> '.$groupe.' </div>';
			break;

		case 'Animateur' :
		case 'Animatrice':
			echo '<div style="color: #0000BE"> '.$groupe.' </div>';
			break;

		case 'Seigneur':
			echo '<div style="color: #FEFE3F"> '.$groupe.' </div>';
			break;

		case 'Noble':
			echo '<div style="color: #00BEBE"> '.$groupe.' </div>';
			break;

		case 'Marchand':
			echo '<div style="color: #BE00BE"> '.$groupe.' </div>';
			break;

		case 'Villageois':
			echo '<div style="color: #BEBEBE"> '.$groupe.' </div>';
			break;

		case 'Vip' :
		case 'Guerrier' :
		case 'Heros':
			echo '<div style="color: #3FFE3F"> '.$groupe.' </div>';
			break;

		case 'Architecte' :
		case 'Maire' :
		case 'MaireAdjoint':
			echo '<div style="color: #3FFEFE"> '.$groupe.' </div>';
			break;
		

		case 'Novice' :
		case 'Barbare' :
		case 'Combattant' :
		case 'Guerrier':
			echo '<div style="color: #BEBEBE"> '.$groupe.' </div>';
			break;

		case 'Hunter' :
		case 'Chevalier' :
		case 'Gladiateur':
			echo '<div style="color: #00BEBE"> '.$groupe.' </div>';
			break;

		case 'Spadassin' :
		case 'Spartiate' :
		case 'Paladin':
			echo '<div style="color: #0000BE"> '.$groupe.' </div>';
			break;

		case 'Myrmuser_idon' :
		case 'Destructeur' :
		case 'Faucheur':
			echo '<div style="color: #BE00BE"> '.$groupe.' </div>';
			break;

		case 'Gardien' :
		case 'Templier':
			echo '<div style="color: #00BE00"> '.$groupe.' </div>';
			break;

		case 'Berserker' :
		case 'Legende':
			echo '<div style="color: #3FFEFE"> '.$groupe.' </div>';
			break;

		default :
			echo $groupe;
	}
}
		

	function inscrit($bdd)
	{
		$requete = $bdd->prepare('SELECT COUNT(user_id) FROM joueurs');
		$requete->execute();
		$nombreInscrit = $requete->fetch(); 
		
		echo $nombreInscrit[0];
	}
	
	function inscrit_today($bdd)
	{
			$h_minuit = date("H");
			$min_minuit = date("i");
			$a = time() - ($h_minuit * 3600 + $min_minuit * 60 );
			$de = time()  ;

		$requete = $bdd->prepare('SELECT COUNT(user_id) FROM joueurs WHERE user_inscription BETWEEN "'.$a.'" AND "'.$de.'"');
		$requete->execute();
		$nombreInscrit = $requete->fetch(); 
		
		echo $nombreInscrit[0];
	}
	 function smiley($texte)
{
	$texte = str_replace(':)', '<img  src="../images/emots/1.png" />', $texte);
	$texte = str_replace('xd', '<img  src="../images/emots/2.png"  />', $texte);
	$texte = str_replace('xD', '<img  src="../images/emots/2.png"  />', $texte);
	$texte = str_replace('XD', '<img  src="../images/emots/2.png"  />', $texte);
	$texte = str_replace(':(', '<img  src="../images/emots/3.png" />', $texte);
	$texte = str_replace(':d', '<img  src="../images/emots/4.png" />', $texte);
	$texte = str_replace(':D', '<img  src="../images/emots/4.png" />', $texte);
	$texte = str_replace(':p', '<img  src="../images/emots/5.png" />', $texte);
	$texte = str_replace(':P', '<img  src="../images/emots/5.png" />', $texte);
	$texte = str_replace(':S', '<img  src="../images/emots/6.png" />', $texte);
	$texte = str_replace(':O', '<img  src="../images/emots/6.png" />', $texte);
	$texte = str_replace('(L)', '<img  src="../images/emots/7.png"/>', $texte);
	$texte = str_replace('<3', '<img  src="../images/emots/7.png" />', $texte);
	$texte = str_replace('coeur', '<img  src="../images/emots/7.png" />', $texte);
	$texte = preg_replace('`\[g\](.+)\[/g\]`isU', '<strong>$1</strong>', $texte); 
	$texte = preg_replace('`\[i\](.+)\[/i\]`isU', '<em>$1</em>', $texte);
	$texte = preg_replace('`\[s\](.+)\[/s\]`isU', '<u>$1</u>', $texte);
	return $texte;
}

		function sub($contenu, $length) 
		{
			if(strlen($contenu) > $length) {
			  $chaineCoupee = substr($contenu,0,$length).'…';
			  return $chaineCoupee;
			}
			else
			{
			  return $contenu;
			}
		}
		
		function resultat_found ($n)
		 {
			if($n <= 1)
			{
				return '<div class="text-info"> '.$n.' résultat trouvé</div>';
			}
			else
			{
				return '<div class="text-info"> '.$n.' résultats trouvés</div>';	
			}
		 }
		 
		 /**** SYSTEME DE PAGINATION ****/
		 function limit($page_acutel, $nbr)
		 {		
			$lim_1=($page_acutel*$nbr)-$nbr;
			$lim_2=$lim_1+$nbr;
			
			return $lim_1.', '.$lim_2;
		 }
		 
		 function pagination($page_acutel, $nbr, $table, $bdd)
		 {
			$requete = $bdd->prepare("SELECT * FROM ".$table."");
			$requete->execute();

		 	$total = $requete->rowCount();
 			$total = $total/$nbr;
			$nbr_page = ceil($total);
			
			return $nbr_page;
		 }
		 

		 function statistique_page($HTTP_CLIENT_IP, $PHP_SELF, $PAYS_SELF, $bdd)
		 {
				$HTTP_TIME = time();  
				
							$statistiques = $bdd->prepare('INSERT INTO statistiques (ip, date, page, pays) VALUE (:ip, :date, :page, :pays)');
							$statistiques -> bindParam(':ip', $HTTP_CLIENT_IP);
							$statistiques -> bindParam(':date', $HTTP_TIME);
							$statistiques -> bindParam(':page', $PHP_SELF);
							$statistiques -> bindParam(':pays', $PAYS_SELF);
							$statistiques -> execute();

							$statistiques->closeCursor();
						 }
		 
		 function vue_page($PHP_SELF, $bdd)
		 {
				$query = $bdd->prepare('SELECT COUNT(*) FROM statistiques WHERE page LIKE :page');
				$query->bindParam(':page', $PHP_SELF);
				$query->execute();
				
				$resultats = $query->fetch();
				return $resultats[0];
				
				$query->closeCursor();
		 }
		 
		 function nombre_vues($PHP_SELF, $bdd)
		 {
				$query = $bdd->prepare('SELECT COUNT(DISTINCT(ip)) FROM statistiques');
				$query->execute();
				
				$resultats = $query->fetch();
				return $resultats[0];
				
				$query->closeCursor();
		 }



//------------------------------------------------------------------//
// ------- VARIABLES DEFINITIONS - FONCTIONS UTILISATIONS ----------//
//------------------------------------------------------------------//
		 		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
				{  
				 $HTTP_CLIENT_IP = $_SERVER['HTTP_X_FORWARDED_FOR'];  
				}  
				elseif(isset($_SERVER['HTTP_CLIENT_IP'])) 
				{  
				 $HTTP_CLIENT_IP = $_SERVER['HTTP_CLIENT_IP'];  
				}  
				else 
				{  
				 $HTTP_CLIENT_IP = $_SERVER['REMOTE_ADDR'];  
				}  

				if ($_SERVER['QUERY_STRING'] == "") 
				{  
				 $PHP_SELF = $_SERVER['PHP_SELF'];  
				}  
				else 
				{  
				 $PHP_SELF = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];  
				}  
				
				$PAYS_SELF = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
				$PAYS_SELF = $PAYS_SELF{0}.$PAYS_SELF{1};
				
				statistique_page($HTTP_CLIENT_IP, $PHP_SELF, $PAYS_SELF, $bdd);



				if(!isset($_SESSION['utilisateur']))
				{
				    $_SESSION['form_mdp_verif'] = '';
				    $_SESSION['mdp_info'] = '';
				    $_SESSION['form_mail'] = '';
				    $_SESSION['mdp_verif_info'] = '';
				    $_SESSION['mail_info'] = '';
				    $_SESSION['form_mail_verif'] = '';
				    $_SESSION['form_mdp'] = '';
				    $_SESSION['form_mail'] = '';
				    $_SESSION['form_mdp'] = '';
				    $_SESSION['pseudo_info'] = '';
				    $_SESSION['form_pseudo'] = '';
				    $_SESSION['mail_verif_info'] = ''; 	
				}
				
?>
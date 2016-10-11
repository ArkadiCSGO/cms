<?php
session_start();
unset($_SESSION['captcha']); 

	function ChaineAleatoire($nbcar)
	{
		$chaine = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

		srand((double)microtime()*1000000);

		$variable='';
			
		for($i=0; $i<$nbcar; $i++) $variable .= $chaine{rand()%strlen($chaine)};
		return $variable;
	}

	$_SESSION['captcha'] = ChaineAleatoire(5);
?>
<img src="../captcha/captcha.png.php?PHPSESSID=<?php session_id(); ?>"  style="cursor:pointer; position:relative; top:11px;"/>

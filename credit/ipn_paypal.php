<?php
session_start();
 header('Content-type: text/html; charset=utf-8');
 /******** Début des ntêtes des données *********/
  require_once('../configuration/configuration.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');
 /******** Fin des entêtes des données *********/

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
	$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
	$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);

// assign posted variables to local variables
	$item_name = $_POST['item_name'];
	$item_number = $_POST['item_number']; // id commande
	$payment_status = $_POST['payment_status']; // Completed,
	$payment_amount = $_POST['mc_gross']; //0.01
	$payment_currency = $_POST['mc_currency']; //CAD
	$txn_id = $_POST['txn_id'];
	$receiver_email = $_POST['receiver_email'];
	$payer_email = $_POST['payer_email'];
	parse_str($_POST['custom'], $custom);

if (!$fp) 
{
} 
else 
{
	fputs ($fp, $header . $req);
	while (!feof($fp)) 
	{

		$res = fgets ($fp, 1024);

		if (strcmp ($res, "VERIFIED") == 0) 
		{

			if ($payment_status == "Completed")
			{
				if($email_paypal == $receiver_email)
				{
					function update_points($pts, $pseudo, $bdd)
					{
						$update = $bdd->prepare('UPDATE joueurs SET user_points = user_points + :user_points WHERE user_pseudo = :user_pseudo');
				        $update -> bindParam(':user_points', $pts);
				        $update -> bindParam(':user_pseudo', $pseudo);   
				        $update -> execute();
					}
					$pseudo = $custom['pseudo'];
					$datas = serialize($_POST);
					$informations = $_POST['address_name'] . ' - '. $_POST['payer_email'];

					$req = $bdd->prepare('INSERT INTO paypal(pseudo, offre, datas, transaction_number, informations) VALUES(:pseudo, :offre, :datas, :transaction_number, :informations)');
					$req -> bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
					$req -> bindParam(':offre', $item_name);
					$req -> bindParam(':datas', $datas);
					$req -> bindParam(':transaction_number', $txn_id);
					$req -> bindParam(':informations', $informations);
					$req -> execute();

						if($payment_amount == $prix_offre_1)
						{
							update_points($points_offre_1_CREDIT, $pseudo, $bdd);
						}
						elseif($payment_amount == $prix_offre_2)
						{
							update_points($points_offre_2_CREDIT, $pseudo, $bdd);
						}
						elseif($payment_amount == $prix_offre_3)
						{
							update_points($points_offre_3_CREDIT, $pseudo, $bdd);
						}
						elseif($payment_amount == $prix_offre_4)
						{
							update_points($points_offre_4_CREDIT, $pseudo, $bdd);
						}
						elseif($payment_amount == $prix_offre_5)
						{
							update_points($points_offre_5_CREDIT, $pseudo, $bdd);
						}
					
				}
			    
			}
		}
		else if (strcmp ($res, "INVALID") == 0) 
		{

		}
	}
	fclose ($fp);
}
?>
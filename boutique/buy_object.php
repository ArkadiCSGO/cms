<?php
@session_start();
@header('Content-type: text/html; charset=utf-8');
	
  //---------------------------------------------------------
  // Requires fichiers database
  //---------------------------------------------------------
  require_once('../configuration/configuration.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');
	
	echo '<body>';

	if (isset($_SESSION['utilisateur']) && !empty($_SESSION['utilisateur'])) 
	{ 
		
		$_SESSION['buy'] = true;
		 

		if(isset($_GET['id']) && !empty($_GET['serveur']))
		{
			$id = intval($_GET['id']); 
		
			$serveur_get = htmlspecialchars($_GET['serveur']);

			$explode_serveur = explode("_", $serveur_get);
			$serveur_get = $explode_serveur[1];

				$i = array(1,2,3,4,5,6,7,8,9,10);
				if (in_array($serveur_get, $i)) 
				{
					for ($i = 1; $i <= 10; $i++) 
					{
						if($serveur_get == $i)
						{
							$serveur = 'connexion_'.$i.'';
						}
					}
				}
				else
				{
					$serveur = 'connexion_1';	
				}

				if($serveur == 'connexion_1')
				{
					$connexion_serveur = $connexion_1;
				}
				elseif ($serveur == 'connexion_2') {
					$connexion_serveur = $connexion_2;
				}
				elseif ($serveur == 'connexion_3') {
					$connexion_serveur = $connexion_3;
				}
				elseif ($serveur == 'connexion_4') {
					$connexion_serveur = $connexion_4;
				}
				elseif ($serveur == 'connexion_5') {
					$connexion_serveur = $connexion_5;
				}
				elseif ($serveur == 'connexion_6') {
					$connexion_serveur = $connexion_6;
				}
				elseif ($serveur == 'connexion_7') {
					$connexion_serveur = $connexion_7;
				}
				elseif ($serveur == 'connexion_8') {
					$connexion_serveur = $connexion_8;
				}
				elseif ($serveur == 'connexion_9') {
					$connexion_serveur = $connexion_9;
				}
				elseif ($serveur == 'connexion_10') {
					$connexion_serveur = $connexion_10;
				}

				$pseudo = $_SESSION['utilisateur']['user_pseudo'];

				$req = $bdd->prepare('SELECT COUNT(id) FROM boutique WHERE id = :id');
				$req->bindParam(':id', $id, PDO::PARAM_INT, 11);
				$req->execute();
				
				$verifie = $req->fetch(); 
				
				if($verifie[0] > 0) 
				{
					$query = $bdd->prepare ("SELECT * FROM boutique WHERE id = :id");
					$query->bindParam(':id', $id, PDO::PARAM_STR);
					$query->execute();
				
					$res = $query->fetch(PDO::FETCH_OBJ); 
			
						if ($res->id == $id)
						{
							
							$deduction = false;


							?><br />
						<a href="../credit/" class="btn btn-info">Créditer mon compte</a>
						<br /><br />
							<table width="100%"  class="table table-striped">
								<tbody>
									<tr>
										<th>Nom</th>
										<td><?php echo stripcslashes($res->nom); ?></td>
									</tr>
									
									<tr>
										<th>Description</th>
										<td><?php echo stripcslashes($res->description); ?></td>
									</tr>
									
									<tr>
										<th>Prix à payer</th>
										<td>
											<?php
                                     		if($res->prix_promotion == 0){
                                              $prix1 = $res->prix;
                                              $prix = $res->prix;
                                            } else {
                                              $prix1 = '<div style="display:inline;text-decoration: line-through; color: #CD0000;">'.$res->prix.'</div>';
                                              $prix1 .= '<div style="display:inline;color:#0E8600"> '.$res->prix_promotion.'</div>';

                                              $prix = $res->prix_promotion;
                                            }

                                            $payer = $prix;
                                            echo $prix1;
											?>
                                             <img src="../images/gold.png">
                                       </td>
									</tr>
									
									<?php 
									if ($_SESSION['utilisateur']['user_points'] - $payer < 0)
									{
									?>
									<tr>
										<th>Manque</th>
										<td><?php echo $payer - $_SESSION['utilisateur']['user_points'];  ?> <img src="../images/gold.png"></td>
									</tr>
	
									<?php								
									}
									else
									{
									?>
									<tr>
										<th>Solde après achat</th>
										<td><?php echo $_SESSION['utilisateur']['user_points'] - $payer;  ?> <img src="../images/gold.png"></td>
									</tr>
									<?php
									}
									?>
								</tbody>
							</table>
							<?php
							if ($_SESSION['utilisateur']['user_points'] - $payer >= 0)
							{

								echo '<input style="display:none" type="text" value="'.$res->id.'" name="id" id="id">';
								echo '<input style="display:none" type="text" value="'.$serveur.'" name="serveur" id="serveur">';
								echo '<a href="#" class="btn btn-success" onClick="javascript:achat_ajax();" style="float:right;">Acheter</a>';
								echo ' <a href="#" class="btn" data-dismiss="modal" aria-hidden="true" style="float:right; margin-right:15px;">Ne pas acheter</a>';
							}
							else
							{
								$show->showError('Impossible d\'effectuer cet achat, il vous manque '.($payer - $_SESSION['utilisateur']['user_points']).' points.');
							}
			
								echo '<br /><br /><div id="message_id"></div>';
			
			
						}
							
						else
						{
							header ('Location: http://'.$_SERVER['HTTP_HOST'].'/boutique/');
						}
				}
			}
	}
	else
	{
		$show->showError('Vous devez vous connecter afin de pouvoir effectuer cet achat.');	
	}
	echo '</body>';
?>
<?php 
session_start();
 header('Content-type: text/html; charset=utf-8');
 
 /******** Début des ntêtes des données *********/
  require_once('../configuration/configuration.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');
 /******** Fin des entêtes des données *********/

 actualisation_session($bdd);
 $titre = 'Acheter des points boutique';

 include '../inc/head.php';
?>

  <body>
    <div id="page">
      <?php require '../inc/nav.php'; ?>

      <main id="main" class="site-main">

      <?php require '../inc/top.php'; ?>


        <section class="section">
          <div class="container">

            <div class="col-sm-8">
            <?php 
              if(isset($_GET['success']))
              {

                if($_GET['success'] == true)
                {
                  echo '<div class="alert alert-success" style="max-width:1200px; margin-left:auto; margin-right:auto; margin-top:0px;">Paiement validé</div>';
                }
                else
                {
                  echo '<div class="alert alert-danger" style="max-width:1200px; margin-left:auto; margin-right:auto; margin-top:0px;">Paiement refusé</div>';
                }
              }

              if (isset($_SESSION['utilisateur']))
              {
              ?><br><br>
                <?php

                if(isset($_GET['paysafecard']) && isset($_POST['valider'])) {
                  if(!empty($_POST['input1']) && !empty($_POST['input2']) && !empty($_POST['input3']) && !empty($_POST['input4'])) {
                    $i1 = htmlspecialchars($_POST['input1']);
                    $i2 = htmlspecialchars($_POST['input2']);
                    $i3 = htmlspecialchars($_POST['input3']);
                    $i4 = htmlspecialchars($_POST['input4']);

                    $code = "{$i1} {$i2} {$i3} {$i4}";
                    $time = time();

                    $requete = $bdd->prepare('SELECT * FROM historique_paysafecard WHERE code = :code');
                    $requete->bindParam(':code', $code, PDO::PARAM_STR);
                    $requete->execute();

                    if($requete->rowCount() == 0) {
                      $req = $bdd->prepare('INSERT INTO historique_paysafecard(user_pseudo, user_id, code, date_achat) VALUES(:user_pseudo, :user_id, :code, :date_achat)');
                      $req -> bindParam(':user_pseudo', $_SESSION['utilisateur']['user_pseudo'], PDO::PARAM_STR);
                      $req -> bindParam(':user_id', $_SESSION['utilisateur']['user_id'], PDO::PARAM_STR);
                      $req -> bindParam(':code', $code, PDO::PARAM_STR);
                      $req -> bindParam(':date_achat', $time, PDO::PARAM_STR);
                      $req -> execute();

                      $show->showSuccess("Merci de votre achat, nous allons vérifier votre code Paysafecard le plus rapidement possible. Votre compte sera crédité sous 24h.");

                    } else {
                      $show->showError("Ce code Paysafecard a déjà été utilisé.");
                    }

                  } else {
                    $show->showError("Merci de remplir le formulaire.");
                  }
                }

                ?>
               
                <table width="60%" class="table table-striped" style="margin-left:auto; margin-right:auto;">
                   <tr>
                        <td><b>Offre de <?php echo $nombre_points_1; ?> <img src="../images/gold.png" />  </b></td>
                        <td>
                          <center>  <a href="offers.php?offre=<?php echo $idd_1; ?>" class="btn btn-info">Acheter</a>      </center>
                       </td>
                   </tr>
                  
                   <tr>
                        <td><b>Offre de <?php echo $nombre_points_2; ?> <img src="../images/gold.png" />  </b></td>
                        <td>
                           <center> <a href="offers.php?offre=<?php echo $idd_2; ?>" class="btn btn-info">Acheter</a>     </center> 
                       </td>
                   </tr>
                  
                   <tr>
                        <td><b>Offre de <?php echo $nombre_points_3; ?> <img src="../images/gold.png" />  </b></td>
                        <td>
                           <center> <a href="offers.php?offre=<?php echo $idd_3; ?>" class="btn btn-info">Acheter</a>      </center>
                       </td>
                   </tr>


                    <?php
                    if($paypal == true) 
                    {
                    ?>
                      <tr>
                        <td>
                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">

                            <select name="amount" class="form-control">
                                <option value="<?php echo $prix_offre_1;?>"><?php echo $points_offre_1;?></option>
                                <option value="<?php echo $prix_offre_2;?>"><?php echo $points_offre_2;?></option>
                                <option value="<?php echo $prix_offre_3;?>"><?php echo $points_offre_3;?></option>
                                <option value="<?php echo $prix_offre_4;?>"><?php echo $points_offre_4;?></option>
                                <option value="<?php echo $prix_offre_5;?>"><?php echo $points_offre_5;?></option>
                            </select>

                            <input name="currency_code" type="hidden" value="EUR" />
                            <input name="shipping" type="hidden" value="0.00" />
                            <input name="tax" type="hidden" value="0.00" />

                            <input name="return" type="hidden" value="<?php echo ROOTPATH; ?>/credit/?success=true" />
                            <input name="cancel_return" type="hidden" value="<?php echo ROOTPATH; ?>/credit/?success=false" />
                            <input name="notify_url" type="hidden" value="<?php echo ROOTPATH; ?>/credit/ipn_paypal.php" />

                            <input name="cmd" type="hidden" value="_xclick" />
                            <input name="business" type="hidden" value="<?php echo $email_paypal; ?>" />
                            <input name="item_name" type="hidden" value="Achat de <?php echo $name_points; ?> - <?php echo $_SESSION['utilisateur']['user_pseudo'];?>" />
                            <input name="no_note" type="hidden" value="1" />
                            <input name="lc" type="hidden" value="FR" />
                            <input name="bn" type="hidden" value="PP-BuyNowBF" />
                            <input name="custom" type="hidden" value="pseudo=<?php echo $_SESSION['utilisateur']['user_pseudo'];?>" />

                             <img src="../images/gold.png" />  
                            </td>

                            <td>
                            <center>
                              <input alt="effectuez vos paiements via paypal : une solution rapide, gratuite et sécurisée" name="submit" src="../images/buy.png" type="image" style="border:none"/><img src="https://www.paypal.com/fr_fr/i/scr/pixel.gif" border="0" alt="" width="1" height="1" />
                            </center>
                          </form>
                          </td>

                     </tr>
                    <?php
                    }
                    ?>                
              </table>
             <h2>Achetez des crédits avec Paysafecard</h2>
              
              <ol class="breadcrumb">
                Rentrez votre code ci-dessous. Attention, il faut environ 24h pour que votre compte soit crédité. <br> <br>
                <form method="post" action="../credit/?paysafecard">
                  <div class="col-sm-2">
                    <input type="text" class="form-control" name="input1" maxlength="4">
                  </div>                  

                  <div class="col-sm-2">
                    <input type="text" class="form-control" name="input2" maxlength="4">
                  </div>                  

                  <div class="col-sm-2">
                    <input type="text" class="form-control" name="input3" maxlength="4">
                  </div>                  

                  <div class="col-sm-2">
                    <input type="text" class="form-control" name="input4" maxlength="4">
                  </div>

                  <div class="col-sm-3">
                    <button name="valider" class="btn btn-default pull-right" style="margin-right: 20px;"> Valider </button>
                  </div>
                  <div style="clear:both"></div>
                  Merci de ne pas rentrer des codes erronés sous peine de sanction.
                </form>
                <div class="clear"></div>
             </ol>
            <?php
            }
            else
            {
              $show->showError("Vous devez être connecté pour accèder à cette page.");
            }
            ?>
            </div>

            <div class="col-sm-4">
              <?php require '../inc/menu-droite.php'; ?>
            </div>

        </section>
        
      </main>

     <?php require '../inc/footer.php'; ?>
    </div>
  
    <?php require '../inc/query.php'; ?>
  </body>

</html>
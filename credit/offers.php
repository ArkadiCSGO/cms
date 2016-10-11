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
              if (isset($_SESSION['utilisateur']))
              {
                if(isset($_GET['offre'])  && !empty($_GET['offre']))
                {
                $id = intval($_GET['offre']);
                    if($id == $idd_1)
                    {
                      $nombre_points_insert = $nombre_points_1;
                      $offre_nom = 'Offre 1 - '.$nombre_points_1.' points';
                      $error = false;
                    }
                    elseif($id == $idd_2 )
                    {
                      $nombre_points_insert = $nombre_points_2;
                      $offre_nom = 'Offre 2 - '.$nombre_points_2.' points';
                      $error = false;
                    }
                    elseif($id == $idd_3)
                    {
                      $nombre_points_insert = $nombre_points_3;
                      $offre_nom = 'Offre 3 - '.$nombre_points_3.' points';
                      $error = false;
                
                    }
                    else
                    {
                      $error = true;
                      $offre_nom = '';
                    }
                

              ?>
          
                <div class="box-shadow well">
                  <h4><?php echo $offre_nom;?></h4>
                  <?php
                  if($error == false) 
                  {
                    if ($id == $idd_1) 
                    {
                        $_SESSION['type_achat'] = $idd_1;
                    ?>
                        <div id="starpass_<?php echo $idd_1;?>"></div>
                                <script type="text/javascript" src="http://script.starpass.fr/script.php?idd=<?php echo $idd_1;?>&amp;verif_en_php=1&amp;datas=<?php echo $idd_1;?>"></script>
                                
                                <noscript>Veuillez activer le Javascript de votre navigateur s'il vous pla&icirc;t.<br />
                                <a href="http://www.starpass.fr/">Micro Paiement StarPass</a>
                                </noscript>   
                    <?php
                    }
                    if ($id == $idd_2) 
                    {
                    $_SESSION['type_achat'] = $idd_2;
                    ?>
                        <div id="starpass_<?php echo $idd_2;?>"></div>
                                <script type="text/javascript" src="http://script.starpass.fr/script.php?idd=<?php echo $idd_2;?>&amp;verif_en_php=1&amp;datas=<?php echo $idd_2;?>"></script>
                                
                                <noscript>Veuillez activer le Javascript de votre navigateur s'il vous pla&icirc;t.<br />
                                <a href="http://www.starpass.fr/">Micro Paiement StarPass</a>
                                </noscript>
                            
                    <?php
                    }
                    if ($id == $idd_3) 
                    {
                        $_SESSION['type_achat'] = $idd_3;
                    ?>
                        <div id="starpass_<?php echo $idd_3;?>"></div>
                                <script type="text/javascript" src="http://script.starpass.fr/script.php?idd=<?php echo $idd_3;?>&amp;verif_en_php=1&amp;datas=<?php echo $idd_3;?>"></script>
                                
                                <noscript>Veuillez activer le Javascript de votre navigateur s'il vous pla&icirc;t.<br />
                                <a href="http://www.starpass.fr/">Micro Paiement StarPass</a>
                                </noscript>
                            
                    <?php
                  }
                  
                  }
                    else
                    {
                      echo '<div class="alert alert-danger">Offre inconnue</div>';
                    }

                    }
                    else
                    {
                      echo '<div class="alert alert-danger">Offre inconnue</div>';
                    }
                    
                ?>
             
               
          
         </div> 
            <?php } else { $show->showError('Vous devez être connecté afin d\'accèder à cette page.'); } ?>
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
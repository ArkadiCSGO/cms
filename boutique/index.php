<?php 
session_start();
 header('Content-type: text/html; charset=utf-8');
 
 /******** Début des ntêtes des données *********/
  require_once('../configuration/configuration.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');
 /******** Fin des entêtes des données *********/

 actualisation_session($bdd);
 $titre = 'Boutique';
  if(isset($_GET['serveur']) && !empty($_GET['serveur']))
  {
    $serveur_get = intval($_GET['serveur']);

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

  }
  else
  {
    $serveur = 'connexion_1'; 
  }
    

$requete = $bdd->prepare("SELECT DISTINCT(onglet) FROM boutique_onglets");
$requete->execute();


while($resultats = $requete->fetch(PDO::FETCH_OBJ))
{
   if(isset($_GET['items']) && !empty($_GET['items']))
   {
      if($resultats->onglet == $_GET['items'])
      {
        $item_categorie = $resultats->onglet;
      }
   }
   else
   {
    $item_categorie = 'Grades';
   }

}
$requete->closeCursor();

 function boutique($nom, $serveur, $bdd)
   {
       echo '<div class="clear"></div><br>';
       ?>
        <div class="col-lg-12">
         <center><h3><?php echo $nom; ?></h3></center>
          <div>
            <hr>
          </div>
        </div>
       <div class="clear"></div>
       <?php
       $requete = $bdd->prepare("SELECT * FROM boutique WHERE categorie = '".$nom."' AND serveur = '".$serveur."' ORDER BY ordre_id ASC");
       $requete->execute();
       
         while($resultats = $requete->fetch(PDO::FETCH_OBJ)){?>  
          <a href="#Boutique" data-toggle="modal" onClick="request('../boutique/buy_object.php?id=<?php echo $resultats->id; ?>&serveur=<?php echo $resultats->serveur;?>','showBoutique');"> 
          <div class="shop-item">

            <div class="nom-item"> <?php echo stripcslashes($resultats->nom); ?></div>
            <br>
            <center><img src="<?php echo $resultats->image; ?>" height="125"><br></center>
            
            <div class="prix-item">
            <?php
              if($resultats->prix_promotion == 0){
                echo $resultats->prix;
              } else {
                echo '<div style="text-decoration: line-through; color: #CD0000;display: inline;font-size: 15px; top: -20px; position: absolute; left: 20px;">'.$resultats->prix.'</div>';
                echo '<div style="color:#0E8600;display: inline;"> '.$resultats->prix_promotion.'</div>';
              }
            ?>
            </div>
            <br> <br>
            <div class="btn btn-default" href="#" style="float:right; margin-top:-30px;">Acheter</div>

          </div>
          </a>
         <?php
         }
   }
 include '../inc/head.php';
?>

  <body>
    <div id="page">
      <?php require '../inc/nav.php'; ?>

      <main id="main" class="site-main">

      <?php require '../inc/top.php'; ?>


        <section class="section">
          <div class="container">

            <div class="col-sm-12">
                <?php 
                  $btn=1;
                  $requete = $bdd->prepare("SELECT DISTINCT(serveur) FROM boutique_onglets  ORDER BY id ASC");
                  $requete->execute();
                
                  while($resultats = $requete->fetch(PDO::FETCH_OBJ)) { ?>
                    <a href="../boutique/?serveur=<?php echo $btn; ?>" class="btn btn-default"> <?php echo SITE; ?> - Boutique <?php echo $btn; ?></a>
                  <?php $btn++; }?>

                <?php
                if (isset($_SESSION['utilisateur']))
                  {
                ?>
                    <br>Vous avez <?php echo $_SESSION['utilisateur']['user_points']; ?> points boutique 
                    <div class="pull-right"><a href="../credit/" class="btn btn-default">Créditer mon compte</a> </div><br><br>

               <?php
                  }
                ?>
                <br>

                <div class="boutique-corps">
                   <div id="myTabContent" class="tab-content">
                          
                      <?php
                        $requete = $bdd->prepare("SELECT * FROM boutique_onglets WHERE serveur = '".$serveur."' ORDER BY id ASC");
                        $requete->execute();

                           while($resultats = $requete->fetch(PDO::FETCH_OBJ))
                           {
                              boutique(''.$resultats->onglet.'', $serveur, $bdd);
                           }                            
                      ?>
                    </div>
                  </div>
            </div>

        </section>
        
      </main>

       <!-- Boutique -->
      <div class="modal fade" id="Boutique" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Acheter un item sur  <?= SITE; ?></h4>
            </div>
            <div class="modal-body">
          <div id="showBoutique"></div>
        </div>


          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->


     <?php require '../inc/footer.php'; ?>
    </div>
  
    <?php require '../inc/query.php'; ?>
  </body>

</html>
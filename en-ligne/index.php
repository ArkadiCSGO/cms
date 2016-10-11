<?php 
session_start();
 header('Content-type: text/html; charset=utf-8');
 
 /******** Début des ntêtes des données *********/
  require_once('../configuration/configuration.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');
 /******** Fin des entêtes des données *********/

 actualisation_session($bdd);
 $titre = 'Membres connectés';

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
                <?php include ('membres-connectes.php');  ?>
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
<?php 
session_start();
 header('Content-type: text/html; charset=utf-8');
 
 /******** Début des ntêtes des données *********/
  require_once('../configuration/configuration.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');
 /******** Fin des entêtes des données *********/

 actualisation_session($bdd);
 $titre = 'Accueil';

 include '../inc/head.php';
?>

  <body>
    <div id="page">
      <?php require '../inc/nav.php'; ?>
      <main id="main" class="site-main">

      	<?php require '../temp/carousel.php'; ?>

        <section class="section section-center section-cta">
          <div class="container">
            <h2 class="section-title"><span>Qu'attendez-vous ?</span></h2>
            <p>
              <h5> N'attendez plus ! Rejoignez-nous dès maintenant sur <?= SITE; ?> via l'IP suivante : pvp.serveur.fr</h5>
            </p>

            <div class="main-action row">

              <div class="col-lg-2 col-md-3 col-sm-4 col-lg-offset-4 col-md-offset-3 col-sm-offset-2">
                <a href="../creer-un-compte/" class="btn btn-lg btn-block btn-danger">S'inscrire</a>
              </div>

              <div class="col-lg-2 col-md-3 col-sm-4">
                <a data-toggle="modal" data-target="#modal-login" class="btn btn-lg btn-block btn-default"><i class="fa fa-unlock-alt"></i> Se connecter</a>
              </div>

            </div>

          </div>
        </section>

        <section id="features" class="section section-center section-hilite section-features">
          <div class="container">
            <h2 class="section-title"><span>Le serveur <?= SITE; ?> c'est :</span></h2>
            <div class="row">

              <div class="col-md-4 col-sm-6">
                <h4>Fluide, sans lags</h4>
                <p>Pour votre plus grand confort nous avons employé les grands moyens… Notre serveur possède un proccesseur Xeon Et de 1Gbit/s de bande passante!</p>
              </div>

              <div class="col-md-4 col-sm-6">
                <h4>Un staff compétent</h4>
                <p>Marre des serveurs dirigé par des kikoos ? <?= SITE; ?> met à votre disposition un staff mature et compétent! Un problème ? Besoin d’aide ? Un staff sera toujours là pour vous écouter!</p>
              </div>

              <div class="col-md-4 col-sm-6">
                <h4>Sans pomme d'or - sans Cheat</h4>
                <p>Envie de faire du vrai PVP ? Sans vous faire tuer à cause des pommes d’or ou des cheats . <?= SITE; ?> a bloqué les pommes d’or cheat et a un anti-cheat surpuissant ! Jamais vous ne pourrez aussi bien PVP que sur notre serveur!</p>
              </div>

            </div>
          </div>
        </section>


        
      </main>

     <?php require '../inc/footer.php'; ?>
    </div>

    <div class="scroll-to-top" data-spy="affix" data-offset-top="200"><a href="#page" class="smooth-scroll"><i class="fa fa-arrow-up"></i></a></div>
  
    <?php require '../inc/query.php'; ?>
  </body>

</html>
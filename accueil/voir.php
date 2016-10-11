<?php 
session_start();
 header('Content-type: text/html; charset=utf-8');
 
 /******** Début des ntêtes des données *********/
  require_once('../configuration/configuration.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');
 /******** Fin des entêtes des données *********/

 actualisation_session($bdd);
 $titre = 'News';

  if(isset($_GET['new']))
  {
    $new = htmlspecialchars($_GET['new']);
    
    if (stripos($new, ',') !== FALSE) 
    {
      $array = explode(",", $new);
      $new = $array[1];
      $id = intval($new);
    }
    else
    {
      $var = false; 
    }
    
    $requete = $bdd->prepare('SELECT COUNT(id) FROM news WHERE id = :id');
    $requete->bindParam(":id", $id, PDO::PARAM_INT);
    $requete->execute();
    $nombreDeLignes = $requete->fetch(); 
    
    if($nombreDeLignes[0] == 0)
    {
      $var = false; 
    }
    else
    {
      $var = true;  

        $requete = $bdd->prepare("SELECT * FROM news WHERE id = :id");
        $requete->bindParam(":id", $id, PDO::PARAM_INT);
        $requete->execute();
        $new = $requete->fetch(PDO::FETCH_OBJ);
    }
    $requete->closeCursor();
  }
  else
  {
    $var = false;
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

            <div class="col-sm-8">
              <?php
              if($var == true)
              {
              ?>
                  <h3><?php echo stripcslashes ($new->titre); ?></h3>
                      <p>
                        <?php echo nl2br($new->texte); ?>
                      </p>

                      <div class="margin-50"></div>
                        <?php
                        $req = $bdd->prepare ('SELECT * FROM commentaires WHERE id_new = :id_new ORDER BY id ASC');
                        $req -> bindParam(':id_new', $id);
                        $req->execute();
                        ?>
                        <h4 class="titre"><?php echo $req->rowCount(); ?> commentaire(s)</h4>
                        <hr>
                        <?php
                        if($req->rowCount() == 0)
                        {
                          $show->showError("Aucun commentaire trouvé pour cette construction.");
                        }
                        else
                        {
                          while($commentaire = $req->fetch(PDO::FETCH_OBJ))
                          {
                            ?>
                          <div class="message">
                            <div class="pull-left">
                              <img src="http://cravatar.eu/avatar/<?php echo $commentaire->user_pseudo; ?>/64.png" class="img-circle img-avatar">
                            </div>

                            <div class="pull-after">
                            Par 
                              <a href="../profil/<?php echo ($commentaire->user_pseudo);?>">
                                <b><?php echo $commentaire->user_pseudo; ?></b>
                              </a>
                             
                             <br>
                            <?php echo nl2br($commentaire->texte); ?>

                            <br>
                            <div class="pull-right">le <?php echo date('d/m/Y à H:i', $commentaire->date);?></div>
                            </div>

                          </div>
                            <?php
                          }
                        }

                        $req->closeCursor();
                        ?>
                        <br>
                        <?php
                        if(!isset($_SESSION['utilisateur']))
                        {
                          $show->showError("Vous devez être connecté pour rajouter un commentaire.");
                        }
                        else
                        {
                          if(isset($_POST['envoyer']))
                          {
                              $_SESSION['erreurs'] = 0;

                              $message = htmlspecialchars($_POST['message']);
                              $message_result = checkText($message);

                                  if($message_result == 'toolong')
                                  {
                                      $_SESSION['description_info'] = "Le message est limité à 1500 caractères. <br/>";
                                      $_SESSION['erreurs']++; 
                                  }                                  
                                  elseif($message_result == 'tooshort')
                                  {
                                      $_SESSION['description_info'] = "Le message doit contenir au minimum 5 caractères. <br/>";
                                      $_SESSION['erreurs']++; 
                                  }
                                  else
                                  {
                                    $_SESSION['description_info'] = '';
                                  }

                            if($_SESSION['erreurs'] == 0)
                            {
                              $date = time();
                              

                              $req = $bdd->prepare('INSERT INTO commentaires(id_new, titre_new, user_pseudo, date, texte) VALUES(:id_new, :titre_new, :user_pseudo, :date, :texte)');
                              $req -> bindParam(':id_new', $id);
                              $req -> bindParam(':titre_new', $new->titre);
                              $req -> bindParam(':user_pseudo', $_SESSION['utilisateur']['user_pseudo']);
                              $req -> bindParam(':date', $date);
                              $req -> bindParam(':texte', $message);
                              $req -> execute();

                              $show->showSuccess("Message envoyé");

                            }
                            else
                            {
                              $show->showError($_SESSION['description_info']);
                            }
                          }
                          ?>
                          <hr>
                          <h4>Envoyer un commentaire</h4>
                          <hr>

                          <form method="post">
                            <i>Par <?php echo $_SESSION['utilisateur']['user_pseudo']; ?> le <?php echo date('d/m/Y', time()); ?></i><br><br>
                            <textarea class="form-control" name="message"></textarea>
                            <br>

                            <center>
                              <input type="submit" class="btn btn-default" name="envoyer" value="Envoyer mon commentaire"> 
                            </center>
                          </form>

                          <?php
                        }
                        ?>
              <?php
              }
              else
              {
                $show->showError("La nouvelle demandée est introuvable");
              }
              ?>
             
            </div>

            <div class="col-sm-4">
              <?php require '../inc/menu-droite-news.php'; ?>        
            </div>


          </div>

        </section>
        
      </main>

     <?php require '../inc/footer.php'; ?>
    </div>
  
    <?php require '../inc/query.php'; ?>
  </body>

</html>
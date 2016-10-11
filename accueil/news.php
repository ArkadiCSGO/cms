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

 include '../inc/head.php';
 define('PAGE_PER_NO', 12);

 function getPagination($count)
 {
     $paginationCount= floor($count / PAGE_PER_NO);
     $paginationModCount= $count % PAGE_PER_NO;
     if(!empty($paginationModCount))
     {
         $paginationCount++;
     }
     return $paginationCount;
 }

?>

  <body>
    <div id="page">
      <?php require '../inc/nav.php'; ?>

      <main id="main" class="site-main">

      <?php require '../inc/top.php'; ?>


        <section class="section">
          <div class="container">

            <div class="col-sm-8">
              <div class="">
                
                  <div id="pageData">

                    <?php

                    $id = 0;

                    $pageLimit= PAGE_PER_NO * $id;
                    
                    $query = $bdd->prepare ('SELECT * FROM news');
                    $query->execute();

                    $count = $query->rowCount();
                    $query->closeCursor();
                    $paginationCount=getPagination($count);


                    $query = $bdd->prepare('SELECT * FROM news ORDER BY id DESC LIMIT ' . $pageLimit . ', ' . PAGE_PER_NO . '');
                    $query->execute(); 

                      while($results = $query->fetch(PDO::FETCH_OBJ))
                      { 
                        $req = $bdd->prepare ('SELECT * FROM commentaires WHERE id_new = :id_new ORDER BY id ASC');
                        $req -> bindParam(':id_new', $results->id);
                        $req->execute();
                      ?>           
                          <div class="">
                            
                            <h3><?php echo stripcslashes ($results->titre); ?></h3>
                            <p>
                               <?php echo nl2br($results->texte); ?>
                            </p>

                            <a href="../new/<?php echo slug($results->titre).','.$results->id; ?>" class="btn btn-default">
                              <i class="fa fa-file-text-o"></i> Lire la suite
                            </a>

                             <div class="btn btn-alert"><?php echo $req->rowCount();?> commentaire(s)</div>
                          
                          </div> 

                          <div class="col-sm-12 news-date">
                            
                            <div class="col-sm-8">
                               <i class="fa fa-calendar"></i> le <?php echo date('d/m/Y à H:i', $results->date); ?>
                            </div>

                            <div class="col-sm-4">
                              <img src="http://cravatar.eu/avatar/<?php echo $results->auteur;?>/24.png" class="avatar">
                              Par <?php echo $results->auteur; ?>
                            </div>
                          </div> 

                          <br><hr>
                          <br><hr>               
                    <?php
                    }
                    $query->closeCursor();
                    ?>

                  </div>

                <?php

                    echo '<br><br>';
                    echo '<ul class="tsc_pagination tsc_paginationC tsc_paginationC01">';
                        
                        echo '<li class="first link" id="first">';
                            echo '<a  href="javascript:void(0)" onclick="changePagination(\'0\',\'first\')">Première</a>';
                        echo '</li>';


                      for($i=0;$i<$paginationCount;$i++)
                      {        
                        echo '<li id="'.$i.'_no" class="link">';
                          echo '<a  href="javascript:void(0)" onclick="changePagination(\''.$i.'\',\''.$i.'_no\')">'.($i+1).'</a>';
                        echo '</li>';
                      }
                               
                      echo '<li class="last link" id="last">';
                        echo '<a href="javascript:void(0)" onclick="changePagination(\''.($paginationCount-1).'\',\'last\')">Dernière</a>';
                      echo '</li>';

                      echo '<li class="flash"></li>';
                    echo '</ul>';
                  ?>

              </div>
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
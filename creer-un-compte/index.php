<?php 
session_start();
 header('Content-type: text/html; charset=utf-8');
 
 /******** Début des ntêtes des données *********/
  require_once('../configuration/configuration.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');
 /******** Fin des entêtes des données *********/

 actualisation_session($bdd);
 $titre = 'Créer un compte';

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
              <div class="alert alert-warning">
                <i class="fa fa-info-circle"></i> Tous les champs doivent être remplis.
              </div>
                          <?php
                                if (isset($_POST['inscription_b'])) {
                                    $_SESSION['erreurs'] = 0;
                                     
                                    //Pseudo
                                    if(isset($_POST['pseudo']))
                                    {
                                        $pseudo = trim($_POST['pseudo']);
                                        $pseudo = htmlentities($pseudo, ENT_NOQUOTES, 'utf-8');
                                        $pseudo = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $pseudo);
                                        $pseudo = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $pseudo); // pour les ligatures e.g. '&oelig;'
                                        $pseudo = str_replace(';', '', $pseudo); 
                                        $pseudo = str_replace('.php', '', $pseudo); 
                                        $pseudo = str_replace(' ', '', $pseudo); 

                                        $pseudo_result = checkpseudo($pseudo, $bdd);
                                        if($pseudo_result == 'tooshort')
                                        {
                                            $_SESSION['pseudo_info'] = '- Le pseudo '.htmlspecialchars($pseudo, ENT_QUOTES).' est trop court, vous devez en choisir un plus long (minimum 3 caract&egrave;res).<br/>';
                                            $_SESSION['form_pseudo'] = '';
                                            $_SESSION['erreurs']++;
                                        }
                                         
                                        else if($pseudo_result == 'toolong')
                                        {
                                            $_SESSION['pseudo_info'] = '- Le pseudo '.htmlspecialchars($pseudo, ENT_QUOTES).' est trop long, vous devez en choisir un plus court (maximum 32 caract&egrave;res).<br/>';
                                            $_SESSION['form_pseudo'] = '';
                                            $_SESSION['erreurs']++;
                                        }
                                         
                                        else if($pseudo_result == 'exists')
                                        {
                                            $_SESSION['pseudo_info'] = '- Le pseudo '.htmlspecialchars($pseudo, ENT_QUOTES).' est d&eacute;jà pris, choisissez-en un autre.<br/>';
                                            $_SESSION['form_pseudo'] = '';
                                            $_SESSION['erreurs']++;
                                        }
                                             
                                        else if($pseudo_result == 'ok')
                                        {
                                            $_SESSION['pseudo_info'] = '';
                                            $_SESSION['form_pseudo'] = $pseudo;
                                        }
                                         
                                        else if($pseudo_result == 'empty')
                                        {
                                            $_SESSION['pseudo_info'] = '- Vous n\'avez pas entr&eacute; de pseudo.<br/>';
                                            $_SESSION['form_pseudo'] = '';
                                            $_SESSION['erreurs']++; 
                                        }
                                    }
                                     
                                    else
                                    {
                                        header('Location: ../index.php');
                                        exit();
                                    }
                                     
                                    if(isset($_POST['mdp']))
                                    {
                                        $mdp = trim($_POST['mdp']);
                                        $mdp_result = checkmdp($mdp, '');
                                        if($mdp_result == 'tooshort')
                                        {
                                            $_SESSION['mdp_info'] = '- Le mot de passe entr&eacute; est trop court, changez-en pour un plus long (minimum 4 caract&egrave;res).<br/>';
                                            $_SESSION['form_mdp'] = '';
                                            $_SESSION['erreurs']++;
                                        }
                                         
                                        else if($mdp_result == 'toolong')
                                        {
                                            $_SESSION['mdp_info'] = '- Le mot de passe entr&eacute; est trop long, changez-en pour un plus court. (maximum 50 caract&egrave;res)<br/>';
                                            $_SESSION['form_mdp'] = '';
                                            $_SESSION['erreurs']++;
                                        }
                                             
                                        else if($mdp_result == 'ok')
                                        {
                                            $_SESSION['mdp_info'] = '';
                                            $_SESSION['form_mdp'] = $mdp;
                                        }
                                         
                                        else if($mdp_result == 'empty')
                                        {
                                            $_SESSION['mdp_info'] = '- Vous n\'avez pas entr&eacute; de mot de passe.<br/>';
                                            $_SESSION['form_mdp'] = '';
                                            $_SESSION['erreurs']++;
                                     
                                        }
                                    }
                                     
                                    else
                                    {
                                        header('Location: ../index.php');
                                        exit();
                                    }
                                     
                                    if(isset($_POST['mdp_verif']))
                                    {
                                        $mdp_verif = trim($_POST['mdp_verif']);
                                        $mdp_verif_result = checkmdpS($mdp_verif, $mdp);
                                        if($mdp_verif_result == 'different')
                                        {
                                            $_SESSION['mdp_verif_info'] = '- Le mot de passe de v&eacute;rification diff&egrave;re du mot de passe.<br/>';
                                            $_SESSION['form_mdp_verif'] = '';
                                            $_SESSION['erreurs']++;
                                            if(isset($_SESSION['form_mdp'])) unset($_SESSION['form_mdp']);
                                        }
                                         
                                        else
                                        {
                                            if($mdp_verif_result == 'ok')
                                            {
                                                $_SESSION['form_mdp_verif'] = $mdp_verif;
                                                $_SESSION['mdp_verif_info'] = '';
                                            }
                                             
                                            else
                                            {
                                                $_SESSION['mdp_verif_info'] = str_replace('passe', 'passe de v&eacute;rification', $_SESSION['mdp_info']);
                                                $_SESSION['form_mdp_verif'] = '';
                                                $_SESSION['erreurs']++;
                                            }
                                        }
                                    }
                                     
                                    else
                                    {
                                        header('Location: ../compte/inscription.php');
                                        exit();
                                    }
                                     
                                    if(isset($_POST['mail']))
                                    {
                                        $mail = trim($_POST['mail']);
                                        $mail_result = checkmail($mail, $bdd);
                                        if($mail_result == 'isnt')
                                        {
                                            $_SESSION['mail_info'] = '- Le mail '.htmlspecialchars($mail, ENT_QUOTES).' n\'est pas valide.<br/>';
                                            $_SESSION['form_mail'] = '';
                                            $_SESSION['erreurs']++;
                                        }
                                         
                                        else if($mail_result == 'exists')
                                        {
                                            $_SESSION['mail_info'] = '- Le mail '.htmlspecialchars($mail, ENT_QUOTES).' est d&eacute;jà utilis&eacute;<br/>';
                                            $_SESSION['form_mail'] = '';
                                            $_SESSION['erreurs']++;
                                        }
                                             
                                        else if($mail_result == 'ok')
                                        {
                                            $_SESSION['mail_info'] = '';
                                            $_SESSION['form_mail'] = $mail;
                                        }
                                         
                                        else if($mail_result == 'empty')
                                        {
                                            $_SESSION['mail_info'] = '- Vous n\'avez pas entr&eacute; de mail.<br/>';
                                            $_SESSION['form_mail'] = '';
                                            $_SESSION['erreurs']++; 
                                        }
                                    }
                                     
                                    else
                                    {
                                        header('Location: ../index.php');
                                        exit();
                                    }

                                    if($_POST['captcha'] == $_SESSION['captcha'] && isset($_POST['captcha']) && isset($_SESSION['captcha']))
                                    {
                                        $_SESSION['captcha_info'] = '';
                                    }
                                     
                                    else
                                    {
                                        $_SESSION['captcha_info'] = '- Vous n\'avez pas recopi&eacute; correctement le contenu de l\'image.<br/>';
                                        $_SESSION['erreurs']++;
                                    }
                                    
                                    unset($_SESSION['captcha']);
                      

                      if($_SESSION['erreurs'] == 0)
                      {
                        $md5 = md5($mdp);
                        $time = time();


                            $req = $bdd->prepare('INSERT INTO joueurs(user_pseudo, user_mdp, user_mail, user_inscription, user_derniere_visite) VALUES(:user_pseudo, :user_mdp, :user_mail, :user_inscription, :user_derniere_visite)');
                            $req -> bindParam(':user_pseudo', $pseudo, PDO::PARAM_STR);
                            $req -> bindParam(':user_mdp', $md5, PDO::PARAM_STR);
                            $req -> bindParam(':user_mail', $mail, PDO::PARAM_STR);
                            $req -> bindParam(':user_inscription', $time, PDO::PARAM_STR);
                            $req -> bindParam(':user_derniere_visite', $time, PDO::PARAM_STR);
                            $req -> execute();
                        
                          $requete = $bdd->prepare('SELECT * FROM joueurs WHERE user_pseudo = :user_pseudo');
                          $requete->bindParam(':user_pseudo', $pseudo, PDO::PARAM_STR);
                          $requete->execute();
                          $reponse = $requete->fetch();
                          $_SESSION['utilisateur'] = $reponse;

                          echo '<meta http-equiv="refresh" content="3;URL=../accueil/">';
                          
                          $show->showSuccess("Votre inscription est bien validée !");
                      }
                      else
                      {
                        $show->showError($_SESSION['pseudo_info'].$_SESSION['mdp_info'].$_SESSION['mdp_verif_info'].$_SESSION['mail_info'].$_SESSION['captcha_info']);                    
                      }
                    } 
                    ?>
                                
                                
                  <form action="#" method="post" name="Inscription">
                  
                    <fieldset>
                                        
                    <div class="form-row">
                        <input type="text" name="pseudo" placeholder="Nom d'utilisateur" class="form-control" style="width: 650px;" id="pseudo" size="30" onKeyUp="verifPseudo(this.value)" value="<?php if($_SESSION['pseudo_info'] == '') echo htmlspecialchars($_SESSION['form_pseudo'], ENT_QUOTES) ; ?>"/>
                         <em> (plus de 3 caract&egrave;res)</em>
                    </div>

                      <br />

                    <div class="form-row">
                        <input type="password" placeholder="Mot de passe" name="mdp" id="mdp" size="30" value="<?php if($_SESSION['mdp_info'] == '') echo htmlspecialchars($_SESSION['form_mdp'], ENT_QUOTES) ; ?>"  class="form-control" style="width: 650px;"/> 
                        <em> (plus de 4 caract&egrave;res)</em>
                    </div>

                      <br />

                    <div class="form-row">
                        <input type="password" placeholder="Vérification" class="form-control" style="width: 650px;" name="mdp_verif" id="mdp_verif" size="30" value="<?php if($_SESSION['mdp_verif_info'] == '') echo htmlspecialchars($_SESSION['form_mdp_verif'], ENT_QUOTES) ; ?>" />
                    </div>
                                        
                      <br />

                    <div class="form-row">
                      <input type="text" placeholder="Adresse e-mail" class="form-control" style="width: 650px;" name="mail" id="mail" size="30" value="<?php if($_SESSION['mail_info'] == '') echo htmlspecialchars($_SESSION['form_mail'], ENT_QUOTES) ; ?>" />
                    </div>
                    
                    <br />

                    <?php $_SESSION['captcha'] = ChaineAleatoire(5); ?>
                      
                      <div style="position:relative;">
                         <i class="fa fa-refresh" onclick="appelPHP()" style="cursor:pointer; position:relative; top: 15px;"></i>

                         <div id="resultatAppel" style="display:inline;"><img src="../captcha/captcha.png.php?PHPSESSID=<?php echo session_id(); ?>" style="cursor:pointer; position:relative; top:11px;"/></div>
                        </div>
                        <br />

                      <div class="form-row">
                          <input type="text" name="captcha" id="captcha" placeholder="Captcha" class="form-control" style="width: 200px;" />
                      </div>
                                        

                    <br />

                    <input type="submit" class="btn btn-default" name="inscription_b" value="Je confirme">   

                    </fieldset>
                  
                  </form>
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
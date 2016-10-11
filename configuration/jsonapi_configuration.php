            <?php
                    // Ajout du fichier JSONAPI
                    require_once ("JSONAPI.php");
                      
                    ####### A CONFIGURER CMS
                    $var_salt_1 = "192.168.1.1"; // cryptage
                    $var_ip_1 = "25009";
                    $var_user_1 = "mon_user";
                    $var_mdp_1 = "456445456";
                    $var_port_1 = "";
                    ####### A CONFIGURER
                      
                    $connexion_1 = new JSONAPI($var_ip_1, $var_port_1, $var_user_1, $var_mdp_1, $var_salt_1);
                      
                    $server1 = $connexion_1->call("getPlayerCount"); 
                    $server1_limit = $connexion_1->call("getPlayerLimit"); 
            ?>
            
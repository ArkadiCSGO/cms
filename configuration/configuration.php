<?php
    // Ne pas toucher
    define("ROOTPATH", "http://".$_SERVER["HTTP_HOST"]."", true);
    $ip = $_SERVER["REMOTE_ADDR"];
    // Ne pas toucher

    // Remplacer Samant par le nom de votre site
    define("SITE", "SamantCMS", true);
    define("JSONAPI", "0", true); // 0 : fermé / 1 : ouvert
    define("NombreServeur", "1", true); // nombre de serveur

    $skype = "antoine.bourlart"; // skype du modérateur
    $ip_serveur = "192.0.0.8"; // IP serveur
    $description = "Bienvenue sur mon site !"; // description sur la page accueil

    /*************************************************************************/
    /************************** SYSTEME DE VOTE  *****************************/
    /*************************************************************************/  
    $rpgURL = ""; 

    /*************************************************************************/
    /************* BOUTIQUE - Modifications des images - Bug *****************/
    /*************************************************************************/  

    $largeur_image = "60"; // la largeur des images dans la boutique en pixels
    $longueur_image = "100"; // la longueur des images dans la boutique en pixels

    /*************************************************************************/
    /************* SYSTEME JSONAPI CONNEXION /!\ ATTENTION /!\   *************/
    /*************************************************************************/  
    if (JSONAPI == 1) 
    { 
        include("../configuration/jsonapi_configuration.php");
    }

    /*******************************************************************/
    /************* SYSTEME DE PAIEMENT /!\ ATTENTION /!\   *************/
    /*******************************************************************/  

        include ("../configuration/starpass.php");


    /**********************************/
    /************* PAYPAL *************/
    /**********************************/  

    include ("../configuration/paypal.php");
?>
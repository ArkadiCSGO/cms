<?php
/** Connection a la base de donnée **/
   
    try
    {
      $bdd = new PDO("mysql:host=;dbname=", "", "");
      $bdd->exec("SET NAMES utf8");
    }
    catch (Exception $e)
    {
      die($e->getMessage());
    }   


?>
<?php

// Login info pour la connexion à la bdd
$DB_DSN="mysql:host=localhost;dbname=rec";
$DB_USER="root";
$DB_PASS="";

/*
La fonction suivante va nous permettre de vérifier l'integrité des données
trim() est une fonction qui permet de supprimer les espaces blancs du début et de la fin
stripslashes() permet de suprrimer les anti-slashes pour éviter les attaques des pirates
htmlspecialchars() va permettre de passer les caractères spéciaux comme < ou > autant que des caractères html pour éviter les failles XSS et les injections de Javascript 
*/

function valid_data($donnee)
{
  $donnee=trim($donnee);
  $donnee=stripslashes($donnee);
  $donnee=htmlspecialchars($donnee);
  return $donnee;
}

?>

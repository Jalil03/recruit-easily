<?php
require('database.php');
include('../cand/util.php');
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
    //cette variable pour ajouter les messages d'erreur	
    $message='';
     
if(isset($_POST['submit']))
{
      //On vérifie si le mot de passe entré est valide 
      //si ils ne sont pas identique on affiche un message d'erreur
  if($_POST['password']!=$_POST['password2']) 
        $message='<div class="alert alert-danger">The password entered does not match</div>';
      //si les mot de passe sont identiques on va vérifier si l'email entré existe déjà
  else
  {
      $rq=$conn->prepare('select * from user where email=?');
      $rq->execute(array($_POST['email']));
      //Si on trouve que l'email existe déjà on va notifier l'utilisateur
      if($rq->rowCount()!=0)
        {
         $message='<div class="alert alert-danger">email deja existe!</div>';
        }  
      //Si les mots de passe entrés sont identiques et l'email n'existe pas on va passer ici
      else
      {  
      //on démarre une nouvelle session
       init_php_session();
      //on va récuperer le domaine du candidat car on aura besoin de cette donnée dans la page suivante
      $_SESSION['domaine']=$_POST['domaine'];

      //requête préparée qui va nous permettre d'inserer les données dans la table user
      $rq=$conn->prepare('insert into user (email,password,id_type_user) values (?,?,2) ');
       /*
       après avoir insérer les données dans la table user on doit récupérer son identifiant.
       on le récupère pour pouvoir l'utiliser lorsqu'on insère le reste de ses données dans la table candidat
       */
        $rq3=$conn->prepare('select id_user from user where email=?');
       $rq->execute(array(valid_data($_POST['email']),valid_data($_POST['password'])));
       $rq3->execute(array(valid_data($_POST['email'])));
       $dossier='../cand/cv/';
       $temp_name=$_FILES['cv']['tmp_name'];
       $infocv=pathinfo($_FILES['cv']['name']);
       $exten=$infocv['extension'];
       $exten=strtolower($exten);
       $nomcv=uniqid().'.'.$exten;
       move_uploaded_file($temp_name,$dossier.$nomcv);
       $id=$rq3->fetch()['id_user'];
       //requête préparée qui va nous permettre d'insérer les données dans la table candidat
       $rq2=$conn->prepare('insert into candidat (id_candidat,nom,prenom,email_contact,num_tel,id_domaine,id_poste,cv) values (?,?,?,?,?,?,?,?) ');
       $_SESSION['id']=$id;
       
       $rq2->execute(array($id,valid_data($_POST['lastname']),valid_data($_POST['firstname']),valid_data($_POST['contactEmail']),valid_data($_POST['number']),$_POST['domaine'],$_POST['poste'],$nomcv));
      
      //on envoie l'utilisateur vers la page register-cand-comp.php si tout va correctement
      header('Location:up-can.php');
      }
  }
}
?>

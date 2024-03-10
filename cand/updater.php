<?php
session_start();
$message='';
include('database.php');
if(isset($_POST['submit'])){
  
    //On vérifie si le mot de passe entré est valide 
  //si ils ne sont pas identique on affiche un message d'erreur
$rq2=$PDO->prepare('select password from user where id_user=?');
$rq2->execute(array($_SESSION['id']));
$pass=$rq2->fetch()['password'];
if($pass!=$_POST['oldpassword'])
$message='<div class="alert alert-danger">The old password is incorrect</div>';
else if($_POST['password']!=$_POST['password2']) 
$message='<div class="alert alert-danger">The password entered does not match</div>';
//si les mot de passe sont identiques on va vérifier si l'email entré existe déjà

else
{
$rq=$PDO->prepare('select * from user where email=? and id_user!=?');
$rq->execute(array($_POST['email'],$_SESSION['id']));
//Si on trouve que l'email existe déjà on va notifier l'utilisateur
if($rq->rowCount()!=0)
{
$message='<div class="alert alert-danger">email deja existe!</div>';
}
else{
if(!empty($_POST['password']) && !empty($_POST['password2'])){
$rq=$PDO->prepare('update user set password=? where id_user=?');
$rq->execute(array($_POST['password'],$_SESSION['id']));
}
$rq=$PDO->prepare('update user set email=? where id_user=?');
$rq->execute(array($_POST['email'],$_SESSION['id']));
$rq=$PDO->prepare('UPDATE recruteur set nom_societe=? ,email_societe=?,num_tel=?,site=? WHERE id_recruteur=?');
$rq->execute(array($_POST['companyname'],$_POST['compEmail'],$_POST['compTel'],$_POST['website'],$_SESSION['id']));
header('location:profilrec.php');
}
}
}

?>
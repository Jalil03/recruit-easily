<?php
//la partie de la connexion
try{
    $conn = new PDO("mysql:host=localhost;dbname=rec;port=3306;charset=utf8", 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }catch(Exception $e){
    echo $e->getMessage();
    }
    //cette variable pour ajouter les messages d'erreur	
    $message='';
    
    if(isset($_POST['submit'])){
      session_start();
      //Pour vérifier si les deux mots de passes sont identiques   
      if($_POST['password']!=$_POST['password2']) 
        // S'il ne le sont pas on affiche un message d'erreur
      $message='<div class="alert alert-danger">vous devez matcher les password!</div>';
      else{
      //Si les mots de passe sont identiques on doit vérifier l'email  
      $rq=$conn->prepare('select * from user where email=?');
      $rq->execute(array($_POST['email']));
        // si on trouve que l'email est déjà existant on doit l'informer
      if($rq->rowCount()!=0){
        $message='<div class="alert alert-danger">email deja existe!</div>';
      }  
     else{  
      // Si l'email n'existe pas dans la bdd on va insérer l'utilisateur
    
   
    $rq=$conn->prepare('insert into user (email,password,id_type_user) values (?,?,1) ');//bach inserer l user
    $rq->execute(array($_POST['email'],$_POST['password']));
    $rq3=$conn->prepare('select * from user where email=? and id_type_user=1');//bach n3arfo iduser li khda bach ninseriwh f la table candida f id_candidat
    $rq3->execute(array($_POST['email']));
    $ligne=$rq3->fetch();
    $_SESSION['id']=$ligne['id_user'];
    $_SESSION['type_user']=$ligne['id_type_user'];
    $rq2=$conn->prepare('insert into recruteur (id_recruteur,nom_societe,email_societe,num_tel,site) values (?,?,?,?,?)');//bach ninseriw f la table candidat
    $rq2->execute(array($_SESSION['id'],$_POST['companyname'],$_POST['compEmail'],$_POST['compTel'],$_POST['website']));
    header('location:up-rec.php');// Pour le rediriger vers la page d'upload d'image
     }
    }
     }
?>
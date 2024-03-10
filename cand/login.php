<?php
 require('database.php');
 require('util.php');
 init_php_session();
 if(isset($_SESSION['id'])){
  header('location:dashboard.php');
}
   /*
   D'abord on doit vérifier si l'utilisateur a bien remplit tout les champs
   */
  $msg='';
   if(isset($_POST['valid_connection']))
      if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['form_password']) && !empty($_POST['form_password']))
      {
        // on récupère l'email et le mot de passe
        $email=$_POST['email'];
        $password=$_POST['form_password'];

        //verification de l'existance de l'utilisateur
         // préparation de la requête et l'execution
          $sth = $PDO->prepare("SELECT * FROM user WHERE email = :email");
          $sth->bindValue(':email',$email);
          $sth->execute();
        // on stocke les données qu'on a recupéré 
          $row = $sth->fetch(PDO::FETCH_ASSOC);

        // si on a trouvé :
        if($row)
        {
          // si le mot de passe entré est le même que celui qu'on a dans la base de données
          if($password == $row['password'])
          {
            // on démarre une session
           init_php_session(); // (la définition de la fonction est dans util.php)
           //on recupère des données et on les stockes grâce à la variable superglobale $_SESSION
           $_SESSION['id']=$row['id_user'];
           $_SESSION['email']=$email;
           $_SESSION['type_user']=$row['id_type_user'];
           // envoyer l'utilisateur à la page dashboard.php 
           header("Location:dashboard.php");
          }
          else
          {
            /* il ne faut pas indiquer à l'utilisateur quel champ il a mal entré à cause de raisons de sécurité, du coup on lui indique qu'il une faute quelque part
            sans préciser où exactement 
            */ 
           $msg='Invalid email or password';
          }
        }
        else{
            $msg='User not found';
        }
      }
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .acc:hover{
           
            color: darkslateblue !important;
        }
        .acc{
            text-decoration:none;
            color:black;
        }
        
        
    </style>
  <meta charset="UTF-8">
  <title>Home page</title>
  <link  rel="stylesheet" href="style2.css">
</head>
<body>
      <div class="container">
          <div class="logo"><a href="../index.php"><img src="../images/logoW.jpg" alt="logo du site techjob" width="100px" height="auto"></a></div>
      </div>
      
<div class="conteneur">
  <div class="row">
      <div>
         <img src="avatar2.png" alt="mascot du site" width="auto" height="500px">
      </div>
      <div class="col">
      <h2>Login</h2>
      <form action="login.php" method="POST" class="ms-5 mt-3">
        <div class="field">
          <label for="email">Email:</label><br>
          <input type="text" name="email" id="email" placeholder="username">
        </div>
        <div class="field">
          <label for="email">Password:</label><br>
          <input type="password" name="form_password" placeholder="password">
        </div>
        <?php  echo '<span>'.$msg.'</span>'   ?>
        
        
        <div class="field sub">
          <input type="submit" name="valid_connection" value="Login" class="button">
          <p ><a  class="acc" href="../register/form_candidat.php">Click here to create an account</a><p>
        </div> 
      </form>
      </div>
      <div>
         <img src="avatar.png" alt="mascot du site" width="auto" height="500px">
      </div>
  </div>
</div>
      
</body>
</html>

<?php 

require('util.php');
require('database.php');
init_php_session();
if(isset($_GET['id'])){
    $main_id = $_GET['id'];
    $sql_update = "UPDATE msg SET status = 1 WHERE id_message = '$main_id'";
    $PDO->query($sql_update);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<style>
  html {
    height: 100%;
}
  
  body{
   
    height: 100%;
    margin: auto;
   
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-repeat: no-repeat ;
    color: #050642 ;
}
nav{
    background-color: white;
  
}
table {
            background-color: transparent;
            border-radius: 10px;
            box-shadow: 5px 5px 10px gray;
            width: 100%; /* Ajout de la largeur */
            margin-top: 20px; /* Ajout de la marge supérieure */
            margin-bottom: 20px; /* Ajout de la marge inférieure */
            border-collapse: separate; /* Séparation des bordures de cellules */
            border-spacing: 0 15px; /* Espacement vertical entre les cellules */
        }


th,td {
    color:#37b7e1;
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-size:25px;
    padding: 15px;
   }
   td{
    font-size:20px;
   }
   footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa; /* Changez la couleur de fond selon vos préférences */
            padding: 20px 0; /* Ajoutez un peu d'espacement si nécessaire */
        }
   .b{
    background-color: #050642 ;
    width: 120px;
    height: auto;
    padding:9px 12px;
    border: none;
    border-radius: 20px;
    color: white;
    margin-top: 10px;
    
    font-weight: 500;
    font-size: medium;
    cursor: pointer;
}
a{color: #37b7e1;
  text-decoration: none;
}
a:hover{
  color: #37b7e1;
  text-decoration:none;
}
.b:hover{
  background-color: #050642 ;
  opacity:0.7;
}
.navbar-brand{
    color:#37b7e1;
}

.logo{
    position: relative;
    left: 10px;
}
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>

<nav class="navbar bg-white">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="../images/logoW.jpg" width="70" height="70" alt="logo" class="img rounded-circle" >
       Recruit Easily
    </a>
</nav>


<div class=" container-fluid">
    

<div class="section-tittle text-center">
                <h2 class="mt-5">"Elevate Your Opportunities, Transform Your Career!"</h2>
                </div>
                <a href="dashboard.php"><button type="submit" class="btn btn-lg b rounded"> <i class="fa-solid fa-backward" style="color: #ffffff;"></i> BACK</button></a>
  </div>
 


<div class="container mt-5">
    <table class="table   mt-7">
  <thead>
    <tr>
     
      <th scope="col">Offer From   </th>
      <th scope="col">Date</th>
      <th scope="col">Messages</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $i=1;
 $sql1 = $PDO->prepare('SELECT * FROM msg WHERE status = 1 and id_candidat=? ');
$sql1->execute([$_SESSION['id']]); 
 while($result =$sql1->fetch()) :?>
    <tr>
      
      <td> <?php
     $sql = $PDO->prepare('SELECT * FROM msg,recruteur WHERE  msg.id_recruteur= recruteur.id_recruteur and msg.id_recruteur=?');
      $sql->execute([$result['id_recruteur']]); 
     $ligne =$sql->fetch();
     $sql2= $PDO->prepare('select * from offre WHERE id_recruteur=? LIMIT 0,1');
      $sql2->execute([$result['id_recruteur']]); 
     $ligne1=$sql2->fetch();
     
     ?>
     <a style="color:#37b7e1;" href="info_offre.php?id=<?=$ligne1['id_offre']?>" ><?=$ligne['nom_societe']?></a>

      </td> 
      <td><?=$result['cr_date']?></td>
      <td><?=$result['messages']?></td>
     
      <td><a href="delete.php?id=<?= $result['id_message']?>" ><i class="fa-solid fa-trash" style="color: #f9535b;"></i></a></td>
    </tr>
   <?php endwhile ?>
 
  </tbody>
</table>

    </div>

    
    <footer>


<div class="footer-bottom">
    <div class="footer-bottom bg-white">
    <div class="row align-items-center">
        <div class="col-md-3 text-center">
            <a class="navbar-brand" href="#">
                <img src="../images/logoW.jpg" width="70" height="70" alt="link" class="img rounded-circle">
                Recruit Easily
            </a>
        </div>
        <div class="col-md-4 text-center">
            <p class="mb-2">Copyright ©2024 RECUIT EASILY. Designed by <span>ANAHA</span></p>
        </div>
    </div>
</div>

    </div>


</footer>
</body>

</html>

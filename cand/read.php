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
    width: 90%;
    height: 100%;
    margin: auto;
    background-image: linear-gradient(to top,#050642,#e94873,#e94873,#050642,black);
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-repeat: no-repeat ;
    color:white;
}
nav{
    background-color: white;
    margin-top:10px;
    border-radius:20px;
    box-shadow: 5px 5px 10px gray;
    margin:none;
}
 table{
  background-color:transparent;
  border-radius:10px;
  box-shadow: 5px 5px 10px gray;
 }

th,td {
    color:white;
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-size:25px;
   }
   td{
    font-size:20px;
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
    box-shadow: 1px 1px 2px gray;
    font-weight: 500;
    font-size: medium;
    cursor: pointer;
}
a{
  text-decoration: none;
}
a:hover{
  color: black !important;
  text-decoration: underline;
}
.b:hover{
  background-color: #050642 ;
  opacity:0.7;
}
   
</style>


</head>

<body>

<nav id="navb" class="navbar navbar-expand-lg "  >
        <div class="container  ">
        <a class="navbar-brand" href="../index.php"><img  class="logo" src="../images/logoW.jpg" height="60px" width="100px" alt="link" class="img"></a>
</div>  
</nav>
<div class="container mt-5">
    <table class="table   mt-5">
  <thead>
    <tr>
      <th scope="col">S.not</th>
      <th scope="col">Company name</th>
      <th scope="col">Messages</th>
      <th scope="col">Date</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $i=1;
 $sql1 = $PDO->prepare('SELECT * FROM msg WHERE status = 1 and id_candidat=? ');
$sql1->execute([$_SESSION['id']]); 
 while($result =$sql1->fetch()) :?>
    <tr>
      <th scope="row"><?= $i++?></th>
      <td> <?php
     $sql = $PDO->prepare('SELECT * FROM msg,recruteur WHERE  msg.id_recruteur= recruteur.id_recruteur and msg.id_recruteur=?');
      $sql->execute([$result['id_recruteur']]); 
     $ligne =$sql->fetch();
     $sql2= $PDO->prepare('select * from offre WHERE id_recruteur=? LIMIT 0,1');
      $sql2->execute([$result['id_recruteur']]); 
     $ligne1=$sql2->fetch();
     
     ?>
     <a style="color:white;" href="info_offre.php?id=<?=$ligne1['id_offre']?>" ><?=$ligne['nom_societe']?><a/>

        
      </td>
      <td><?=$result['messages']?></td>
      <td><?=$result['cr_date']?></td>
      <td><a href="delete.php?id=<?= $result['id_message']?>" ><img src="litter.png"></a></td>
    </tr>
   <?php endwhile ?>
 
  </tbody>
</table>

    </div>
<div class="container">
    <a href="dashboard.php"><button type="submit" class="btn b mt-5">BACK</button></a>
</div>
    
   
</body>

</html>

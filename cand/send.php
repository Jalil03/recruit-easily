<?php
require_once('util.php');
init_php_session();
 $_SESSION['id_can'];
require_once("database.php");

if(isset( $_POST['send']))
{
 $id_can=$_SESSION['id_can'];
 $id_rec= $_SESSION['id'];
 $message=$_POST['message'];
 $date =date('y-m-d h:i:s');

$sql=$PDO->prepare('INSERT INTO msg (id_candidat,id_recruteur,messages,cr_date) VALUES (?,?,?,?)');
$sql->execute([$id_can, $id_rec,$message,$date]);
if($sql) echo" <script> alert('message send successfully');</script>";

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

body{
    width: 90%;
    margin:auto;
  background-color: white;
}
nav{
    background-color: white;
    
   
   
}

 .a{
    width: 50%;
    height: 400px;
    box-shadow: 5px 5px 10px gray;
    background-color: white;
    padding:5px;
    text-align:center;
    margin-left:250px;
    border-radius:20px;
 }
textarea{
    width: 80%;
    height: 80%;
    border: 2px solid #050642;
    border-radius:15px;
    box-shadow: 5px 5px 5px 5px rgb(221, 212, 212);
}
label{
    color:#050642;
    font-size:30px;
    font-family: Georgia, 'Times New Roman', Times, serif;
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


 
 .b:hover{
  background-color: #050642 ;
  opacity:0.7;
}
.cc{
text-align:center;
margin-right: 45px;
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
<nav class="navbar  bg-white">
    <a class="navbar-brand" href="#">
      <img src="..\images\logoW.jpg" width="70" height="70" alt="link" class=" img rounded-circle" >
       Recruit Easily
    </a>
    
</nav>

<div class=" container-fluid">
    

<div class="section-tittle text-center">
                <h3 class="mt-5">"Unlock Potential, Embrace Talent: Send Offers, Shape Futures!"</h3>
                </div>
                <a href="dashboard.php"><button type="submit" class="btn btn-lg b rounded"> <i class="fa-solid fa-backward" style="color: #ffffff;"></i> BACK</button></a>
  </div>



 <div class="container mt-5">
    <div class="a">
    <form method="post" action="send.php">
    <div class="col">
  <label for="floatingTextarea2" class="mt-5"> Enter your message</label>
  <textarea class=" mt-3" cols="50" rows="13" name="message" placeholder="Tape your message here" id="floatingTextarea2" style="height:100px"></textarea>
</div>
  <button type="submit" name="send" class="btn danger b mt-5">Send <i class="fa-regular fa-paper-plane" style="color: #ffffff;"></i></button>
</form>
</div>
  
<br>
</div>
    <div class="bg-white"> <br></div>
<footer>


<div class="footer-bottom">
    <div class="footer-bottom">
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
<?php
include('updatec.php');
$rq=$PDO->prepare('select * from candidat,user where  candidat.id_candidat=user.id_user and candidat.id_candidat=?');
$rq->execute(array($_SESSION['id']));
$info=$rq->fetch();
if(!isset($_SESSION['id'])){
   header('location:login.php');
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
	<link rel="stylesheet" href="styleupdc.css">
	
</head>
<body>
<nav id="navb" class="navbar navbar-expand-lg " >
        <div class="container ">
        <a class="navbar-brand" href="../index.php"><img  class="logo" src="../images/logoW.jpg" height="60px" width="100px" alt="link" class="img"></a>
   </div> 
	</nav>
<main>
	<form action="form_update_can.php" method="post" name="form1">
<div class="container">
	<div class="col">
	<h1> Step 1</h1>
		  <h2>Upadate your login info:</h2>
		 
		  
          <div class="champ1">
             <label for="username">Username:</label><br>
             <input value="<?=$info['prenom']?>" type="text" name="username" id="username"  required maxlength="20" placeholder="username">
          </div>
          <div class="champ1">
             <label for="email">Email:</label><br>
             <input value="<?=$info['email']?>" type="email" name="email" id="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="email">
          </div>
          <div class="champ1">
             <label for="oldpassword">Old Password:</label><br>
             <input type="password" name="oldpassword" id="oldpassword" required placeholder="Old password">
          </div>
          <div class="champ1">
             <label for="password">New Password:</label><br>
             <input type="password" name="password" id="password"  minlength="6" placeholder="New password">
          </div>
          <div class="champ1">
             <label for="password2">Re-enter your password:</label><br>
             <input type="password" name="password2" id="password2"  placeholder="password">
          </div>
		 
		  <h1> Step 2</h1>
	
		   <div class="champ"> 
	         <h2>Update your Personal information:</h2>
		   </div>
		   <div class="champ">
             <label for="firstname">First name:</label><br>
             <input value="<?=$info['prenom']?>"  type="text" name="firstname" id="firstname" required maxlength="20" placeholder="First name">
           </div>
		   <div class="champ">
             <label for="lastname">Last name:</label><br>
             <input value="<?=$info['nom']?>" type="text" name="lastname" id="lastname" required maxlength="20" placeholder="Last name">
           </div>
		   <div class="champ">
             <label for="contactEmail">Contact email:</label><br>
             <input value="<?=$info['email_contact']?>" type="email" name="contactEmail" id="contactEmail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required placeholder="Email">
           </div>
		   <div class="champ">
			 <label for="telephone">Telephone number:</label><br>
		     <input value="<?=$info['num_tel']?>" type="tel" name="number" id="telephone" placeholder="Telephone">
		   </div>
		   
		</div>
	</div>
   
	<div class="button">
    <?php echo $message ?>
	  <button name="submit" type="submit" class="btn" >Update</button>
	</div>

</form>
 <img src="../register/avatar4.png"  class="a" alt="">
</main>
</body>
</html>

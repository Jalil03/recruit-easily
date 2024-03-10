<?php
include('updater.php');
$rq=$PDO->prepare('select * from recruteur,user where  recruteur.id_recruteur=user.id_user and recruteur.id_recruteur=?');
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
    <link rel="stylesheet" href="styleupdc.css">
    <title>Sign up</title>
</head>
<body>
<nav id="navb" class="navbar navbar-expand-lg " >
        <div class="container ">
        <a class="navbar-brand" href="../index.php"><img  class="logo" src="../images/logoW.jpg" height="60px" width="100px" alt="link" class="img"></a>
   </div> 
	</nav>
<main>
	<form action="from_update_rec.php" method="post">
       <div class="container ">
		
		 <div class="col">
      <h1>Step 1</h1>
		  <h2 class="">Upadate your login info:</h2>
          <div>
            <label for="username">Username:</label><br>
            <input value="<?=$info['nom_societe']?>" type="text" name="username" id="username">
          </div>
          <div>
            <label for="email">Email:</label><br>
            <input value="<?=$info['email']?>" type="email" name="email" id="email">
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
          <h1>Step 2</h1>
			<h2 class="mb-5">Update your Company information:</h2>
			<div class="mb-2">
             <label for="companyname">Company name:</label><br>
             <input  value="<?=$info['nom_societe']?>" type="text" name="companyname" id="companyname">
            </div>
			 <div class="mb-2">
             <label for="compEmail">Company email:</label><br>
             <input value="<?=$info['email_societe']?>" type="email" name="compEmail" id="compEmail">
           </div>
		   <div class="mb-2">
            <label for="compTel">Company telephone:</label><br>
            <input  value="<?=$info['num_tel']?>" type="tel" name="compTel" id="compTel">
           </div>
		   <div class="mb-2 ">
			<label for="website">Company website:</label><br>
			<input value="<?=$info['site']?>" type="url" name="website" id="website">
		   </div>
      
		 </div>
		
     <div class="button">
     <?php echo $message ?>
	  <button name="submit" type="submit" class="btn">Update</button>
	</div>
    
</div>
       
    </form>
    
</main>
<img src="avatar3.png"  class="b " alt="">
</body>
</html>

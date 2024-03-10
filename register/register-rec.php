<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Sign up</title>
    <?php
      include('addrec.php');
    ?>
</head>
<body>
<nav id="navb" class="navbar navbar-expand-lg " >
        <div class="container ">
        <a class="navbar-brand" href="../index.php"><img  class="logo" src="../images/logoW.jpg" height="60px" width="100px" alt="link" class="img"></a>
   </div> 
	</nav>
<main>
	<form action="register-rec.php" method="post">
       <div class="container ">
		
		 <div class="col">
      <h1>Step 1</h1>
		  <h2 class="">Enter your login info:</h2>
          <div>
            <label for="username">Username:</label><br>
            <input type="text" name="username" id="username">
          </div>
          <div>
            <label for="email">Email:</label><br>
            <input type="email" name="email" id="email">
          </div>
          <div>
            <label for="password">Password:</label><br>
            <input type="password" name="password" id="password">
          </div>
          <div>
            <label for="password2">Password Again:</label><br>
            <input type="password" name="password2" id="password2">
          </div>
          <h1>Step 2</h1>
			<h2 class="mb-5">Company information:</h2>
			<div class="mb-2">
             <label for="companyname">Company name:</label><br>
             <input type="text" name="companyname" id="companyname">
            </div>
			 <div class="mb-2">
             <label for="compEmail">Company email:</label><br>
             <input type="email" name="compEmail" id="compEmail">
           </div>
		   <div class="mb-2">
            <label for="compTel">Company telephone:</label><br>
            <input type="tel" name="compTel" id="compTel">
           </div>
		   <div class="mb-2 ">
			<label for="website">Company website:</label><br>
			<input type="url" name="website" id="website">
		   </div>
      
		 </div>
		
     <div class="button">
	  <?php  echo $message ?><!-- Si il y a une erreur on va l'afficher -->  
	  <button name="submit" type="submit" class="btn">Register</button>
	</div>
    
</div>
       
    </form>
    
</main>
<img src="avatar3.png"  class="b " alt="">
</body>
</html>

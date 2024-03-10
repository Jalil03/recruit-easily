<!-- Si onchoisit candidat on est derige vers cette page apres on serra derige a reg-cand-comp -->

<?php require('adduser.php'); 
	?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
	<link rel="stylesheet" href="style.css">
	
</head>
<body>
<nav id="navb" class="navbar navbar-expand-lg " >
        <div class="container ">
        <a class="navbar-brand" href="../index.php"><img  class="logo" src="../images/logoW.jpg" height="60px" width="100px" alt="link" class="img"></a>
   </div> 
	</nav>
<main>
	<form action="register-cand.php" method="post" name="form1" enctype="multipart/form-data">
<div class="container">

	<div class="col">
	<h1> Step 1</h1>
		  <h2>Enter your login info:</h2>
		 
		  
          <div class="champ1">
             <label for="username">Username:</label><br>
             <input type="text" name="username" id="username"  required maxlength="20" placeholder="username">
          </div>
          <div class="champ1">
             <label for="email">Email:</label><br>
             <input type="email" name="email" id="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="email">
          </div>
          <div class="champ1">
             <label for="password">Password:</label><br>
             <input type="password" name="password" id="password" required minlength="6" placeholder="password">
          </div>
          <div class="champ1">
             <label for="password2">Re-enter your password:</label><br>
             <input type="password" name="password2" id="password2" required placeholder="password">
          </div>
		 
		  <h1> Step 2</h1>
	
		   <div class="champ"> 
	         <h2>Personal information:</h2>
		   </div>
		   <div class="champ">
             <label for="firstname">First name:</label><br>
             <input type="text" name="firstname" id="firstname" required maxlength="20" placeholder="First name">
           </div>
		   <div class="champ">
             <label for="lastname">Last name:</label><br>
             <input type="text" name="lastname" id="lastname" required maxlength="20" placeholder="Last name">
           </div>
		   <div class="champ">
             <label for="contactEmail">Contact email:</label><br>
             <input type="email" name="contactEmail" id="contactEmail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required placeholder="Email">
           </div>
		   <div class="champ">
			 <label for="telephone">Telephone number:</label><br>
		     <input type="tel" name="number" id="telephone" placeholder="Telephone">
		   </div>
		   <div class="champ">
			 <label for="poste">Desired Position:</label><br>
             <select name="poste" id="poste">
				<option value="1">Technician</option>
				<option value="2">Engineer</option>
				<option value="3">Doctor/professor</option>
			 </select>
		   </div>
		   <div class="champ">
		     <label for="domaine">Domaine:</label><br>
             <select name="domaine" id="domaine">
				<option value="1">Cybersecurity</option>
				<option value="2">Web development</option>
				<option value="3">Mobile development</option>
				<option value="4">Machine Learning</option>
				<option value="5">Data science</option>
				<option value="6">Business intelligence</option>
				<option value="7">System administration</option>
				<option value="8">Network administration</option>
			 </select>	

		   </div>
		   <div class="champ">
		   <label class="lfi" for="nom_du_fichier">Choisir CV :</label><br>
		   <input class="file" type="file" name="cv" accept=".pdf">
		   

</div>
		</div>
	</div>

	<div class="button">
	  <?php  echo $message ?><!-- Si il y a une erreur on va l'afficher -->
	  <button name="submit" type="submit" class="btn" >Register</button>
	</div>

</form>
 <img src="avatar4.png"  class="a" alt="">
</main>
</body>
</html>

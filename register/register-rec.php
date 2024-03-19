<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../stylerecruteur.css">
    <title>Sign up</title>
    <?php
      include('addrec.php');
      // cette page est lorsque le recruteur veut creer un compte pour la premiere fois , on va utiliser le addrec
    ?>
</head>
<body>
<div class="logo-container">
    <a class="logo-link" href="../index.php"><img class="logo" src="../images/logoW.jpg" height="60px" width="100px" alt="link"></a>
</div>

<main>
    <form action="register-rec.php" method="post">
        <div class="container">
            <div class="col">
                <h1>Step 1</h1>
                <h2 class="champ">Enter your login info:</h2>
                <div class="champ">
                    <label for="username">Username:</label><br>
                    <input type="text" name="username" id="username"placeholder="Username">
                </div>
                <div class="champ">
                    <label for="email">Email:</label><br>
                    <input type="email" name="email" id="email"placeholder="Email">
                </div>
                <div class="champ">
                    <label for="password">Password:</label><br>
                    <input type="password" name="password" id="password"placeholder="password">
                </div>
                <div  class="champ">
                    <label for="password2">Password Again:</label><br>
                    <input type="password" name="password2" id="password2"placeholder="Password Again">
                </div>
            </div>
            <div class="col">
                <h1>Step 2</h1>
                <h2 class="champ">Company information:</h2>
                <div class="champ">
                    <label for="companyname">Company name:</label><br>
                    <input type="text" name="companyname" id="companyname"placeholder="Company name">
                </div>
                <div class="champ">
                    <label for="compEmail">Company email:</label><br>
                    <input type="email" name="compEmail" id="compEmail"placeholder="Company email:">
                </div>
                <div class="champ">
                    <label for="compTel">Company telephone:</label><br>
                    <input type="tel" name="compTel" id="compTel"placeholder="Company telephone">
                </div>
                <div class="champ ">
                    <label for="website">Company website:</label><br>
                    <input type="url" name="website" id="website"placeholder="Company website">
                </div>
            </div>
        </div>

        <div class="register-button">
            <?php echo $message ?><!-- Si il y a une erreur on va l'afficher -->
            <button name="submit" type="submit" class="btn">Register</button>
        </div>
    </form>
</main>


</body>
</html>

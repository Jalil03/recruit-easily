<!DOCTYPE html>
<!-- La page qui s'affiche lorsque le user clic sur sign up  --><html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="style1.css" rel="stylesheet">
    <title>Sign up</title>
    <style>
        .up {
            height: fit-content;
            margin: 0;
            width: 100%;
            margin-bottom: 20px;
            background-color: white;
        }
        
        .logo {
            padding: 20px 0 10px 50px;
        }
        
        body {
            background-color: rgb(243, 241, 241);
        }
        
        .recruit-text {
            color: navy; 
        }
    </style>
</head>
<body>
    <div class="up">
        <a class="navbar-brand" href="../index.php"><img class="logo" src="../images/logoW.jpg" height="100px" width="auto" alt="link" class="img"></a>
    </div>
    
    <div class="a">
        <h1>Welcome abroad <span class="recruit-text">Recruit easily </span></h1>
        <h3 class="tit">First, tell us what your role is ?</h3>
        <div class="container justify-content-center">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-4 col-sm-12 cand mb-3 box">
                    <a href="register-cand.php">
                        <img src="../enterprise.png" alt="icône candidat" height="auto" width="200px">
                        <h3 class="cand1">I'am a candidat</h3>
                    </a>
                </div>
                <div class="col-lg-5 col-md-4 col-sm-12 rec mb-3 box">
                    <a href="register-rec.php">
                        <img src="../cv1.png" alt="icône recruteur" height="auto" width="300px">
                        <h3 class="tit">I'am a recruiter</h3>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

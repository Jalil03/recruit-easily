<?php
if(isset($_SESSION['id'])){
    header('location:dsq.php');
  }
require('./cand/util.php');
if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=="logout")
{
 // on arrête la session (voir la définition de la fonction dans le fichier util.php)
 clean_php_session(); 
 // puis on redirect l'utilisateur vers la page d'accueil
 header("Location:./cand/login.php"); 
 exit();
}

?>
<html>  
<head>  
    
    <title>PHP login system</title>  
<!--     <link rel="stylesheet" href="../bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<!-- <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"> -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
  
</head>  
<body> 
    <button
    type="button"
    class="btn btn-danger btn-floating btn-lg"
    id="btn-back-to-top"
    >
<i class="fas fa-arrow-up"><img width="30px" src="./images/up.png" alt="" srcset=""></i>
</button> 
    <nav id="navb" class="navbar navbar-expand-lg ">
        <div class="container-fluid">
        <a class="navbar-brand" href="#"><img  class="logo" src="./images/logoW.jpg" height="60px" alt="link" class="img"></a>
          <div class="btnnav">
          <a href="./cand/login.php"> 
          <button id="btn">
                Login
                <span></span><span></span><span></span><span></span>
              </button></a> 
              <a href="./register/form_candidat.php"><button id="btn1">
                Sign in
                <span></span><span></span><span></span><span></span>
              </button></a>
        </div> 
    </div> 
      </nav>
      <div class="slider-area ">
        <!-- Mobile Menu -->
        <div class="slider-active">
            <div id="head1" class="single-slider slider-height d-flex align-items-center" >
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-9 col-md-10">
                            <div class="hero__caption">
                                <h1>Find the most exciting startup jobs</h1>
                            </div>
                        </div>
                    </div>
                    <!-- Search Box -->
                    <div class="row">
                        <div class="col-xl-8">
                            
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
   <!--La partie des catégories du site -->
  <div class="ContainerCat">
        <div class="title">
                <div class="section-tittle text-center">
                <h2 class="mt-5">Browse Top Categories</h2>
                </div>
        </div>
        <div class="boxContainer">
            <div class="box shadow-sm mb-5 bg-white rounded">
                <div id="cs" class="text-center img2">
                    <img  src="./images/cyber-security.png" alt="" width="25%" height="auto">
                    <h5 class="mt-3">Cyber security</h5>
                  </div>
            </div>
            <div class="box shadow-sm mb-5 bg-white rounded">
                <div class="text-center img2">
                    <img  src="./images/devweb.png" alt="" width="25%">
                    <h5 class="mt-3">Web Development</h5>
                  </div>
            </div>
            <div class="box shadow-sm  mb-5 bg-white rounded">
                <div class="text-center img2">
                    <img  src="./images/devmob.png" alt="" width="25%">
                    <h5 class="mt-3">Mobile Development</h5>
                  </div>
            </div>
            <div class="box shadow-sm  mb-5 bg-white rounded">
                <div class="text-center img2">
                    <img  src="./images/ai.png" alt="" width="25%">
                    <h5 class="mt-3">Machine Learning</h5>
                  </div>
            </div>
            <div class="box shadow-sm  mb-5 bg-white rounded">
                <div class="text-center img2">
                    <img  src="./images/datascience.png" alt="" width="25%">
                    <h5 class="mt-3">Data Science</h5>
                  </div>
            </div>
            <div class="box shadow-sm  mb-5 bg-white rounded">
                <div class="text-center img2">
                    <img  src="./images/businessint.png" alt="" width="25%">
                    <h5 class="mt-3">Business Intelligence</h5>
                  </div>
            </div>
            <div class="box shadow-sm  mb-5 bg-white rounded">
                <div class="text-center img2">
                    <img  src="./images/admin.png" alt="" width="25%">
                    <h5 class="mt-3">System Administration</h5>
                  </div>
            </div>
            <div class="box shadow-sm  mb-5 bg-white rounded">
                <div class="text-center img2">
                    <img  src="./images/computer.png" alt="" width="25%">
                    <h5 class="mt-3">Network Administration</h5>
                  </div>
            </div>
        </div>
    </div> 
    <!--Partie où on parle des fonctionnalités du site -->
    <div id="info" class="pb-5">
     <div class="container ">
        
       <div class="title">
        <div class="section-tittle text-center">
            <h2 class="mt-5">How our website works</h2>
        </div>
       </div>
       <div class="row justify-content-center mb-5">
        <div data-aos="fade-down" class="col-3 boxs me-5 ">
          <div  class="text-center pt-4">
              <div class="img-container">
              <img  src="./images/job.png"   alt="" srcset="" width="30%">
          </div>
              <h5 class="mt-3 text-white">1. Search a job</h5>
              <p>You can easily find your dream job that matches your skills and experience level in any IT field !</p>
        </div>
        </div>
        <div data-aos="fade-down" class="col-3 boxs me-5">
          <div class="text-center pt-4">
              <div class="img-container">
              <img  src="./images/job-description.png" alt="" srcset="" width="30%">
          </div>
              <h5 class="mt-3 text-white">2.Apply for job</h5>
              <p>Applying for a job is very easy ! Just make an account, fill in your personal information then start applying!</p>
        </div>
        </div>
        <div data-aos="fade-down" class="col-3 boxs me-5">
          <div class="text-center  pt-4">
              <div class="img-container">
              <img  src="./images/recruitment (1).png" alt="" srcset="" width="30%">
          </div>
              <h5 class="mt-3 text-white">3. Get your job</h5>
              <p>Get contacted by recruiters directly and get hired for your dream job!</p>
        </div>
        </div>
     </div>
  </div>
</div>
      
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="section-tittle text-center">
                <h2 class="mt-5">Our service is free of charge !</h2>
                </div>
        </div>
</div>
      <div class="row align-items-center slider-area">
        <div   data-aos="zoom-in-down" class="col-7 hero__caption">
           
            <h1>Our service is completely free and available for all users</h1>
       
        </div>
        <div  data-aos="zoom-in-left" class="col-5">
            <img src="./images/avatar.png" alt="avatar" srcset="" width="500px">
        </div>
      </div>
</div>
<footer>
    <div class="contenu-footer">
      <div class="block">
          <h3>Nos services</h3>
              <p> Publish your offer</p>
              <p> Candidate for an offer</p>
      </div>
      <div class="block ">
          
              <h3>Nos contacts</h3>
          <div class="services text-white">
              <p>+212 608086188</p>
              <p>supportcondidat@contact.com</p>
              <p>444 S.Casablanca Settat</p>
          </div>
          
      </div>
      <div class="block">
          <h3>Nos réseaux</h3>
          <ul class="listemedia ">
              <li><a href="#"><img src="./images/facebook-new.png" alt="icones réseaux sociaux" ></a></li>
              <li><a href="#"><img src="./images/icons8-twitter-circled-48.png" alt="icones réseaux sociaux" ></a></li>
              <li><a href="#"><img src="./images/instagram-new.png" alt="icones réseaux sociaux" ></a></li>
              <li><a href="#"><img src="./images/icons8-linkedin-circled-48.png" alt="icones réseaux sociaux" ></a></li>
             
          </ul>
      </div>
  
    </div>
    <div class="footer-bottom">
      <p>copyright &copy;2023 Techjob . Designed by<span>neuthunt</span></p>
    </div>
  </footer>
<script src="index.js"></script>
<script>
    AOS.init();
  </script>  
</body>     
</html>  

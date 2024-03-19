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
  <link rel="stylesheet" href="../bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    
<link rel="stylesheet" href="styleN.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-l7D/XRzj4a5J2IKPJf6zRJW6lXuhBQi+fTSlX0EiK0eH7Dxuufo9Ie1lhPsjN0Fh" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<!-- <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"> -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
</head>  
<body> 
<nav class="navbar bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="./images/logoW.jpg" width="70" height="70" alt="link" class=" img rounded-circle" >
       Recruit Easily
    </a>
    <div class="btnnav">
          <a href="#contact"> 
          <button id="btn">
              Contact Us
                <span></span><span></span><span></span><span></span>
              </button></a> 
  </div>
</nav>







<div class="slider-area ">

        <!-- Mobile Menu -->
        <div class="slider-active">
            <div id="backg1" class="single-slider d-flex align-items-center">
                
                </div>
            </div>
        </div>
    </div>
   
<!-- login -->
  
 <div class="container text-center mt-2">
 <div class="section-tittle text-center">
                <h2 class="mt-5">Get RecruitEasily!Get Your Job!</h2>
                </div>
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <a href="./cand/login.php" id="btn" class="btn btn-lg btn-block">
                Login
            </a> 
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <a href="./register/form_candidat.php" id="btn1" class="btn btn-lg btn-block">
                Sign in
            </a>
        </div>
    </div>
</div>
<div class="container"><div class="row align-items-center slider-area">
    <div data-aos="zoom-in-down" class="col-7 hero__caption">
        <h1>What are you waiting for ? Get your Job Now</h1>
        <p class="text-dark" id="about">
            "If you're a recruiter or a candidate,
            struggling to find compatible job offers
            matching your aspirations, 
            Recruit Easily is your solution.
            Unlike other job portals, here,
            you set your selection criteria."
        </p>
    </div>
    <div data-aos="zoom-in-left" class="col-5">
       <video id="myVideo" src="./images/videorr.mp4"  alt="tutorial" width="500px" height="300px" controls autoplay></video>
    </div>
</div></div>



 
       

<!-- div qui contient les temoin -->


<div class="container-fluid " id="temoin">
        <div id="info3" class="pb-5">
       <div class="title">
        <div class="section-tittle text-center">
            <h2 class="mt-5">Get your Job Now</h2>
        </div>
        </div>
   

    <div class="container testimonial-container">
    <div class="row">
    <div class="col">
            <div class="card">
                <img src="./images/rec1.png"  width="70" height="70" alt="link" class=" img rounded-circle">
                <div class="card-body">
                    <h5 class="card-title">Ahmed kamil</h5>
                    <p class="card-text" id="testimonial">"Grâce à Recruit Easily, j'ai trouvé les meilleurs talents pour mon entreprise.Le processus de recrutement a été simplifié et efficace."</p>
                </div>
            </div>
        </div>
       
        <div class="col">
            <div class="card">
                <img src="./images/profile.png"  width="70" height="70" alt="link" class=" img rounded-circle">
                <div class="card-body">
                    <h5 class="card-title">Rayan Benhmed</h5>
                    <p class="card-text" id="testimonial">"J'ai trouvé un emploi qui correspond parfaitement à mes compétences et à mes aspirations professionnelles.
                        RecruitEasily"</p>
                </div>
            </div>
        </div>
      
        <div class="col">
            <div class="card">
                <img src="./images/rec2.jpeg"  width="70" height="70" alt="link" class=" img rounded-circle">
                <div class="card-body">
                    <h5 class="card-title">karim Boujabale</h5>
                    <p class="card-text" id="testimonial">"Grâce à Recruit Easily,
                         j'ai trouvé les meilleurs talents pour 
                         mon entreprise. Le processus de recrutement
                          a été simplifié et efficace."</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="./images/profile.png"  width="70" height="70" alt="link" class=" img rounded-circle">
                <div class="card-body">
                    <h5 class="card-title">Jalil Bellingham</h5>
                    <p class="card-text" id="testimonial">"Grâce à Recruit Easily, 
                        j'ai trouvé les meilleurs candidats pour mon entreprise. Le processus de recrutement a été simplifié et efficace et gratuit ."</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="./images/profile.png"  width="70" height="70" alt="link" class=" img rounded-circle">
                <div class="card-body">
                    <h5 class="card-title">Hanan Skitioui</h5>
                    <p class="card-text" id="testimonial">"Grâce à Recruit Easily, 
                        j'ai trouvé les meilleurs talents pour mon entreprise. Le processus de recrutement a été simplifié et efficace."</p>
                </div>
            </div>
        </div>
        </div>
        </div>
      
</div>

</div>
 </div>
</div>


       

<footer>
    <div class="contenu-footer">
      <div class="block">
          <h3>Our services</h3>
              <p> FIND A JOB </p>
              <p> FIND THE PERFECT RECRUIT </p>
              <p></p>
      </div>
      <div id="contact" class="block ">
          
              <h3 > contact us</h3>
          <div class="services text-white">
              <p>+212 608086188</p>
              <p>recruitEasily@support.com</p>
              <p>Casablanca</p>
          </div>
          
      </div>
      <div class="block">
          <h3>Social media</h3>
          <ul class="listemedia ">
              <li><a href="#"><img src="./images/facebook-new.png" alt="icones réseaux sociaux" ></a></li>
              <li><a href="#"><img src="./images/icons8-twitter-circled-48.png" alt="icones réseaux sociaux" ></a></li>
              <li><a href="#"><img src="./images/instagram-new.png" alt="icones réseaux sociaux" ></a></li>
         </ul>
      </div>
  
    </div>
    <div class="footer-bottom">
    <div class="footer-bottom">
    <div class="row align-items-center">
        <div class="col-md-3 text-center">
            <a class="navbar-brand" href="#">
                <img src="./images/logoW.jpg" width="70" height="70" alt="link" class="img rounded-circle">
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


         
<script src="index.js"></script>
<script>
    AOS.init();
  </script>  

<script>
    window.onload = function() {
      var video = document.getElementById("myVideo");
      video.play();
    };
  </script>

</body>     
</html>  

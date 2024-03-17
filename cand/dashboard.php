<?php

// cette dashbord est pour le candidat et le recrutteur on difference entre eux avec le id_user;

require('util.php');
require('database.php');
init_php_session();
if(!isset($_SESSION['type_user']))
$_SESSION['type_user']=2; // 2 pour type user candidat 

// Pour se deconnecter :  
if(!isset($_SESSION['id'])){
  header('location:login.php');
}

// Pour le filtre :

$requete = "select * from candidat,domaine,poste where candidat.id_poste=poste.id_poste and candidat.id_domaine=domaine.id_domaine ORDER BY score desc";
// retrieve distinct countries from the database
$stmt = $PDO->prepare($requete);
$stmt->execute();
$candidats = $stmt->fetchAll(PDO::FETCH_ASSOC);


$stmt = $PDO->prepare("SELECT * FROM domaine");
$stmt->execute();
$domaines = $stmt->fetchAll(PDO::FETCH_ASSOC);


$stmt = $PDO->prepare("SELECT * FROM poste");
$stmt->execute();
$postes = $stmt->fetchAll(PDO::FETCH_ASSOC);


if($_SERVER['REQUEST_METHOD'] === 'POST')
{    
   $requete = "select * from candidat,domaine,poste where candidat.id_poste=poste.id_poste and candidat.id_domaine=domaine.id_domaine";
    $dom = $_POST['domaine'];
    $pos = $_POST['position'];
    if($dom != 0)
    {
      $requete .= " and candidat.id_domaine= :idd";  
    }
    if($pos != 0)
    {
      $requete .= " and candidat.id_poste=:idp";
    }
    $requete .= " ORDER BY score DESC";
    $stmt = $PDO->prepare($requete);
   if($dom != 0 )
    $stmt->bindParam(':idd',$dom);
   if($pos != 0)
    $stmt->bindParam(':idp',$pos);
   
    $stmt->execute();
    $candidats = $stmt->fetchAll(PDO::FETCH_ASSOC);

}
// On cherche le nom du user pour l'afficher
if($_SESSION['type_user'] == 2)
{
  $rq = "select nom, prenom FROM candidat WHERE id_candidat = :id";
  $stmt = $PDO->prepare($rq);
  $stmt->bindParam(':id', $_SESSION['id']);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
 if ($row !== false) {
    $nomPseudo = $row['nom']." ";
    $prenomPseudo = $row['prenom'];
  } else {
   $nomPseudo="";
   $prenomPseudo="";
  }
}

else {
$rq="select nom_societe FROM recruteur WHERE id_recruteur = :id";
$stmt = $PDO->prepare($rq);
  $stmt->bindParam(':id', $_SESSION['id']);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($row !== false) {
    $nomPseudo = $row['nom_societe'];
    $prenomPseudo = "";
  } else {
   $nomPseudo="";
   $prenomPseudo="";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style3.css">
    <link  rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
       .box{
    padding: 10px 30px;
    height: auto;
    border-radius: 30px;
    margin: 5px;
    transition: 0.15s;
    background: rgba(255,255,255,0.5);
    -webkit-backdrop-filter: blur(10px);
    backdrop-filter: blur(10px);
    border: 1px solid #050642;
     }
    .logo{
      margin-top:10px;
    }
     .search{
      height:40px;
      text-align: center;
      background-color: white;
      border: 2px solid #050642;
      border-radius: 30px;
      margin: 10px 150px;
    }
    select{
     padding: 7px 10px;
     border: 1px solid #050642;
     border-radius:20px ;
    }
    
  .score{
    background-color: #050642;
    display: inline;
    position: absolute;
    color: white;
    top:0;
    right:0;
    border: none;
    border-radius: 20px;
    text-align: center;
    width:60px;
    }
    
    .haut{position:relative;}
     
@media screen and (max-width:1400px)
{
  .boxContainer
  {
    max-width:900px;
    display: grid;
    grid-template-columns:1fr 1fr 1fr;
    margin:0 auto;
    gap:10px;
  }
}
@media screen and (max-width:1200px){
  .boxContainer
  {
    max-width:700px;
    display: grid;
    grid-template-columns:1fr 1fr;
    margin:0 auto;
    gap:10px;
  }
}

@media screen and (max-width: 1030px){
  .search select{
    display: inline-block;
    padding:2px 2px;
  }
  .search{
    height:fit-content;
  }
}

@media screen and (max-width:700px){
  .boxContainer
  {
    max-width:600px;
    display: grid;
    grid-template-columns:1fr;
    margin:0 100px;
    gap:10px;
  }
  .search, .navigation{
    display: none;
    margin:auto 0;
  }
}
     /*pour les notificatios*/
     .dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  padding: 12px 16px;
  z-index: 1;
}


li{
  list-style: none;
}
.a{
  background-color: red;
  color: white;
  padding: 2px 4px;
  text-align: center;
  border-radius: 50%;
  position:relative;
  bottom:16px;
  right:3px;
 
}
.b{
 color:red;
}

.hidden {
    display: none;
}


    </style>
</head>
<body>

   <!-- Navbar part --> 
   <div class="container">
      <div class="logo">
         <img src="../images/logoW.jpg" alt="logo du site techjob" width="100px" height="auto">
      </div>
      <div class="navigation">
         <p><a href="dashboard.php">Candidats</a></p>
         <p><a href="Offers.php">Offers</a></p>
         <?php if(isset($_SESSION['type_user']) && $_SESSION['type_user']!=1): ?>
          <p><a href="profilc.php">Profile</a></p>
          <?php else: ?>
            <p><a href="profilrec.php">Profile</a></p>
            <?php endif; ?>
       <!-- La partie qui va contenir les notifications  pour les candidats ! -->
       <?php if(isset( $_SESSION['type_user']) && $_SESSION['type_user']!=1): ?>

<?php
 $sql = $PDO->prepare('SELECT * FROM msg  WHERE status = 0 and id_candidat=?');
 $sql->execute([$_SESSION['id']]);
 $count = $sql->rowCount();
 
   ?>
   <div class="dropdown" >
   <a   id="dropdown" href="#"  role="button" >
          <img src="eml.png"  alt=""><span  class="a"><?= $count ;?></span>
        
</a>
          <ul id="dp" class="dropdown-content">
        <?php 
       $sql1 = $PDO->prepare('SELECT * FROM msg WHERE status = 0 and id_candidat=?');
       $sql1->execute([$_SESSION['id']]);
       if ($sql1->rowCount() > 0) {
           while ($result = $sql1->fetch()) {
               echo '<li ><a class="dropdown-item text-primary font-weight-bold" href="read.php?id=' . $result['id_message'] . '">' . $result['messages'] . '</a></li>';
               echo '<li><hr class="dropdown-divider"></li>';
           }
       }
       
       else{
           echo '<li><a class="dropdown-item text-danger  b " href="#"><img src="sad.png">  Sorry! No new notification<a style="color:blue;" href="read.php">see messaging<a></a> </li>';
       }
       ?> 
      </ul>
      
      </div >
 <?php endif; ?> 
         <!-- La fin  de partie qui concerne les notificatios des candidats  ! -->
      </div>
      <div class="bouttons">
      <p style="display:inline; font-size:larger; margin-right:20px;"><strong><?= $nomPseudo ?><?= $prenomPseudo ?></strong></p>
         <?php if(isset( $_SESSION['type_user']) && $_SESSION['type_user']==1): ?>
            <button class="post" name='poster'><a href="form_offer.php">Post an offer</a></button>
            <?php endif; ?>
            <!--  Si l'utilisateur veut se déconnecter on va le redirectionner vers login.php 
            on précise le champ action=logout (le traitement est dans la partie en haut) -->
            <button><a href="../index.php?action=logout" class="disconnect">Disconnect</a></button>
         </div>
      
      </div>

      <div class="search">
        <form method="POST" id="form">
            <label for="domaine">Select a domain:</label>
            <select name="domaine" id="domaine">
                <option value="0">Select a domain</option>
                <?php foreach($domaines as $domaine) 
                  echo "<option value=".$domaine['id_domaine'].">".$domaine['nom_domaine']."</option>";
                ?>
            </select>
            <label for="position">Pick a position:</label>
            <select name="position" id="position">
                <option value="0">Select a position:</option>
                <?php foreach($postes as $poste) 
                  echo "<option value=".$poste['id_poste'].">".$poste['nom_poste']."</option>";
                ?>
            </select>
            
        </form>
      </div>

  <!-- La partie qui va contenir la liste des candidats ! -->
   <div class="boxContainer">
       <?php if (!empty($candidats)) :?> <!-- Si la requête renvoie des enregistrements on va les affichers -->
         <?php foreach ($candidats as $candidat): ?>
       <div class="box rounded">
         <div id="cs" class="text-center img2">
             <div class="haut">
                  <!-- La partie qui va contenir les images des candidats  ! -->
              <?php if(!empty($candidat['photo'])): ?>
             <?php 
             if($_SESSION['type_user']==1 || verifier($_SESSION['id'],$candidat['id_candidat'])){
              $nomImage = $candidat['photo']; // the filename is stored in this variable
              $cheminImage = "../register/upload1/" . $nomImage; // the path to the image is created using the filename
              echo "<img  width='100px' height='90px' src='" . $cheminImage . "' >";}
              else
              echo "<img  width='100px' height='auto' src='user-profile-man.jpg'>"
              ?>
             <?php else: ?>
              <img src="../images/logoW.jpg" class="logo" alt="logo du site techjob" width="100px" height="auto">
              <?php endif; ?> 
                  <!-- la fin pour le  traitement d'image associe a chaque candidat   ! -->
             
  <div class="score <?php if($_SESSION['type_user'] != 1 && !verifier($_SESSION['id'], $candidat['id_candidat'])) echo 'hidden'; ?>">
          
        <?php if($_SESSION['type_user'] == 1 || verifier($_SESSION['id'], $candidat['id_candidat'])): ?>
                Score <br><?= $candidat['score'] ?>
            <?php endif; ?>
        </div>
        </div>
        <h4 class="<?php if($_SESSION['type_user'] != 1 && !verifier($_SESSION['id'], $candidat['id_candidat'])) echo 'hidden'; ?>">
            <?php if($_SESSION['type_user'] == 1 || verifier($_SESSION['id'], $candidat['id_candidat'])): ?>
                <?= $candidat['nom'] ?> <?= $candidat['prenom'] ?>
            <?php else: ?>
                ******* *******
            <?php endif; ?>
        </h4>


             <h5 class="mt-3"><?= $candidat['nom_domaine'] ?></h5>
             <p class="mt-3"><strong>Candidate position:</strong> <?= $candidat['nom_poste'] ?></p>    
     <button name="submit">
        <a href="infocan.php?id=<?=$candidat['id_candidat']?>" class="Contactez nous">Check profile</a>
       </button>
         </div>
      </div>
           <?php endforeach ?>
   </div> 
   <!-- Si la requête ne renvoie aucun enregistrement  -->
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <h2 class="nodata">No users found</h2>
    <?php endif ?>
    <script src="filtrecan.js"></script>
 <script src="java.js"></script>
</body>
</html>

<?php
require('util.php');
require('database.php');
init_php_session();
if(!isset($_SESSION['id'])){
  header('location:login.php');
}
if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=="logout")
{
 // on arrête la session (voir la définition de la fonction dans le fichier util.php)
 clean_php_session(); 
 // puis on redirect l'utilisateur vers la page d'accueil
 header("location:../index.php"); 
}


// Pour le filtre :

$requete = "select * from offre,recruteur,domaine,ville WHERE  ville.id_ville=offre.id_localisation AND offre.id_recruteur=recruteur.id_recruteur AND offre.id_domaine=domaine.id_domaine ORDER BY date_publication DESC";
// On récupère les offres de la base de données
$stmt = $PDO->prepare($requete);
$stmt->execute();
$offres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// requête préparée pour les domaines
$stmt = $PDO->prepare("SELECT * FROM domaine");
$stmt->execute();
$domaines = $stmt->fetchAll(PDO::FETCH_ASSOC);

// requête préparée pour les villes
$stmt = $PDO->prepare("SELECT * FROM ville");
$stmt->execute();
$villes = $stmt->fetchAll(PDO::FETCH_ASSOC);


if($_SERVER['REQUEST_METHOD'] === 'POST')
{    
   $requete = "select * from offre,recruteur,domaine,ville WHERE  ville.id_ville=offre.id_localisation AND offre.id_recruteur=recruteur.id_recruteur AND offre.id_domaine=domaine.id_domaine"; // on ré-initialise la requête

    $dom = $_POST['domaine']; // on récupère le domaine
    $ville = $_POST['ville']; // on récupère la ville
    $type = $_POST['type_offre']; // on récupère le type d'offre

    if($dom != 0) // si l'utilisateur a selectionné une option de domaine
    {
      $requete .= " and offre.id_domaine= :idd";  
    }
    if($ville != 0) // si l'utilisateur a selectionné une option de localisation
    {
      $requete .= " and offre.id_localisation= :idv";
    }
    if($type != 0) // si l'utilisateur a selectionné une option de type
    {
      $requete .= " and offre_type = :type";
    }

    $requete .= " ORDER BY date_publication DESC"; // on réalise l'affichage par l'offre la plus récente à la plus ancienne

    $stmt = $PDO->prepare($requete);

   if($dom != 0 )
    $stmt->bindParam(':idd',$dom);
   if($ville != 0)
    $stmt->bindParam(':idv',$ville);
   if($type != 0)
    $stmt->bindParam(':type',$type);

    $stmt->execute();
    $offres = $stmt->fetchAll(PDO::FETCH_ASSOC); // on récupère tous les enregistrements dans $offres

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
    <title>Document</title>
    <link  rel="stylesheet" href="style_de_Offers.css">
    <link rel="stylesheet" href="../bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
 <style>
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
            <?php if(isset( $_SESSION['type_user']) && $_SESSION['type_user']!=1): ?>
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
           echo '<li><a class="dropdown-item text-danger  b " href="#"><img src="sad.png">  Sorry! No Messages</a> </li>';
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

       <!-- PARTIE FILTRE / -->
       <div class="search">
        <form method="POST" id="form">

            <!-- TRI PAR DOMAINE: -->
            <label for="domaine">Select a domain:</label>
            <select name="domaine" id="domaine">
                <option value="0">Select a domain</option>
                <?php foreach($domaines as $domaine) 
                  echo "<option value=".$domaine['id_domaine'].">".$domaine['nom_domaine']."</option>";
                ?>
            </select>

             <!-- TRI PAR VILLE: -->
            <label for="ville">Pick a city:</label>
            <select name="ville" id="ville">
                <option value="0">Select a city:</option>
                <?php foreach($villes as $ville) 
                  echo "<option value=".$ville['id_ville'].">".$ville['nom_ville']."</option>";
                ?>
            </select>

             <!-- TRI PAR TYPE D'OFFRE: -->
            <select name="type_offre" id="type_offre">
               <option value="0">pick offer type</option>
               <option value="stage">internship</option>
               <option value="travail">job</option>
            </select>
           
        </form>
      </div>
      
  <!-- La partie qui va contenir la liste des candidats ! -->
<div class="boxContainer">
 <?php if (!empty($offres)) :?> <!-- Si la requête renvoie des enregistrements on va les affichers -->
         <?php foreach ($offres as $offre): ?>
    <div class="box rounded">
         <div id="cs" class="text-center img2">
            <div class="con">
              <!-- La partie qui va contenir les images   ! -->
              <?php if(!empty($offre['photo'])): ?>
             <?php 
             // the filename is stored in this variable
              $nomImage = $offre['photo']; 
              // the path to the image is created using the filename
              $cheminImage = "../register/upload1/" . $nomImage; 
              echo "<img  width='100px' height='90px' src='" . $cheminImage . "' >";
              ?>
             <?php else: ?>
              <img src="../images/logoW.jpg" class="logo" alt="logo du site techjob" width="100px" height="auto">
              <?php endif; ?>
              <!-- La fin du traitement  (les images)  ! -->
             <!-- si l'offre est active ( la fonction active() est définie dans util.php) -->
               <?php if(active($offre['is_active'])): ?>
               <div class="active" style='background-color: darkgreen;'>is active</div> 
            <!-- si l'offre n'est plus active -->
               <?php else: ?>
               <div class="active" style='background-color: gray;'>not active</div> 
               <?php endif ?>
            </div>
             <h4> <?= $offre['nom_societe'] ?></h4><!-- ON AFFICHE LE DOMAINE DE L'OFFRE -->
             <h5 class="mt-3">Domaine : <?= $offre['nom_domaine'] ?></h5> <!-- ON AFFICHE LE DOMAINE DE L'OFFRE -->
             <h5 class="mt-3">City: <?= $offre['nom_ville']?> </h5>
             <p class="mt-3"><strong></strong> Offer type:<?= $offre['offre_type'] ?></p>
        <?php if(active($offre['is_active'])): ?>   
          <button name="submit" >
            <a href="info_offre.php?id=<?=$offre['id_offre']?>" class="Contactez nous">Check offer</a>
          </button>
          <small> <?php if(postuler($_SESSION['id'],$offre['id_offre'])):?> 
            already submitted
           <?php endif?> 
          
          </small>
        <?php else:?>
          <button name="submit" class="not" disabled style="background-color:gray;">Offer not available</button>
        <?php endif ?>
      </div>
    </div>
           <?php endforeach ?>
           
</div> 
   <!-- Si la requête ne renvoie aucun enregistrement  -->
<?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <h2 class="nodata">No offers found</h2>
<?php endif ?>
            
<script src="filtreoff.js"></script>
  <script src="java.js"></script>     
            
    
</body>
</html>
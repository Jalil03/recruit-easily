
<?php
require('util.php');
require('database.php');
init_php_session();
if(!isset($_SESSION['id'])){
   header('location:login.php');
 }
// Pour se deconnecter :  
if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=="logout")
{
 // on arrête la session (voir la définition de la fonction dans le fichier util.php)
 clean_php_session(); 
 // puis on redirect l'utilisateur vers la page d'accueil
 header("location:../index.php"); 
 
}
$rq=$PDO->prepare('select * from recruteur where id_recruteur=?');
$rq->execute(array($_SESSION['id']));
$info=$rq->fetch();
$rq2=$PDO->prepare('select * from offre,recruteur,domaine,ville WHERE  ville.id_ville=offre.id_localisation AND offre.id_recruteur=recruteur.id_recruteur AND offre.id_domaine=domaine.id_domaine and recruteur.id_recruteur=?');
$rq2->execute(array($_SESSION['id']));
$offres=$rq2->fetchAll();

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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>


      #jl{
         color: lightblue;
         background-color: lightblue;
      }
      #jl2{
         color: dodgerblue;
         background-color: dodgerblue;
      }
       body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }

    .tab {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .tab th,
        .tab td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .tab th {
            background-color: #f0f0f0;
            color: #333;
            text-align: left;
        }

        .tab td {
            color: #555;
        }

        .tab td:first-child {
            font-weight: bold;
        }

   
  .infocan img{
   float: left;
   position: relative;
   top: 0px;
   
  }
  .titre{
  
           
           text-align: center;
           font-size: 36px;
           color: #fff;
           margin-bottom: 20px;
           padding: 20px;
           background-color: #050642;
           border-radius: 10px;
           box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
           font-family: 'Arial', sans-serif; /* Police de caractères personnalisée */
       }
       
  
  
  
 
  .mod{ 
            display: block;
            margin: 0 550px;
            padding: 10px 20px;
            background-color:#050642;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

 
.mod:hover{background-color: #0056b3;
   
}
.divt{
   margin: 10px auto; 
   width: 90%;
   margin-top: 0;
   margin-bottom: 40px;
}

.infocanm{
   
   padding: 1px 10px;
       margin: 10px auto; 
       background-color: white; 
       overflow: hidden;
       width: 90%;
       height: auto;
}
.infocanm div{
   padding: 2px 4px;
   
}

.cont{
       color: #14b1bb !important;
   }
.cont:hover{
       color: #028791 !important;
       text-decoration: underline !important;
   }
  
   
    </style>
    <link  rel="stylesheet" href="style_de_Offers.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="logo">
           <img src="../images/logoW.jpg" alt="logo du site " width="100px" height="auto">
        </div>
        <div class="navigation">
           <p><a href="dashboard.php">Candidats</a></p>
           <p><a href="Offers.php">Offers</a></p>
           <p><a href="#">Profile</a></p>
        </div>
        <div class="bouttons">
         <p style="display:inline; font-size:larger; margin-right:20px;"><strong><?= $nomPseudo ?><?= $prenomPseudo ?></strong></p>
            <?php if(isset( $_SESSION['type_user']) && $_SESSION['type_user']==1): ?>
               <button id="jl2" class="post" name='poster'><a href="form_offer.php">Post an offer</a></button>
            <?php endif; ?>
            <!--  Si l'utilisateur veut se déconnecter on va le redirectionner vers login.php 
            on précise le champ action=logout (le traitement est dans la partie en haut) -->
            <button id="jl2"><a href="../index.php?action=logout" class="disconnect">Disconnect</a></button>
         </div>
       </div>
        <div class="infocan">
            <!-- La partie qui va contenir les images   ! -->
           <?php if(!empty($info['photo'])): ?>
             <?php 
              $nomImage = $info['photo']; // the filename is stored in this variable
              $cheminImage = "../register/upload1/" . $nomImage; // the path to the image is created using the filename
              echo "<img  width='100px' height='auto' src='" . $cheminImage . "' >";
              ?>
             <?php else: ?>
                <img src="../images/logoW.jpg" alt="" srcset="">
              <?php endif; ?>
            <!-- fin de la partie qui traite les images  ! -->
            <div class="titre">Your Profile</div>
          
            <table class="tab">
            <tr>
            <th>Company name:</th>
                <td><?=$info['nom_societe']?></td>
            </tr>
            <tr>
            <th>Telephone :</th>
                <td><?=$info['num_tel']?></td>
            </tr>
           <tr>
             <th>Company Email :</th>
                <td><?=$info['email_societe']?></td>
             </tr>
             <tr>        
             <th>Web Site :</th>
   
                    <td><a class="cont" href="<?=$info['site'] ?>"><?=$info['site'] ?></a></td>
           </tr>
                
              </table>
            
        </div>
        <div class="divt">
         <div class="titre">Your offers</div>
        </div>
        
        <div class="boxContainer">
 <?php if (!empty($offres)) :?> <!-- Si la requête renvoie des enregistrements on va les affichers -->
         <?php foreach ($offres as $offre): ?>
    <div class="box rounded">
         <div id="cs" class="text-center img2">
            <div class="con">
             <img src="../images/logoW.jpg" class="logo" alt="logo du site Reasily" width="100px" height="auto">
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
         
          <button name="submit"  id="jl">
            <a  href="info_offre.php?id=<?=$offre['id_offre']?>" class="Contactez nous">Check offer</a>
          </button>
        
      </div>
    </div>
           <?php endforeach ?>
           
</div>
   <!-- Si la requête ne renvoie aucun enregistrement  -->
   <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <h2 class="nodata">No offers found</h2>
<?php endif ?> 
        
<button id="jl2" class="mod"><a href="from_update_rec.php">Modifier</a></button>

        
        
</body>
</html>
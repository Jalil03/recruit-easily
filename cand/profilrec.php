
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
   
   .infocan{
       
       padding: 1px 10px;
       margin: 10px auto; 
       background-color: white; 
       overflow: hidden;
       width: 90%;
       height: 250px;
       
   }
  .infocan img{
   float: left;
   position: relative;
   top: 30px;
   
  }
  .titre{
   font-size: 30px;
   font-family: Roboto-Black;
   
  }
  
  .infocan table{
   padding: 10px;
  }
  .infocan img{
   padding: 10px;
  }
  table td{
   width: 340px;
   padding: 10px 5px;
  }
  .mod{
  display: flex;
  justify-content: center;
  position: relative;
  left: 130px;
  color: white; 
}
.mod:hover{
   letter-spacing: 0.5px;
   transition: 0.5s;
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
.td2{
   width: 400px;
   
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
           <img src="../images/logoW.jpg" alt="logo du site techjob" width="100px" height="auto">
        </div>
        <div class="navigation">
           <p><a href="dashboard.php">Candidats</a></p>
           <p><a href="Offers.php">Offers</a></p>
           <p><a href="#">Profile</a></p>
        </div>
        <div class="bouttons">
           <?php if(isset( $_SESSION['type_user']) && $_SESSION['type_user']==1): ?>
              <button class="post" name='poster'><a href="form_offer.php">Post an offer</a></button>
              <?php endif; ?>
              <!--  Si l'utilisateur veut se déconnecter on va le redirectionner vers login.php 
              on précise le champ action=logout (le traitement est dans la partie en haut) -->
              <button><a href="../index.php?action=logout" class="disconnect">Disconnect</a></button>
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
           
            <table >
                <tr>
                    <td colspan="2" class="titre">Your profile</td>  
                </tr>
                <tr>
                  <td><strong>Company name: </strong><?=$info['nom_societe'] ?></td>
                  <td class="td2"><strong>Telephone : </strong><?=$info['num_tel'] ?></td>
                </tr>
                <tr>
                    <td ><strong>Company Email : </strong><?=$info['email_societe'] ?></td>
                    
                    <td><strong>Web Site : </strong><a class="cont" href="<?=$info['site'] ?>"><?=$info['site'] ?></a></td>
           </tr>
                </tr>
              </table>
              <button class="mod"><a href="from_update_rec.php">Modifier</a></button>
        </div>
        <div class="divt">
        <h2>Your offers
        </h2>
        </div>
        <div class="boxContainer">
 <?php if (!empty($offres)) :?> <!-- Si la requête renvoie des enregistrements on va les affichers -->
         <?php foreach ($offres as $offre): ?>
    <div class="box rounded">
         <div id="cs" class="text-center img2">
            <div class="con">
             <img src="../images/logoW.jpg" class="logo" alt="logo du site techjob" width="100px" height="auto">
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
         
          <button name="submit" >
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
        
      

        
        
</body>
</html>
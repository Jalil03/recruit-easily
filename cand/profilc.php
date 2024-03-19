
<?php
require('util.php');
require('database.php');
init_php_session();
if(!isset($_SESSION['id'])){
    header('location:login.php');
  }
// Pour se deconnecter :  
$rq=$PDO->prepare('select * from candidat,domaine,poste WHERE poste.id_poste=candidat.id_poste and candidat.id_domaine=domaine.id_domaine and id_candidat=?');
$rq->execute(array($_SESSION['id']));

// recuperation du details de l'user 

$rq1=$PDO->prepare('select * from candidat,comp_candidat,competences,domaine_comp WHERE
domaine_comp.id_comp=comp_candidat.id_comp and
candidat.id_candidat=comp_candidat.id_candidat and competences.id_comp=comp_candidat.id_comp and candidat.id_candidat=? and domaine_comp.id_domaine=?');

// recuperation competences candidats

$rq2=$PDO->prepare('SELECT * from comp_candidat,competences WHERE comp_candidat.id_comp=competences.id_comp and comp_candidat.id_candidat=? and nom_comp not in(
  select nom_comp from comp_candidat,competences,domaine_comp WHERE
  domaine_comp.id_comp=comp_candidat.id_comp
  and competences.id_comp=comp_candidat.id_comp and comp_candidat.id_candidat=? and domaine_comp.id_domaine=?)');

//les comps secondaire qui ne sont pas lier a aucun domaine 


// pour ce deconnecter 
if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=="logout")
{
 // on arrête la session (voir la définition de la fonction dans le fichier util.php)
 clean_php_session(); 
 // puis on redirect l'utilisateur vers la page d'accueil
 header("location:../index.php"); 

}
$ligne=$rq->fetch();
$rq1->execute(array($_SESSION['id'],$ligne['id_domaine']));
$rq2->execute(array($_SESSION['id'],$_SESSION['id'],$ligne['id_domaine']));
$compro=$rq1->fetchall();
$comps=$rq2->fetchAll();

$rq3=$PDO->prepare('select * from experience where id_candi=?');
$rq3->execute(array($_SESSION['id']));

//Récupération de l'expérience professionnelle de l'utilisateur

$exp=$rq3->fetchAll();
$rq3=$PDO->prepare('select * from education where id_candi=?');
$rq3->execute(array($_SESSION['id']));
$edu=$rq3->fetchAll();

/* Récupération de l'éducation de l'utilisateur  */

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
    <link rel="stylesheet" href="style3.css">
    <link  rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }

       
       
        .titre {
           
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

        .cva {
            display: inline-block;
            padding: 8px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .cva:hover {
            background-color: #0056b3;
        }

        .details-section {
            margin-top: 30px;
        }

        .details-section h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
        }

        .skills-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .skills-item {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border-radius: 20px;
        }

        .experience-item {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f0f0f0;
            border-left: 5px solid #007bff;
        }

        .experience-item h3 {
            font-size: 20px;
            margin-bottom: 5px;
            color: #333;
        }

        .experience-item p {
            margin: 0;
            color: #666;
        }

        .education-item {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-left: 5px solid #00d8a0;
        }

        .education-item h3 {
            font-size: 20px;
            margin-bottom: 5px;
            color: #333;
        }

        .education-item p {
            margin: 0;
            color: #666;
        }

        

        .edit-profile-button {
            display: block;
            margin: 0 650px;
            padding: 10px 20px;
            background-color: #050642;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .edit-profile-button:hover {
            background-color: #0056b3;
        }
        
  .infocan img{
   float: left;
   position: relative;
   top: 30px;
   
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
 /* style pr notification */
  

 .dropdown {
    position: relative;
    display: inline-block;
}

#dropdown {
    text-decoration: none;
    color: black;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content li {
    padding: 10px;
}

.dropdown-content li:hover {
    background-color: #ddd;
}

.dropdown-content hr {
    margin: 5px 0;
}


.badge {
            position: absolute;
            top: -5px;
            right: -5px;
            padding: 5px 8px;
            border-radius: 50%;
            background-color: red;
            color: white;
            font-size: 12px;
            font-weight: bold;
        }
        /*fin style des notifications */

#jl2{
         color: dodgerblue;
         background-color: dodgerblue;
      }
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
        }
    
    </style>
    <title>Document</title>
</head>
<body>

    <div class="container">

    
        <div class="profile-image">
       
           <img src="../images/logoW.jpg" alt="logo du site " width="100px" height="auto">
          
        </div>
        
        <div class="navigation">
           <p><a href="dashboard.php">Candidats</a></p>
           <p><a href="Offers.php">Offers</a></p>
           <p><a href="#">Profile</a></p>
           <!-- La partie qui va contenir les notifications  pour les candidats ! -->
       <?php if(!is_recruteur()): ?>

        <?php
$sql = $PDO->prepare('SELECT * FROM msg WHERE status = 0 and id_candidat=?');
$sql->execute([$_SESSION['id']]);
$count = $sql->rowCount();
?>
<div class="dropdown">
    <a id="dropdown" href="#" role="button" onclick="toggleDropdown()">
        <i class="fas fa-bell"></i> <!-- Icône de notification -->
        <?php if ($count > 0): ?>
            <span class="badge"><?= $count; ?></span> <!-- Badge dynamique pour afficher le nombre de notifications -->
        <?php endif; ?>
    </a>
    <ul id="dp" class="dropdown-content">
        <?php
        if ($sql->rowCount() > 0) {
            while ($result = $sql->fetch()) {
                echo '<a class="dropdown-item text-primary font-weight-bold" href="read.php?id=' . $result['id_message'] . '">' . $result['messages'] . '</a>';
                echo '<li><hr class="dropdown-divider"></li>';
            }
        } else {
            echo '<li><a class="dropdown-item text-danger b" href="#">  Désolé! Aucune nouvelle notification<a style="color:blue;" href="read.php">Voir les messages<a></a></li>';
        }
        ?>
    </ul>
</div>
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
            <button id="jl2"><a href="../index.php?action=logout" class="disconnect">Disconnect</a></button>
         </div>
       </div>
        <div class="infocan">
            <?php if(!empty($ligne['photo'])): ?>
             <?php 
              $nomImage = $ligne['photo']; // the filename is stored in this variable
              $cheminImage = "../register/upload1/" . $nomImage; // the path to the image is created using the filename
              echo "<img  width='100px' height='auto' src='" . $cheminImage . "' >";
              ?>
             <?php else: ?>
             <img src="user-profile-man.jpg" alt="" srcset="">
              <?php endif; ?>
    
              <div class="titre">Your Profile</div>
        
            <table class="tab">
            <tr>
                <th>Nom:</th>
                <td><?=$ligne['nom']?></td>
            </tr>
            <tr>
                <th>Prénom:</th>
                <td><?=$ligne['prenom']?></td>
            </tr>
            <tr>
                <th>Téléphone:</th>
                <td><?=$ligne['num_tel']?></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td><?=$ligne['email_contact']?></td>
            </tr>
            <tr>
                <th>Domaine:</th>
                <td><?=$ligne['nom_domaine']?></td>
            </tr>
            <tr>
                <th>Poste:</th>
                <td><?=$ligne['nom_poste']?></td>
            </tr>
            <tr>
                <th>CV:</th>
                <td><a class="cva" href="cv/<?=$ligne['cv']?>" download="<?=$ligne['nom'].'_cv'?>">Télécharger le CV</a></td>
            </tr>
        </table>
        
        <div class="details-section">
            <h2>Compétences :</h2>
            <div class="skills-list">
                <?php foreach ($compro as $comp) : ?>
                    <div class="skills-item"><?=$comp['nom_comp']?></div>
                <?php endforeach; ?>
            </div>
            <h2>Expérience professionnelle :</h2>
            <?php foreach ($exp as $exps) : ?>
                <div class="experience-item">
                    <h3><?=$exps['description']?></h3>
                    <p><?=$exps['nom_entreprise']?></p>
                    <p><?=$exps['date_debut']?> - <?=$exps['date_fin']?></p>
                </div>
            <?php endforeach; ?>
            
                     <h2>Formation :</h2>
                     <?php foreach ($edu as $edus) : ?>
                         <div class="education-item">
                             <h3><?=$edus['options']?> <?=$edus['filiere']?></h3>
                             <p><?=$edus['nom_ecole']?></p>
                             <p><?=$edus['date_debut']?> - <?php if(!empty($edus['date_fin'])) { echo $edus['date_fin']; } ?></p>
                         </div>
                     <?php endforeach; ?>
                 </div>
             </div>
             <button id="jl2"><a href="form_update_can.php" >Update</a></button>
            
    <script src="java.js"></script>     
        
</body>
</html>

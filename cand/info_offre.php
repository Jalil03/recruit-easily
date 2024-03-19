
<?php
include('database.php');
include('util.php');
init_php_session();
if(!isset($_SESSION['id'])){
    header('location:login.php');
  }
$rq=$PDO->prepare('select * from offre where id_offre=?');
$rq->execute(array($_GET['id']));
$idrec=$rq->fetch()['id_recruteur'];

$rq1=$PDO->prepare('select * from offre,ville,domaine,recruteur where offre.id_recruteur=recruteur.id_recruteur and offre.id_domaine=domaine.id_domaine and offre.id_localisation=ville.id_ville and id_offre=?');
$rq1->execute(array($_GET['id']));
$off=$rq1->fetch(PDO::FETCH_ASSOC);

// requette des offres

$rq2=$PDO->prepare('select id_recruteur from offre where id_offre=?');
$rq2->execute(array($_GET['id']));
$id_rec=$rq2->fetch()['id_recruteur'];

/// des recs

$rq=$PDO->prepare('select * from candidat,postule,domaine,poste WHERE candidat.id_domaine=domaine.id_domaine and candidat.id_domaine=domaine.id_domaine and poste.id_poste=candidat.id_poste and  candidat.id_candidat=postule.id_candidat and postule.id_offre=?');
$rq->execute(array($_GET['id']));
$lignes=$rq->fetchAll(PDO::FETCH_ASSOC);


// lignes

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
      margin-left:60px;
    }
    h3{
        font-size: 26px;
        padding: 15px;
          
    }

    #jl{
      color: lightblue;
      background-color: lightblue;
    }

    #jl2{
         color: dodgerblue;
         background-color: dodgerblue;
      }
    .infoent{
    width: 90%;
    height: fit-content;
  margin: auto;
  
  top: -150px;
  bottom: 0;
  background-color: white;
  left: 0;
  right: 0;
  border-radius: 20px;
  
  padding-left: 10px;
    }
    .infoent button{
        position: relative;
        left: 45%; 
    }
    .tt{
        text-align: center;
    }
    h3::after{
        content: '';
    display: block;
    height: 2px;
    width: 100%;
    background-color: rgba(0,0,0,0.05);
    right: 0;
    left: 0;
    z-index: 1;
    }
    table td {
    font-size: 16px;
    min-height: 40px;
    padding: 10px 10px;
   
    }
    table a{
        color: #14b1bb;
    }
    table a:hover{
        color: #028791;
        text-decoration: underline;
    }
    .infoent img{
        float: right;
    }
    .infoent  button:hover{
     background-color: #ff0749;
     transition: 0.3s;
     letter-spacing: 0.5px;
   }
  

    

    </style>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="logo">
           <img src="../images/logoW.jpg" alt="logo du site recruiteasily" width="100px" height="auto">
        </div>
        <div class="navigation">
           <p><a href="dashboard.php">Candidats</a></p>
           <p><a href="Offers.php">Offers</a></p>
           <?php if(isset( $_SESSION['type_user']) && $_SESSION['type_user']==2): ?>
          <p><a href="profilc.php">Profile</a></p>
          <?php else: ?>
            <p><a href="profilrec.php">Profile</a></p>
            <?php endif; ?>
        </div>
        <div class="bouttons">
        <p style="display:inline; font-size:larger; margin-right:20px;"><strong><?= $nomPseudo ?><?= $prenomPseudo ?></strong></p>
           <?php if(isset( $_SESSION['type_user']) && $_SESSION['type_user']==1): ?>
              <button id="jl2" class="post" name='poster'><a href="./form_offer.php">Post an offer</a></button>
              <?php endif; ?>
              <!--  Si l'utilisateur veut se déconnecter on va le redirectionner vers login.php 
              on précise le champ action=logout (le traitement est dans la partie en haut) -->
              <button id="jl2"><a href="../index.php?action=logout" class="disconnect">Disconnect</a></button>
           </div>
        </div>

        <div class="infoent">
            <h3>Offer Information</h3>
            <!--image-->
             <?php if(!empty($off['photo'])): ?>
             <?php 
              $nomImage = $off['photo']; // the filename is stored in this variable
              $cheminImage = "../register/upload1/" . $nomImage; // the path to the image is created using the filename
              echo "<img  width='50px' height='50px' class='img rounded-circle' src='" . $cheminImage . "' >";
              ?>
             <?php else: ?>
             <img src="../images/logoW.jpg" alt="" srcset="">
              <?php endif; ?>
             <!-- fin image-->
            <table >
                <tr>
                    <td><strong>Company name</strong></td>
                    <td>:</td>
                    <td><?= $off['nom_societe']?></td>
                </tr>
                <tr>
                    <td><strong>City</strong></td>
                    <td>:</td>
                    <td><?= $off['nom_ville'] ?></td>
                </tr>
                <tr>
                    <td><strong>publication date</strong></td>
                    <td>:</td>
                    <td><?= $off['date_publication'] ?></td>
                </tr>
                <tr>
                    <td><strong>Duration</strong></td>
                    <td>:</td>
                    <td><?= $off['durée'] ?></td>
                </tr>
                <tr>
                    <td><strong>Description</strong></td>
                    <td>:</td>
                    <td><?= $off['description'] ?></td>
                </tr>
                <tr>
                    <td><strong>Offer type</strong></td>
                    <td>:</td>
                    <td><?= $off['offre_type'] ?></td>
                </tr>
                <tr>
                    <td><strong>Domaine</strong></td>
                    <td>:</td>
                    <td><?= $off['nom_domaine'] ?></td>
                </tr>
                <tr>
                    <td><strong>Web site</strong></td>
                    <td>:</td>
                    <td><a href="<?= $off['site'] ?>"><?= $off['site'] ?></a></td>
                </tr>
            </table>
            <?php if(isset( $_SESSION['type_user']) && $_SESSION['type_user']==2):?>

<!-- on va faire soit le apply soit appliation already ... si on est cand , sinon on va donner la possibilite de modifier l'offre si on est rec -> vers forme update offre -->          

    <form action="postulation.php" method="post">
    <?php if(!postuler($_SESSION['id'],$_GET['id'])):?>   
    <button id="jl" ><a href="postulation.php?id=<?=$_GET['id']?>">Apply</a></button>
    <?php else:?>
    <button id="jl" disabled style="color:white;">application already submitted</button>
    <?php endif ?>
    <?php else:?>
        <?php if(verifier($id_rec,$_SESSION['id'])):?>
        <button id="jl" name="submit" ><a href="form_update_offre.php?id=<?=$_GET['id']?>">Modifier votre offre</a></button>
        
    </form>
    <?php endif?>
    <?php endif ?>
    </div>

    <!-- dans cette partie on va voir les candidats qui ont postuler pour cette offres , afficher le score , nom ,prenom ... -->
    <?php if(isset( $_SESSION['type_user']) && $_SESSION['type_user']==1) :?>
    <?php if(verifier($id_rec,$_SESSION['id'])) :?>
        <h3 class="tt">Candidates apply for this offer</h3>
    <div class="boxContainer">
        
       <?php if (!empty($lignes)) :?> <!-- Si la requête renvoie des enregistrements on va les affichers -->
         <?php foreach ($lignes as $candidat): ?>
       <div class="box rounded">
         <div id="cs" class="text-center img2">
             <div class="haut">
               <img src="../images/logoW.jpg" class="logo" alt="logo du site techjob" width="100px" height="auto">
               <div class="score">
                 Score <?= $candidat['score'] ?>
               </div>
             </div>
             <h4> <?= $candidat['nom'] ?> <?= $candidat['prenom'] ?></h4>
             <h5 class="mt-3"><?= $candidat['nom_domaine'] ?></h5>
             <p class="mt-3"><strong>Candidate position:</strong> <?= $candidat['nom_poste'] ?></p>    
     <button id="jl2" name="submit">
        <a href="infocan.php?id=<?=$candidat['id_candidat']?>" class="Contactez nous">Check profile</a>
       </button>
         </div>
      </div>
           <?php endforeach ?>
   </div> 
   <?php endif ?>
   <?php endif ?>
   <?php endif ?>
    
        
        
</body>
</html>
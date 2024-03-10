
<?php
require('util.php');
require('database.php');
init_php_session();
if(!isset($_SESSION['id'])){
    header('location:login.php');
  }
// Pour se deconnecter :  
$rq=$PDO->prepare('select * from candidat,domaine,poste WHERE poste.id_poste=candidat.id_poste and candidat.id_domaine=domaine.id_domaine and id_candidat=?');
$rq->execute(array($_GET['id']));
$_SESSION['id_can']=$_GET['id'];
$rq1=$PDO->prepare('select * from candidat,comp_candidat,competences,domaine_comp WHERE
domaine_comp.id_comp=comp_candidat.id_comp and
candidat.id_candidat=comp_candidat.id_candidat and competences.id_comp=comp_candidat.id_comp and candidat.id_candidat=? and domaine_comp.id_domaine=?');
$rq2=$PDO->prepare('SELECT * from comp_candidat,competences WHERE comp_candidat.id_comp=competences.id_comp and comp_candidat.id_candidat=? and nom_comp not in(
  select nom_comp from comp_candidat,competences,domaine_comp WHERE
  domaine_comp.id_comp=comp_candidat.id_comp
  and competences.id_comp=comp_candidat.id_comp and comp_candidat.id_candidat=? and domaine_comp.id_domaine=?)');
if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=="logout")
{
 // on arrête la session (voir la définition de la fonction dans le fichier util.php)
 clean_php_session(); 
 // puis on redirect l'utilisateur vers la page d'accueil
 header("location:../index.php"); 
 exit();
}
$ligne=$rq->fetch();
$rq1->execute(array($_GET['id'],$ligne['id_domaine']));
$rq2->execute(array($_GET['id'],$_GET['id'],$ligne['id_domaine']));
$compro=$rq1->fetchall();
$comps=$rq2->fetchAll();
$rq3=$PDO->prepare('select * from experience where id_candi=?');
$rq3->execute(array($_GET['id']));
$exp=$rq3->fetchAll();
$rq3=$PDO->prepare('select * from education where id_candi=?');
$rq3->execute(array($_GET['id']));
$edu=$rq3->fetchAll();
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
    .infocan{
       
        padding: 1px 10px;
        margin: 10px auto; 
        background-color: white; 
        overflow: hidden;
        width: 90%;
        height: 300px;
        
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
   .cva{
    color: blue;
}
.cva:hover{
    color: blueviolet;
    text-decoration: underline;

}
   
   .infocan table{
    padding: 10px;
   }
   .infocan img{
    padding: 10px;
   }
   table td{
    width: 300px;
    padding: 10px 5px;
   }
   .con{
   display: flex;
   justify-content: center;
   position: relative;
   left: 130px;
   color: white; 
}
.con:hover{
    letter-spacing: 0.5px;
    transition: 0.5s;
}
.divt{
    margin: 10px auto; 
    width: 90%;
    margin-top: 0;
    margin-bottom: 40px;
}
.td2{
    width: 400px;
    
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
  

    

    </style>
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
           <?php if(isset( $_SESSION['type_user']) && $_SESSION['type_user']==2): ?>
          <p><a href="profilc.php">Profile</a></p>
          <?php else: ?>
            <p><a href="profilrec.php">Profile</a></p>
            <?php endif; ?>
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
        <div class="infocan">
          <!-- image candidat-->
            <?php if(!empty($ligne['photo'])): ?>
             <?php 
              if($_SESSION['type_user']==1 || verifier($_SESSION['id'],$ligne['id_candidat'])){
              $nomImage = $ligne['photo']; // the filename is stored in this variable
              $cheminImage = "../register/upload1/" . $nomImage; // the path to the image is created using the filename
              echo "<img  width='100px' height='auto' src='" . $cheminImage . "' >";}
              else
              echo "<img  width='100px' height='auto' src='user-profile-man.jpg'>"
              ?>
             <?php else: ?>
             <img src="user-profile-man.jpg" alt="" srcset="">
              <?php endif; ?>
           
            <table >
                <tr>
                    <?php if($_SESSION['type_user']==1):?>
                    <td colspan="2" class="titre">Contact this profile for a recruitment</td>  
                    <?php else: ?>
                        <td colspan="2" class="titre">Profile candidat</td>  
                    <?php endif ?>       
                </tr>
                <tr>
                  <td><strong>Nom : </strong> <?php if($_SESSION['type_user']==1  || verifier($_SESSION['id'],$ligne['id_candidat'])) :?><?=$ligne['nom']?>
                  <?php else:?>
                    ********
                    <?php endif ?>  
                  </td>
                  <td class="td2"><strong>Prenom : </strong><?php if($_SESSION['type_user']==1 || verifier($_SESSION['id'],$ligne['id_candidat'])):?><?=$ligne['prenom']?>
                  <?php else:?>
                    ********
                    <?php endif ?>  
                  </td>
                </tr>
                <tr>
                    <td ><strong>Telephone : </strong> <?php if($_SESSION['type_user']==1 || verifier($_SESSION['id'],$ligne['id_candidat'])):?>
                      <?=$ligne['num_tel']?>
                      <?php else:?>
                        **************
                      <?php endif ?> 
                    </td>
                  
                    <td class="td2"><strong>Email : </strong>  <?php if($_SESSION['type_user']==1 || verifier($_SESSION['id'],$ligne['id_candidat'])):?><?=$ligne['email_contact']?>
                      <?php else:?>
                        ********@******
                    </td>
                    <?php endif ?>  
                </tr>
                <tr>
                    <td><strong>Domaine : </strong><?=$ligne['nom_domaine']?></td>
                    <td class="td2"><strong>Poste : </strong><?=$ligne['nom_poste']?></td>
                </tr> <?php if($_SESSION['type_user']==1):?>
                <tr>
                    <td><strong>CV : </strong><a class="cva" href="cv/<?=$ligne['cv']?>" download="<?=$ligne['nom'].' cv'?>">Télécharger le CV</a></td>
                    
                </tr>
                <?php endif ?>  
              </table>
              <?php if(isset( $_SESSION['type_user']) && $_SESSION['type_user']==1):?>
                <a href="send.php"><button class="con">Contacter</button></a>
              <?php endif ?>
        </div>
        <div class="divt">
        <h2>Détails du profil
        </h2>
        </div>
        
        <div class="infocanm">
         <div>
         <h2>Compétence primaire : </h2>
         <p>
         <?php foreach ($compro as $key => $comp): ?>
                    <span><?=$comp['nom_comp']?></span>
                   <?php if($key !=(count($compro) - 1)):?>
                   ,
                   <?php endif ?> 
                   <?php endforeach?></p>
         </div>
         <div>
            <h2>Compétence Secondaire : </h2>
            <p>
         <?php foreach ($comps as $key => $comp): ?>
                    <span><?=$comp['nom_comp']?></span>
                   <?php if($key !=(count($comps) - 1)):?>
                   ,
                   <?php endif ?> 
                   <?php endforeach?></p>
            </div>
        <div>
                <h2>Expérience professionnelle : </h2>
                <?php foreach ($exp as $exps): ?>
                <strong><?=$exps['description']?></strong>
                <p><?=$exps['nom_entreprise']?></p>
                <p><?=$exps['date_debut']?>/<?=$exps['date_fin']?></p>
                <?php endforeach?>
                </div>
        <div>
                    <h2>Formation : </h2>
                   <?php foreach ($edu as $edus): ?>
                    <strong><?=$edus['options'] .' '.$edus['filiere']?></strong>
                    <p><?=$edus['nom_ecole']?></p>
                    <p><?=$edus['date_debut']?>/
                    
                    <?php if(!empty($edus['date_fin'])):?>
                    <?=$edus['date_fin']?></p>
                    <?php endif?>
                    <?php endforeach?>
                    </div>
        </div>
        

        
        
</body>
</html>
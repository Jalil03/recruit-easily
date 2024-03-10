
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

}
$ligne=$rq->fetch();
$rq1->execute(array($_SESSION['id'],$ligne['id_domaine']));
$rq2->execute(array($_SESSION['id'],$_SESSION['id'],$ligne['id_domaine']));
$compro=$rq1->fetchall();
$comps=$rq2->fetchAll();
$rq3=$PDO->prepare('select * from experience where id_candi=?');
$rq3->execute(array($_SESSION['id']));
$exp=$rq3->fetchAll();
$rq3=$PDO->prepare('select * from education where id_candi=?');
$rq3->execute(array($_SESSION['id']));
$edu=$rq3->fetchAll();


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
     .td2{
    width: 400;
    
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
.cva{
    color: blue;
}
.cva:hover{
    color: blueviolet;
    text-decoration: underline;

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
           <!-- La partie qui va contenir les notifications  pour les candidats ! -->
       <?php if(!is_recruteur()): ?>

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
           <?php if(is_recruteur()): ?>
              <button class="post" name='poster'><a href="form_offer.php">Post an offer</a></button>
              <?php endif; ?>
              <!--  Si l'utilisateur veut se déconnecter on va le redirectionner vers login.php 
              on précise le champ action=logout (le traitement est dans la partie en haut) -->
              <button><a href="../index.php?action=logout" class="disconnect">Disconnect</a></button>
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
           
            <table >
                <tr>
                    <td colspan="2" class="titre">Your profile</td>  
                </tr>
                <tr>
                  <td><strong>Nom : </strong><?=$ligne['nom']?></td>
                  <td class="td2"><strong>Prenom : </strong><?=$ligne['prenom']?></td>
                </tr>
                <tr>
                    <td ><strong>Telephone : </strong><?=$ligne['num_tel']?></td>
                    
                    <td class="td2"><strong>Email : </strong><?=$ligne['email_contact']?></td>
                </tr>
                <tr>
                    <td><strong>Domaine : </strong><?=$ligne['nom_domaine']?></td>
                    <td class="td2"><strong>Poste : </strong><?=$ligne['nom_poste']?></td>
                </tr>
                <tr>
                    <td><strong>CV : </strong><a class="cva" href="cv/<?=$ligne['cv']?>" download="<?=$ligne['nom'].' cv'?>">Télécharger le CV</a></td>
                    
                </tr>
              </table>
              <button class="con"><a href="form_update_can.php">Modifier</a></button>
        </div>
        <div class="divt">
        <h2>Détails du profil
        </h2>
        </div>
        
        <div class="infocanm">
         <div>
         <h2>Primary skill : </h2>
         <p>
         <?php foreach ($compro as $key => $comp): ?>
                    <span><?=$comp['nom_comp']?></span>
                   <?php if($key !=(count($compro) - 1)):?>
                   ,
                   <?php endif ?> 
                   <?php endforeach?></p>
         </div>
         <div>
            <h2> Secondary Skill: </h2>
            <p>
         <?php foreach ($comps as $key => $comp): ?>
                    <span><?=$comp['nom_comp']?></span>
                   <?php if($key !=(count($comps) - 1)):?>
                   ,
                   <?php endif ?> 
                   <?php endforeach?></p>
            </div>
        <div>
                <h2>Professional experience : </h2>
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
        

    <script src="java.js"></script>     
        
</body>
</html>

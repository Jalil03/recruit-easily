
<?php

// pour voir le profil des candidats
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
    <link rel="stylesheet" href="./styling1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <style>

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
  
</style>
  </head>
<body>
<div class="containerxxx">
      <div class="logo">
      <img src="https://t4.ftcdn.net/jpg/05/05/61/73/360_F_505617309_NN1CW7diNmGXJfMicpY9eXHKV4sqzO5H.jpg" alt="">
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
         <?php if(isset( $_SESSION['type_user']) && $_SESSION['type_user']==1): ?>
            <button class="post" name='poster'><a href="form_offer.php">Post an offer</a></button>
            <?php endif; ?>
            <!--  Si l'utilisateur veut se déconnecter on va le redirectionner vers login.php 
            on précise le champ action=logout (le traitement est dans la partie en haut) -->
            <a href="../index.php?action=logout" class="disconnect">Disconnect</a>
         </div>
      
      </div>






        <div class="infocan">
          <!-- image candidat-->
          

            <!-- Images -->
            <div class="imagesCpntinaer">
              <?php if(!empty($ligne['photo'])): ?>
                <?php 
                  if($_SESSION['type_user']==1 || verifier($_SESSION['id'],$ligne['id_candidat'])){
                  $nomImage = $ligne['photo']; // the filename is stored in this variable
                  $cheminImage = "../register/upload1/" . $nomImage; // the path to the image is created using the filename
                  echo "<img  class='sjfdvocx' src='" . $cheminImage . "' >";}
                  else
                  echo "<img  class='sjfdvocx' src='https://cdn.stealthoptional.com/images/ncavvykf/stealth/f60441357c6c210401a1285553f0dcecc4c4489e-564x564.jpg?w=450&h=450&auto=format'>"
                ?>
              <?php else: ?>
                <img class="sjfdvocx" src="https://cdn.stealthoptional.com/images/ncavvykf/stealth/f60441357c6c210401a1285553f0dcecc4c4489e-564x564.jpg?w=450&h=450&auto=format" alt="" srcset="">
              <?php endif; ?>
            </div>

            <div class="jackdaniel">
              


            <div class="rowInfoos">
              <span>Informations Générales</span>
            </div>

            <div class="rowInfoos">
            </div>
              <div class="rowInfoos">
                <div class="j">
                  Nom complet
                </div>
                <div class="g">
                  <?php   
                    echo $ligne['nom']
                  ?>
                  &nbsp;
                  <?php   
                    echo $ligne['prenom']
                  ?>
                </div>
              </div>
              <div class="rowInfoos">
                <div class="j">
                  Adresse Email 
                </div>
                <div class="g">
                  <?php   
                   if($ligne["email_contact"] === "" || $ligne["email_contact"] === null){
                      echo "----";
                   }
                   else{
                    echo $ligne['email_contact'];
                   }
                  ?>
                </div>
              </div>

              <div class="rowInfoos">
                <div class="j">
                  Telephone
                </div>
                <div class="g">
                  <?php   
                   if($ligne["num_tel"] === "" || $ligne["num_tel"] === null){
                      echo "----";
                   }
                   else{
                    echo $ligne['num_tel'];
                   }
                  ?>
                </div>
              </div>

              <div class="rowInfoos">
                <div class="j">
                  Domaine
                </div>
                <div class="g">
                  <?php   
                   if($ligne["nom_domaine"] === "" || $ligne["nom_domaine"] === null){
                      echo "----";
                   }
                   else{
                    echo $ligne['nom_domaine'];
                   }
                  ?>
                </div>
              </div>

              <div class="rowInfoos">
                <div class="j">
                  Curriculum Vitae
                </div>
                <div class="g">
                  <a class="cva" href="cv/<?=$ligne['cv']?>" download="<?=$ligne['nom'].' cv'?>">Télécharger</a>
                </div>
              </div>  


              <div class="rowInfoos">
<!-- Cette partie pour le recrutteur pour contacter le candidat  -->              
                <?php if(isset( $_SESSION['type_user']) && $_SESSION['type_user'] == 1):?>
                  <a href="send.php"><button class="contacter">Contacter</button></a>
                <?php endif ?>
              </div>


              <div class="rowInfoos">
              </div>
              <div class="rowInfoos">
                <span>Compétences primaires</span>
              </div>


              <div class="rowInfoos rowInfoos2" >
                <?php foreach ($compro as $key => $comp): ?>
                      <em><?=$comp['nom_comp']?></em>
                    <?php if($key !=(count($compro) - 1)):?>
                    ,&nbsp;&nbsp;
                    <?php endif ?> 
                <?php endforeach?>
              </div>


              <div class="rowInfoos">
              </div>
              <div class="rowInfoos">
                <span>Compétences Secondaires</span>
              </div>

              <div class="rowInfoos rowInfoos2" >
              <?php foreach ($comps as $key => $comp): ?>
                    <em ><?=$comp['nom_comp']?></em>
                   <?php if($key !=(count($comps) - 1)):?>
                   ,&nbsp;&nbsp;
                   <?php endif ?> 
                   <?php endforeach?>
              </div>
             

              <div class="rowInfoos">
              </div>
              
              <div class="rowInfoos">
                <span>Expérience Professionelle</span>
              </div>
              
              <?php foreach ($exp as $exps): ?>
                <div class="rowInfoos">
                  <strong class="zxs"><?=$exps['description']?></strong>
                  <p><?=$exps['nom_entreprise']?></p>
                  <p><?=$exps['date_debut']?>
                  <strong class="storngjjj">/</strong>
                  <?=$exps['date_fin']?></p>
                </div>
              <?php endforeach?>


              
              <div class="rowInfoos">
              </div>
              <div class="rowInfoos">
                <span>Formation</span>
              </div>

              <?php foreach ($edu as $edus): ?>
                <div class="rowInfoos">
                    <strong class="zxs"><?=$edus['options'] .' '.$edus['filiere']?></strong>
                    <p><?=$edus['nom_ecole']?></p>
                    <p><?=$edus['date_debut']?>
                    <strong class="storngjjj">/</strong>
                    <?php if(!empty($edus['date_fin'])):?>
                    <?=$edus['date_fin']?></p>
                    <?php endif?>
                </div>
              <?php endforeach?>

              <div class="rowInfoos"></div>
              <div class="rowInfoos"></div>
              <div class="rowInfoos"></div>
                      
</body>
</html>
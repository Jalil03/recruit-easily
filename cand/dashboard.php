<?php
require('util.php');
require('database.php');
init_php_session();
if(!isset($_SESSION['type_user']))
$_SESSION['type_user']=2;
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
// made by Jl

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

// made by jl

$competence;

$requete = "SELECT * FROM `competences`";
// retrieve distinct countries from the database
$stmt = $PDO->prepare($requete);
$stmt->execute();
$competence = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styling1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

  </head>
  <style>
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
<body>

   <!-- Navbar part --> 
   <div class="containerxxx">
      <div class="logo">
      <img src="../images/logoW.jpg" alt="">
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
       <?php if(isset($_SESSION['type_user']) && $_SESSION['type_user'] != 1): ?>

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
         <?php if(isset( $_SESSION['type_user']) && $_SESSION['type_user']==1): ?>
            <button class="disconnect disconnect2" name='poster'><a href="form_offer.php">Post an offer</a></button>
            <?php endif; ?>
            <!--  Si l'utilisateur veut se déconnecter on va le redirectionner vers login.php 
            on précise le champ action=logout (le traitement est dans la partie en haut de index) -->
            <a href="../index.php?action=logout" class="disconnect">Disconnect</a>
         </div>
      
      </div>

      <div class="search">
        <form method="POST" id="form">
            <label for="domaine">Choisis un domain:</label>&nbsp;&nbsp;&nbsp;
            <select name="domaine" id="domaine">
                <option value="0">Select un domain</option>
                <?php foreach($domaines as $domaine) 
                  echo "<option value=".$domaine['id_domaine'].">".$domaine['nom_domaine']."</option>";
                ?>
            </select>&nbsp;&nbsp;&nbsp;
            <label for="position">Choisie une position:</label>&nbsp;&nbsp;&nbsp;
            <select name="position" id="position">
                <option value="0">Select a position:</option>
                <?php foreach($postes as $poste) 
                  echo "<option value=".$poste['id_poste'].">".$poste['nom_poste']."</option>";
                ?>
            </select>
            
        </form>
      </div>


      <!-- Score button PopUp--><!-- Score button PopUp--><!-- Score button PopUp--><!-- Score button PopUp-->
      <?php 
        if($_SESSION['type_user'] == 1){
      ?>
      <div class="search">
        <button class="customize" id="btnShowPopUp" >Customize your score</button>
      </div>
      <?php
        }
      ?>
      <div id="popUpScore" class="popUp">
        <form id="iefqdc"  method="post" action="searchBasedOnRecruiterChoice.php" class="container">
            <div id="closeContainer" class="closeContainer">
              <i class="fa-solid fa-xmark"></i>
            </div>
            <div class="containerCompp">
            <?php
              foreach ($competence as $row) {
                  echo "<button type='button' class='btnCompetence' onclick='highlightButton(this)'>";
                  echo $row["nom_comp"];
                  echo "</button>";
                }
              ?>
            </div>
            <div class="jz">
            <input type="hidden" id="competenceInput" name="competence" value="<?php echo htmlspecialchars(json_encode($competence)); ?>">
            <button class="submiiit" name="submitiha" type="submit">
              Submit
            </button>
            
            </div>
        </form>
      </div>








  <!-- La partie qui va contenir la liste des candidats ! -->
   <div class="jack">
       <?php if (!empty($candidats)) :?> <!-- Si la requête renvoie des enregistrements on va les affichers -->
         <?php foreach ($candidats as $candidat): ?>
       
        <div class="boxrounded">
          <div id="cs" class="">
              <div class="haut">
                    <!-- La partie qui va contenir les images des candidats  ! -->
                <?php if(!empty($candidat['photo'])): ?>
              <?php 
              
              if($_SESSION['type_user']==1 || verifier($_SESSION['id'],$candidat['id_candidat'])){
                $nomImage = $candidat['photo']; // the filename is stored in this variable
                $cheminImage = "../register/upload1/" . $nomImage; // the path to the image is created using the filename
                echo "<img  width='100px' height='90px' src='" . $cheminImage . "' >";}
                else
                echo "<img  width='100px' height='auto' src='https://cdn.stealthoptional.com/images/ncavvykf/stealth/f60441357c6c210401a1285553f0dcecc4c4489e-564x564.jpg?w=450&h=450&auto=format'>"
                ?>
                
              <?php else: ?>
                <img src="https://cdn.stealthoptional.com/images/ncavvykf/stealth/f60441357c6c210401a1285553f0dcecc4c4489e-564x564.jpg?w=450&h=450&auto=format" class="logo" width="100px" height="auto">
                <?php endif; ?> 
                    <!-- la fin pour le  traitement d'image associe a chaque candidat   ! -->
              </div>
              
              <!-- Pour afficher le score seulement au candidat  -->     
              
              
              <?php if($_SESSION['type_user'] == 1): ?>
    <h4><?php echo $candidat['prenom']; echo "&nbsp;&nbsp;"; echo $candidat['nom']; echo "&nbsp;&nbsp;"; echo $candidat['score']; ?></h4>
<?php else: ?>
    <h4><?php echo $candidat['prenom']; echo "&nbsp;&nbsp;"; echo $candidat['nom']; ?></h4>
<?php endif; ?>

                <h5 class="mt-3">Domaine : <?= $candidat['nom_domaine'] ?></h5>
              <h5 class="mt-3"><strong>Position:</strong> <?= $candidat['nom_poste'] ?></h5>    
                
              <a href="infocan.php?id=<?=$candidat['id_candidat']?>" class="voirProfil">
                  <button name="submit" class="submit">
                    Voir le Profile
                  </button>
              </a>
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

      <script>
        const x = document.getElementById('btnShowPopUp');
        const popUpScore = document.getElementById('popUpScore');
        const closeContainer = document.getElementById('closeContainer');
        const iefqdc = document.getElementById('iefqdc');

        x.addEventListener('click', ()=>{
          popUpScore.className = "popUp showPopUp";
        });

        closeContainer.addEventListener('click', ()=>{
          popUpScore.className = "popUp"
        });

      </script>
        <script>

            const competenceInput = document.getElementById('competenceInput');
            function updateCompetenceInput() {
              competenceInput.value = JSON.stringify(competence);
            } 


            let competence = new Array();

            function highlightButton(button) {
                // Vérifier si le bouton est "cliqué" ou "décliqué"
                if (button.className === "clicked") {
                    // Si le bouton est "cliqué", le décliquer et retirer son texte de l'array
                    button.className = "";
                    let index = competence.indexOf(button.textContent);
                    if (index !== -1) {
                        competence.splice(index, 1);
                    }
                } else {
                    // Si le bouton est "décliqué", le cliquer et ajouter son texte à l'array
                    button.className = "clicked";
                    competence.push(button.textContent);
                }
                updateCompetenceInput();
            }

            
        </script>

<script>
function toggleDropdown() {
    var dropdownContent = document.getElementById('dp');
    if (dropdownContent.style.display === 'block') {
        dropdownContent.style.display = 'none';
    } else {
        dropdownContent.style.display = 'block';
    }
}
</script>


</body>
</html>

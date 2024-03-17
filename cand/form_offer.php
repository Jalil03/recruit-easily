    <?php
       

// when in dashboard clicked on post an offer we will be redirected to this page (ofc hadi l recruteur )

      include('database.php');
      include('util.php');
      init_php_session() ;
      if(!isset($_SESSION['id'])){
        header('location:login.php');
      }
      // On récupère les domaines de la bdd
      $stmt = $PDO->prepare("select * FROM domaine");
      $stmt->execute();
      $domaines = $stmt->fetchAll(PDO::FETCH_ASSOC);

      // On récupère les villes 
      $stmt = $PDO->prepare("select * FROM ville");
      $stmt->execute();
      $villes = $stmt->fetchAll(PDO::FETCH_ASSOC);

      // on récupère les données entrées par le recruteur pour qu'on puisse les stocker dans la base de données
      if(isset($_POST['submit'])){

        $type=$_POST['type'];
        $description=$_POST['description'];
        $date = date('Y-m-d');
        $duree=$_POST['duree'];
        $idrec=$_SESSION['id'];
        $domaine=$_POST['domaine'];
        $ville=$_POST['ville'];
        $stmt=$PDO->prepare("insert into offre (`date_publication`, `id_localisation`, `durée`, `description`, `is_active`, `offre_type`, `id_recruteur`, `id_domaine`) VALUES(:datepub,:locali,:duree,:descr,0,:typ,:rec,:dom)");

      $stmt->bindValue(':datepub',$date);
      $stmt->bindValue(':locali',$ville);
      $stmt->bindValue(':duree',$duree);
      $stmt->bindValue(':descr',$description);
      $stmt->bindValue(':typ',$type);
      $stmt->bindValue(':dom',$domaine);
      $stmt->bindValue(':rec',$idrec);
      $stmt->execute();

      header("location:Offers.php");
      }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_offer.css">
    <title>Sign up</title>
</head>
<body>

  <div class="cont navig">
        <nav id="navb" class="navbar navbar-expand-lg" >
         <a class="navbar-brand" href="./dashboard.php"><img  class="logo" src="../images/logoW.jpg"  height="auto" width="100px" alt="link" class="img"></a>
        </nav>
  </div> 

<main>
  <div class="container corps justify-content-center">
    <form action="form_offer.php" method="post">
		 <div class="col">
		  <h2>Enter the offer info:</h2>
          <div>
            <label for="stage">Internship</label>
		  <input type="radio" name="type" value="stage" id="stage"> <br>
            <label for="travail">Job</label>
		  <input type="radio" name="type" value="travail" id="travail"><br>
          </div>
          <div>
            <label for="description">Description:</label><br>
            <textarea name="description" id="description"></textarea>
          </div>
          <div>
            <label for="duree">Duration:</label><br>
            <input type="text" name="duree" id="duree">
          </div>
          <div>
          <label for="domaine">Select a domain:</label><br>
            <select name="domaine" id="domaine">
                <option value="0">Select a domain</option>
                <?php foreach($domaines as $domaine) 
                  echo "<option value=".$domaine['id_domaine'].">".$domaine['nom_domaine']."</option>";
                ?>
            </select>
          </div>
          <div>
          <label for="ville">Select a city:</label><br>
            <select name="ville" id="ville">
                <option value="0">Select a city</option>
                <?php foreach($villes as $ville) 
                  echo "<option value=".$ville['id_ville'].">".$ville['nom_ville']."</option>";
                ?>
            </select>
          </div>   
		 </div>
		
     <div class="button">
	      <button name="submit" type="submit" class="btn">Register</button>
    </div>   
  </form>
  <img src="avatar3.png"  class="b " alt="">  
</div>
</main>
</body>
</html>

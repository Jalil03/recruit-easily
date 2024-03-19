<?php
      $msg='';
      include('database.php');
      include('util.php');
      init_php_session() ;
      if(!isset($_SESSION['id'])){
        header('location:login.php');
      }
      $stmt = $PDO->prepare("SELECT * FROM domaine");
      $stmt->execute();
      $domaines = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $stmt = $PDO->prepare("SELECT * FROM ville");
      $stmt->execute();
      $villes = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $rq=$PDO->prepare('select * from offre where id_offre=?');
      $rq->execute(array($_GET['id']));
      $info=$rq->fetch();
      if(isset($_POST['submit'])){
      if(empty($_POST['domaine']) || empty($_POST['ville'])) 
      $msg='You must fill in all the fields';
      else{
      $rq=$PDO->prepare('update offre set id_localisation=?,durée=?,description=?,is_active=?,offre_type=?,id_domaine=? where id_offre=?');  
      $rq->execute(array($_POST['ville'],$_POST['duree'],$_POST['description'],$_POST['active'],$_POST['type'],$_POST['domaine'],$_GET['id']));
      header('location:Offers.php');
      }
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

<nav id="navb" class="navbar navbar-expand-lg " >
        <div class="container ">
        <a class="navbar-brand" href="../index.php"><img  class="logo" src="../images/logoW.jpg" height="60px" width="100px" alt="link" class="img"></a>
   </div> 
	</nav>
<main>
	<form action="./form_update_offre.php?id=<?=$_GET['id']?>" method="post">
       <div class="container">
		
		 <div class="col">
      <h1>Step 1</h1>
		  <h2 class="">Enter the offer info:</h2>
          <div>
            offer type: 
            <label for="stage">Stage</label>
  <input <?php if ($info['offre_type'] == 'stage'): ?>checked<?php endif ?> type="radio" name="type" value="stage" id="stage">
  
  <label for="travail">Travail</label>
  <input <?php if ($info['offre_type'] == 'travail'): ?>checked<?php endif ?> type="radio" name="type" value="travail" id="travail">
          </div>
          <div>
            <label for="description">description</label><br>
            <input value="<?=$info['description']?>" type="text" name="description" id="description">
          </div>
          <div>
            <label for="duree">duration:</label><br>
            <input value="<?=$info['durée']?>" type="text" name="duree" id="duree">
          </div>
          <div>
          <label for="domaine">Select a domain:</label>
            <select name="domaine" id="domaine">
                <option value="0">Select a domain</option>
                <?php foreach($domaines as $domaine) 
                  echo "<option value=".$domaine['id_domaine'].">".$domaine['nom_domaine']."</option>";
                ?>
            </select>
          </div>
          <div>
          <label for="ville">Select a city:</label>
            <select name="ville" id="ville">
                <option value="0">Select a city</option>
                <?php foreach($villes as $ville) 
                  echo "<option value=".$ville['id_ville'].">".$ville['nom_ville']."</option>";
                ?>
            </select>
          </div>
          <div>
            is active: 
            <label for="yes">Yes</label><input  <?php if ($info['is_active'] =='0'): ?>checked<?php endif ?>  type="radio" name="active" value="0" id="yes" >
            <label for="no">No</label> <input <?php if ($info['is_active'] =='1'): ?>checked<?php endif ?> type="radio" name="active" value="1" id="no" >
          </div>
			
       
		 </div>
		
     <div class="button">
	  <div style="color:red;"><?=$msg?></div>
	  <button name="submit" type="submit" class="btn">Update</button>
	</div>
    
</div>
       
    </form>
  
</main>
</body>
</html>
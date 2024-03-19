<?php
      
// la page pour poster une offre ( ofc recrutteur )


// la logique de cette page est de envoyes les donner du form en bas au code php ici et en vas les stockes dans la base de donne et on redirege vers Offres ou il a les offres kamlin 

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
    
    <title>Sign up</title>
    <style>
      body{ background-color:rgb(231, 227, 227);
	font-family: 'Georgia';}


.container{
	display: grid;
	grid-template-columns:  500px;
	grid-template-rows: auto;
	justify-content: center;	
	column-gap:15px ;
	margin:20px 0;
}

nav{
	margin:0;
	text-align: center;
	background-color: white;
	width: 100%;
	border-radius: 5px;
	padding:10px 0;
}

h1{	color: #37b7e1;}
input[type='file']{ border:none;}
.champ1{background-color: none;}
.champ{ margin: 8px 8px; }
.champ1{ margin: 10px 10px;}
.options{padding:10px 30px; }
.button{ text-align: center; }
input:hover{border-color:#37b7e1 }

.col{
	background-color:rgb(255, 255, 255);
	height: auto;
	padding:20px 20px;
	border-radius: 20px;
	box-shadow: 2px 2px 8px gray;
	border: 2px solid transparent;	
	
}
input[type="text"]{
	padding:8px 30px;
	border:1px solid  #cccccc;
	border-radius: 25px;
	background-color: transparent;
	height: 20px;
	width: auto;
	margin:10px 0;
}


.icon{
	text-align: center;
	width:128px;
	margin: 0 100px;
}

h2{ 
	color:#050642; 
    font-family: 'Georgia';	
}

.btn{
	margin-top: 20px;
	padding:10px 40px;
	border: none;
	font-size: larger;
	font-weight: 500;
	border-radius: 20px;
	background-color:#37b7e1;
	color:white;
	cursor:pointer;
	box-shadow:1px 1px 8px transparent;
}

.btn:hover{
	box-shadow: gray;
	opacity: 0.8;
}
.a{
	position: relative;
	bottom: 900px;
	left: 80px;
	width: 400px;
	height: 400px;
}
.col:hover{
	border-color: #37b7e1;
}
select{
	border: 1px solid #cccccc;
	border-radius: 25px;
	width:auto;
	height:30px;
	background-color:transparent;
	font-family: 'Georgia';
	color:#050642;
	margin:10px 0;
}

input[type='file']{
	width: 300px;
	height:40px ;
	background-color: transparent;
}

.b{
	position: relative;
	bottom: 450px;
	left: 750px;
	width: 350px;
	height: auto;
}	

.corps{
	margin-top:100px;
}

@media screen and (max-width:1030px)
{
	.b{display:none;}
	.col{
		max-width:400px;
	}
}
</style>
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
      <br>
            <label for="travail">Job</label>
		  <input type="radio" name="type" value="travail" id="travail"><br>
      <br>
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
	      <button name="submit" type="submit" class="btn">Send offer</button>
    </div>   
  </form>
 
</div>
</main>
</body>
</html>

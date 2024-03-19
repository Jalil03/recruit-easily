
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> 
    <link rel="stylesheet" href="../stylecandidatcomp.css">
    <?php  include('database.php'); // cette page est la page ou on va demander au candidat de enterer ces informations , les competences primaire , secondaire , exp , education , on va utiliser la page addcom pour envoyer ces donnes et calculer le score , on va aussi utiliser le script java pour ajouter/supprimer des lignes   ?>
    <style>
       select  {
  background-color: transparent;
  color:white;
  border:none;
 }
 option{
  background-color: #050642;
 }
	     .cont{
  width:100%;
  height:fit-content;
  padding:10px 0;
  background-color:#88d3dd;
 }
 .cont img{
  margin:0 50px;
  border-radius: .4rem;
}
 
    </style>
    
</head>
<body>
   <div class="cont">
         <img  class="logo" src="../images/logoW.jpg" height="60px" width="auto" alt="link" class="img">
   </div> 

  <div class="container">
  
  <form action="addcom.php" method="post">
    
	  
		 <h1>Pick your skills:</h1>
         <h3 class="pink"> Primary skills:</h3>
         <?php
         session_start();
        $i=0;
        if(isset($_SESSION['domaine']))
        {
        //requête préparée pour récupérer les compétences qui concernent le domaine choisit selon chaque candidat
         $rq5=$conn->prepare('select * from competences,domaine_comp WHERE
         competences.id_comp=domaine_comp.id_comp AND id_domaine=?');
         $rq6=$conn->prepare('select * from competences where id_comp not in (
          select id_comp from domaine_comp WHERE id_domaine=?)');
        //on exécute la requête pour le domaine qu'on a récupéré dans la page précédente
         $rq5->execute(array($_SESSION['domaine']));
         $rq6->execute(array($_SESSION['domaine']));
         echo '<table>';
         while($ligne=$rq5->fetch()){
          if($i==0){
            echo '<tr>';
          }
       
         echo '<td>'.'<input type="checkbox" class="btn-check m-5" id='.$ligne['id_comp'].' autocomplete="off" name="competence[]" value='.$ligne['id_comp'].'>'.'<label class="btn btn-outline-dark m-2" for='.$ligne['id_comp'].'>'.$ligne["nom_comp"].'</label>'.'</td>';

         $i++;
         if($i==2){ 
          echo '</tr>';
         $i=0;
         }
         }
         echo '</table>';
         echo ' <h3>Secondary skills:</h3>';
         echo '<table>';
         while($ligne=$rq6->fetch()){ 
          if($i==0){
            echo '<tr>';
          }
          echo '<td>'.'<input type="checkbox" class=" b btn-check m-5 " id='.$ligne['id_comp'].' autocomplete="off" name="competence[]" value='.$ligne['id_comp'].'>'.'<label class=" a btn btn-outline-dark m-2 " for='.$ligne['id_comp'].'>'.$ligne["nom_comp"].'</label>'.'</td>';

         $i++;
         if($i==5){ 
          echo '</tr>';
         $i=0;
         }

         }
         echo '</table>';
        
         
        }
       
         else
         {
        echo 'Vous devez choisir un domaine';
         }
    
        ?> 
        <!-- <label for="experience">expérience:</label><br> -->
        <h3 class="pink">Experience</h3>
        <table id="exp" class="table" >
          <tr>
            <th>Experience</th>
            <th> Start date </th>
            <th>  End date </th>
            <th>Company name </th>
            <th >INTERNSHIP/WORK</th>

          </tr>
          <tr>
            <td><input name="expr[]" type="text" placeholder="Enter your experience"></td>
            <td><input name="dated[]" type="date"></td>
            <td><input type="date" name="datef[]"></td>
            <td><input type="text" name="nomen[]" placeholder="Enter the company name "></td>
            <td>
            <select name="options[]" id="options">
              <option value="work">WORK</option>
              <option value="internship">INTERNSHIP</option>
            </select>
          </td>
          </tr>
        
        </table>
        <input type="submit" id="ajt"  value='add'><input type="submit"   id="sup" value='delete'><span id="msger" style="color:red;display:none;">vous avez depasse le max</span>
        <h3 class="pink">Education</h3>
        <table id="formation" class="table" >
          <tr>
            <th>Education</th>
            <th> Start date </th>
            <th>  End date </th>
            <th>School name </th>
            <th >Options</th>
          </tr>
          <tr> 
            <td><input name="educ[]" type="text" placeholder="Enter your degree name"></td>
            <td><input name="dateS[]" type="date"></td>
            <td><input type="date" name="dateE[]"></td>
            <td><input type="text" name="nameS[]" placeholder="Enter your school name "></td>
            <td>
            <select name="optionE[]" >
              <option value="bac">BAC</option>
              <option value="deug">DEUST/DEUG</option>
              <option value="lst">LST/LS</option>
              <option value="master">MASTER</option>
              <option value="cycle">CYCLE</option>
              <option value="phd">PHD</option>
            </select>
          </td>
          </tr>
        </table>
        <input type="submit" id="add"  value='add'><input type="submit"   id="delete" value='delete'><span id="msg" style="color:red;display:none;">vous avez depasse le max</span>

        <br><input type="submit" name="submit" value='submit'>
        

  </form>
  </div> 
 
  
  <script src="java.js"></script>
</body>
</html>

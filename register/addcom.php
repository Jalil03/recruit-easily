<?php
session_start();

// Déclarer un tableau vide
$tabdated = array();
$tabdatef = array();
$tabnomen = array();
$tabeduc = array();
$tabdateS = array();
$tabdateE = array();
$tabnameS = array();
$taboptionE = array();
$taboptions = array();
$tabexp= array();

if(isset($_POST['options'])){
    foreach ($_POST['options'] as $v){
        $taboptions[] = $v;
    }
}
// Parcourir le tableau $_POST['nameS'] et ajouter chaque valeur au tableau
if(isset($_POST['nameS'])){
    foreach ($_POST['nameS'] as $v){
        $tabnameS[] = $v;
    }
}
// Parcourir le tableau $_POST['educ'] et ajouter chaque valeur au tableau
if(isset($_POST['educ'])){
    foreach ($_POST['educ'] as $v){
        $tabeduc[] = $v;
    }
}

// Parcourir le tableau $_POST['dateS'] et ajouter chaque valeur au tableau
if(isset($_POST['dateS'])){
    foreach ($_POST['dateS'] as $v){
        $tabdateS[] = $v;
    }
}

// Parcourir le tableau $_POST['dateE'] et ajouter chaque valeur au tableau
if(isset($_POST['dateE'])){
    foreach ($_POST['dateE'] as $v){
        $tabdateE[] = $v;
    }
}
// Parcourir le tableau $_POST['optionE'] et ajouter chaque valeur au tableau
if(isset($_POST['optionE'])){
    foreach ($_POST['optionE'] as $v){
        $taboptionE[] = $v;
    }
}



// Parcourir le tableau $_POST['dated'] et ajouter chaque valeur au tableau
if(isset($_POST['dated'])){
    foreach ($_POST['dated'] as $v){
        $tabdated[] = $v;
    }
}

// Parcourir le tableau $_POST['datef'] et ajouter chaque valeur au tableau
if(isset($_POST['datef'])){
    foreach ($_POST['datef'] as $v){
        $tabdatef[] = $v;
    }
}

// Parcourir le tableau $_POST['nomen'] et ajouter chaque valeur au tableau
if(isset($_POST['nomen'])){
    foreach ($_POST['nomen'] as $v){
        $tabnomen[] = $v;
    }
}
if(isset($_POST['expr'])){
    foreach ($_POST['expr'] as $v){
        $tabexp[] = $v;
    }
}

 include('database.php'); 
  if(isset($_POST['submit'])){
    
  if(isset($_POST['competence'])){
    $var=$_POST['competence'];
    foreach ($var as $valeur) {
        $rq=$conn->prepare('insert into comp_candidat values (?,?)');
        $rq->execute(array($valeur,$_SESSION['id']));
        
    
    }
    }
    if(isset($_POST['aucompetence'])){
        $var=$_POST['aucompetence'];
        foreach ($var as $valeur) {
            $rq=$conn->prepare('insert into comp_candidat values (?,?)');
            $rq->execute(array($valeur,$_SESSION['id']));}
        }
    if(!empty($_POST['datef']) && !empty($_POST['nomen']) && !empty($_POST['dated']) && !empty($_POST['expr']) )   {
        for($i=0;$i<count($tabexp);$i++){
            $rq=$conn->prepare('insert into experience (description,date_debut,date_fin,nom_entreprise,type,id_candi) values (?,?,?,?,?,?)');
            $rq->execute(array($tabexp[$i],$tabdated[$i],$tabdatef[$i],$tabnomen[$i],$taboptions[$i],$_SESSION['id']));
        }
    }
    if(!empty($_POST['educ'])  && !empty($_POST['nameS']) )   {
        for($i=0;$i<count($tabdateS);$i++){
            $rq=$conn->prepare('insert into education (date_debut,date_fin,nom_ecole,options,filiere,id_candi) values (?,?,?,?,?,?)');
            $rq->execute(array($tabdateS[$i],$tabdateE[$i],$tabnameS[$i],$taboptionE[$i],$tabeduc[$i],$_SESSION['id']));
        }
    }
    
    }



$score=0;

if(isset($_POST['competence'])){
        foreach ($_POST['competence'] as $v){
     $score+=10;
        }
    }
if(isset($_POST['aucompetence'])){
        foreach ($_POST['aucompetence'] as $v){
     $score+=5;
        }
    }
    if(isset($_POST['options'])){
        foreach ($_POST['options'] as $v){
            if($v=='WORK')
            $score+=4;
            else
            $score+=2;
      
      
        }
    }
    if(isset($_POST['educ'])){
        foreach ($_POST['educ'] as $v){
      $score+=3;
      
        }
    }
    if(isset($_POST['datef']) && isset($_POST['dated'])){
        for($i=0;$i<count($tabexp);$i++){
            $d1 = date_create($tabdated[$i]);
            $d2 = date_create($tabdatef[$i]);
            $diff = date_diff($d1, $d2);//un objet renvoie
            $score+=$diff->format('%a');
        }
    }
   $rq=$conn->prepare('update candidat set score=? where id_candidat=?');
   $rq->execute(array($score,$_SESSION['id']));
   header('location:successful.php');
    ?>


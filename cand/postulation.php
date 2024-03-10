<?php
    include('database.php');
    include('util.php');
    init_php_session();
    $rq=$PDO->prepare('insert into postule values (?,?)');
    $rq->execute(array($_SESSION['id'],$_GET['id']));
header('location:Offers.php');  


?>
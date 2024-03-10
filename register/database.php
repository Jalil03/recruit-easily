<?php

$DB_DSN="mysql:host=localhost;dbname=rec";
$DB_USER="root";
$DB_PASS="";

try
{
    $conn=new PDO($DB_DSN,$DB_USER,$DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch ( PDOException $e)
{
    echo 'ERREUR: '.$e->getMessage();
    exit();
}

?>

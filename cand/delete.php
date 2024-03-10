<?php
 include('database.php');
 if(isset($_GET['id'])){
    $delete_id =$_GET['id'];
    $sql_delete = "DELETE FROM msg WHERE id_message='$delete_id' ";
    $PDO->query($sql_delete);
    if($sql_delete)
    {
    header('location:read.php');
}
 }

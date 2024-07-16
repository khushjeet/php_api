<?php
    error_reporting(0);
    include "./connection.php";
    
    $id = $_POST['id'];
    
    $sqlQuery = "DELETE FROM goods WHERE id = '$id'";
    
    $resultOfQuery = $connectNow->query($sqlQuery);
    
    if($resultOfQuery){
        echo json_encode("Deleted");
    }
    else{
        echo json_encode("NotDeleted");
    }
?>
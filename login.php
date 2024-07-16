<?php
    error_reporting(0);
    include '../connection.php';
    
    $phone = $_POST['phone'];
    $password = $_post['password'];
    
    $sqlQuery = "SELECT * FROM admins_table WHERE phone = '$phone',password = '$password'";
    
    $resultOfQuery = $connectNow->query($sqlQuery);
    
    
    if($resultOfQuery){
        echo json_encode(array("success"=>true));
    }
    else{
        echo json_encode(array("success"=>false));
    }

?>
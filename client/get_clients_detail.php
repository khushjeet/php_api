<?php 
    header("Content-type: Application/json");
    include '../connection.php';
    
    $sqlQuery = "SELECT *FROM clients WHERE 1=1";
    
    $resultOfQuery = $connectNow->query($sqlQuery);
    
    
    if($resultOfQuery >0){
        while($fetch = $resultOfQuery->fetch_assoc()){
            $clients[] = $fetch;
        }
        echo json_encode($clients);
    }
    else{
        echo json_encode("No Data");
    }
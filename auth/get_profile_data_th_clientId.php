<?php

error_reporting(0);

include '../connection.php';


$clientId = $_POST['clientId'];


$sqlQuery = "SELECT * FROM clients WHERE clientsId = '$clientId'";


$resultOfQuery = $connectNow->query($sqlQuery);

if($resultOfQuery->num_rows>0){
   // $data = array();
    while($fetchData = mysqli_fetch_assoc($resultOfQuery)){
        $data[]=$fetchData;
    }
    echo json_encode($data[0]);
}
else{
    echo json_encode("Data Not Found");
}



?>
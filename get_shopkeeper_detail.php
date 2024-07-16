<?php
error_reporting(0);
include "./connection.php";

$sqlQuery = "SELECT * FROM 	shopkeeper WHERE 1";

$resultOfQuery = $connectNow->query($sqlQuery);

if($resultOfQuery->num_rows > 0){
    while($fetch = $resultOfQuery->fetch_assoc()){
        $data[] = $fetch;
    }
    echo json_encode($data);
}
else{
    echo json_encode("No Data Found");
}

?>
<?php

include '../connection.php';

$userVehicle = $_POST['vehicalNumber'];

$sqlQuery = "SELECT * FROM users_table WHERE vehicle_number ='$userVehicle'";

$resultOfQuery = $connectNow->query($sqlQuery);

if($resultOfQuery->num_rows > 0) 
{
    //num rows length == 1 --- email already in someone else use 
    echo json_encode(array("vehicle_number"=>true));
}
else
{
    //num rows length == 0 --- email is NOT already in someone else use
    // a user will allowed to signUp Successfully
    echo json_encode(array("vehicle_number"=>false));
}




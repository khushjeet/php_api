<?php
error_reporting(E_ALL);
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");
include "./connection.php";

// Check connection
if ($connectNow->connect_error) {
    die(json_encode(array(
        "success" => false,
        "message" => "Connection failed: " . $connectNow->connect_error
    )));
}



$vendorId = $_POST['vendorId'];
 
 $sqlQuery= "SELECT * FROM availableVehiclePostedByDriver WHERE 1";


$resultOfQuery = $connectNow->query($sqlQuery);

$load = array();

if ($resultOfQuery->num_rows > 0) {

    while ($fetch = mysqli_fetch_assoc($resultOfQuery)) {
        $load[] = $fetch;
    }
    echo json_encode(array(
        "success"=>true,
        "driverload"=>$load
        ));
} else {
    echo json_encode(array(
        "success" => false,
        "message" => "No Rows Found"
    ));
}

$connectNow->close();
?>

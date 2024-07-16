<?php
error_reporting(0);
header("Content-Type: application/json");
include '../connection.php';


// Check connection
if ($connectNow->connect_error) {
    die(json_encode(array(
        "success" => false,
        "message" => "Connection failed: " . $connectNow->connect_error
    )));
}



$vendorId = $_POST['vendorId'];
 
 $sqlQuery= "SELECT * FROM postLoadByClients WHERE clientsId='$vendorId' ORDER BY postedTiming DESC";


$resultOfQuery = $connectNow->query($sqlQuery);

$load = array();

if ($resultOfQuery->num_rows > 0) {

    while ($fetch = mysqli_fetch_assoc($resultOfQuery)) {
        $load[] = $fetch;
    }
    echo json_encode(array(
        "success"=>true,
        "load"=>$load
        ));
} else {
    echo json_encode(array(
        "success" => false,
        "message" => "No Rows Found"
    ));
}

$connectNow->close();
?>

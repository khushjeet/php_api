<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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

$sqlQuery = "SELECT * FROM postLoadByClients WHERE pickUPDate >= CURDATE() ORDER BY time DESC";

$resultOfQuery = $connectNow->query($sqlQuery);

$load = array();

if ($resultOfQuery === false) {
    echo json_encode(array(
        "success" => false,
        "message" => "Query Error: " . $connectNow->error
    ));
    $connectNow->close();
    exit();
}

if ($resultOfQuery->num_rows > 0) {
    while ($fetch = $resultOfQuery->fetch_assoc()) {
        $load[] = $fetch;
    }
    echo json_encode($load);
} else {
    echo json_encode(array(
        "success" => false,
        "message" => "No Rows Found"
    ));
}

$connectNow->close();
?>

<?php
error_reporting(0);
header("Content-type:application/json");
header("Access-control-allow-Method:POST");
header("Access-controll-allow-Origin: *");

include './connection.php';

$id = $_POST["id"];
$descriptions = $_POST["descriptions"]; 
$rate = $_POST["rate"];
$goods_measure_units = $_POST['goods_measure_units'];

// Fetch current data
$sqlFetch = "SELECT * FROM goods WHERE id = '$id'";
$resultFetch = $connectNow->query($sqlFetch);

if ($resultFetch->num_rows > 0) {
    $currentData = $resultFetch->fetch_assoc();
   
    // Prepare updated data
    $updateData = [
        'descriptions' => $descriptions ?: $currentData['descriptions'],
        'rate' => $rate ?: $currentData['rate'],
        'goods_measure_units' => $goods_measure_units? : $goods_measure_units['goods_measure_units']
    ];

    // Prepare SQL statement to prevent SQL injection
    $sqlUpdate = "
        UPDATE goods
        SET 
            descriptions = '{$updateData['descriptions']}', 
            rate = '{$updateData['rate']}',
            goods_measure_units	= '{$goods_measure_units['goods_measure_units']}'
        WHERE id = '$id'
    ";

    $resultUpdate = $connectNow->query($sqlUpdate);

    if ($resultUpdate) {
        echo json_encode(array("updated" => true));
    } else {
        echo json_encode(array("updated" => false, "error" => $connectNow->error));
    }
} else {
    echo json_encode(array("updated" => false, "error" => "item not found"));
}
?>

<?php
error_reporting(0);
include "../connection.php";

$shopkeeper_id = $_POST['shopkeeper_id'];
$rejected_item_description = $_POST['rejected_item_description'];
$created_po_id = $_POST['created_po_id'];
$total = $_POST['total'];
$remarks = $_POST['remarks'];
$time_of_created_new_po = $_POST['time_of_created_new_po'];

$sqlQuery = "INSERT INTO rejected_po 
               (shopkeeper_id, time, rejected_item_description, remarks, created_po_id, total,time_of_created_new_po) 
             VALUES (?, CURRENT_TIMESTAMP(), ?, ?, ?, ?,?)";

// Prepare the statement
$stmt = $connectNow->prepare($sqlQuery);
if ($stmt === false) {
    echo json_encode(array('success' => false, 'error' => 'Prepare failed: ' . $connectNow->error));
    exit;
}

// Bind the parameters
$stmt->bind_param("ssssss", $shopkeeper_id, $rejected_item_description, $remarks, $created_po_id, $total,$time_of_created_new_po);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false, 'error' => $stmt->error));
}

// Close the statement
$stmt->close();

// Close the connection
$connectNow->close();
?>

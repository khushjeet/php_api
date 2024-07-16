<?php
error_reporting(0);
include "../connection.php";

$shopkeeper_id = $_POST['shopkeeper_id'];
$time_of_created_new_po = $_POST['time_of_created_new_po'];
$descriptions = $_POST['descriptions'];
$created_po_id = $_POST['created_po_id'];
$total_amount = $_POST['total_amount'];
$sqlQuery = "INSERT INTO open_po 
               (shopkeeper_id, time, time_of_created_new_po, aprovels,descriptions,created_po_id,total_amount) 
             VALUES (?,CURRENT_TIMESTAMP(), ?, 0,?,?,?)";

// Prepare the statement
$stmt = $connectNow->prepare($sqlQuery);
if ($stmt === false) {
    echo json_encode(array('successs' => false, 'error' => 'Prepare failed: ' . $connectNow->error));
    exit;
}

// Bind the parameters
$stmt->bind_param("sssss", $shopkeeper_id,  $time_of_created_new_po,$descriptions,$created_po_id,$total_amount);

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

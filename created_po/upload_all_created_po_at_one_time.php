<?php
include "../connection.php";

$shopkeeper_id = $_POST['shopkeeper_id'];
$goods_id = $_POST['item_all_detail'];
$final_total_amout = $_POST['final_total_amout']; 
// Assuming this is being posted

$sqlQuery = "INSERT INTO upload_all_atems_at_one_time 
               (shopkeeper_id, item_all_detail, time, final_total_amout) 
               VALUES (?, ?, CURDATE(), ?)";

// Prepare the statement
$stmt = $connectNow->prepare($sqlQuery);
if ($stmt === false) {
    echo json_encode(array('success' => false, 'error' => 'Prepare failed: ' . $connectNow->error));
    exit;
}

// Bind the parameters
$stmt->bind_param("sss", $shopkeeper_id, $goods_id, $final_total_amout);

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

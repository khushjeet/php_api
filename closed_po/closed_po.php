<?php
include "../connection.php";
header("Content-type: application/json; charset=utf-8");

// Ensure the table exists
$createTableQuery = "
    CREATE TABLE IF NOT EXISTS closed_po (
        id INT AUTO_INCREMENT PRIMARY KEY,
        shopkeeper_id INT NOT NULL,
        item_id INT NOT NULL,
        aprovels VARCHAR(255),
        time VARCHAR(255),
        time_of_created_new_po VARCHAR(255),
        created_po_id VARCHAR(255),
        descriptions TEXT,
        total_amount VARCHAR(255)
    )
";

if ($connectNow->query($createTableQuery) === false) {
    echo json_encode(array('success' => false, 'error' => 'Table creation failed: ' . $connectNow->error));
    exit;
}

// Retrieve the POST data
$shopkeeper_id = $_POST['shopkeeper_id'];
$item_id = $_POST['item_id'];
$aprovels = $_POST['aprovels'];
$time = $_POST['time'];
$time_of_created_new_po = $_POST['time_of_created_new_po'];
$created_po_id = $_POST['created_po_id'];
$descriptions = $_POST['descriptions'];
$total_amount = $_POST['total_amount'];

// Prepare the INSERT query
$sqlQuery = "
    INSERT INTO closed_po (
        shopkeeper_id, 
        item_id, 
        aprovels, 
        time, 
        time_of_created_new_po, 
        created_po_id, 
        descriptions, 
        total_amount
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
";

// Initialize the statement
$stmt = $connectNow->prepare($sqlQuery);

if ($stmt === false) {
    echo json_encode(array('success' => false, 'error' => 'Prepare failed: ' . $connectNow->error));
    exit;
}

// Bind parameters
$stmt->bind_param(
    "iissssss", 
    $shopkeeper_id, 
    $item_id, 
    $aprovels, 
    $time, 
    $time_of_created_new_po, 
    $created_po_id, 
    $descriptions, 
    $total_amount
);

// Execute the query
if ($stmt->execute()) {
    echo json_encode(array('success' => true, 'message' => 'Record inserted successfully'));
} else {
    echo json_encode(array('success' => false, 'error' => 'Execute failed: ' . $stmt->error));
}

// Close the statement and the connection
$stmt->close();
$connectNow->close();
?>

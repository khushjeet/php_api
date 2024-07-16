<?php
include "../connection.php";
header("Content-type: application/json; charset=utf-8");

// Prepare the SELECT query
$sqlQuery = "SELECT * FROM upload_all_atems_at_one_time ";

// Execute the query
$result = $connectNow->query($sqlQuery);

// Check if the query was successful
if ($result === false) {
    echo json_encode(array('success' => false, 'error' => 'Query failed: ' . $connectNow->error));
    exit;
}

// Fetch all rows and store them in an array
$data = array();
while ($row = $result->fetch_assoc()) {
    // Decode the JSON string in 'item_all_detail'
    $row['item_all_detail'] = json_decode($row['item_all_detail'], true);
    $data[] = $row;
}

// Output the data in JSON format
echo json_encode(array('success' => true, 'data' => $data));

// Close the connection
$connectNow->close();
?>

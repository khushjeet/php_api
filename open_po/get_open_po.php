<?php
include "../connection.php";
header("Content-type: application/json; charset=utf-8");

// Prepare the SELECT query
$sqlQuery = "SELECT * FROM  created_new_po";

// Execute the query
$result = $connectNow->query($sqlQuery);

// Check if the query was successful
if ($result === false) {
    echo json_encode(array('success' => false, 'error' => 'Query failed: ' . $connectNow->error));
    exit;
}

// Check if any rows were returned
if ($result->num_rows === 0) {
    echo json_encode(array('success' => true, 'data' => [], 'message' => 'No data found'));
    exit;
}

// Fetch all rows and store them in an array
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Output the data in JSON format
echo json_encode(array('success' => true, 'data' => $data));

// Close the connection
$connectNow->close();
?>

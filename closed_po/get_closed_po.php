<?php
include "../connection.php";
header("Content-type: application/json; charset=utf-8");

$id = $_POST['id'];

// Prepare the SELECT query
$sqlQuery = "
    SELECT * FROM closed_po 
    JOIN open_po 
    ON closed_po.open_po_id = open_po.id
    WHERE open_po.shopkeeper_id = ?
";

// Initialize the statement
$stmt = $connectNow->prepare($sqlQuery);

if ($stmt === false) {
    echo json_encode(array('success' => false, 'error' => 'Prepare failed: ' . $connectNow->error));
    exit;
}

// Bind parameters
$stmt->bind_param("i", $id);

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if the query was successful
if ($result === false) {
    echo json_encode(array('success' => false, 'error' => 'Execute failed: ' . $stmt->error));
    exit;
}

// Fetch all rows and store them in an array
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Output the data in JSON format
echo json_encode(array('success' => true, 'data' => $data));

// Close the statement and the connection
$stmt->close();
$connectNow->close();
?>

<?php
include "../connection.php";
header("Content-type: application/json; charset=utf-8");

// Retrieve the ID from POST request and sanitize it
$id = isset($_POST['id']) ? $connectNow->real_escape_string($_POST['id']) : '';

// Check if the ID is provided
if (empty($id)) {
    echo json_encode(array('success' => false, 'error' => 'ID is required'), JSON_PRETTY_PRINT);
    exit;
}

// Prepare the SELECT query using prepared statements to prevent SQL injection
$sqlQuery = $connectNow->prepare("SELECT * FROM closed_po WHERE id = ?");
$sqlQuery->bind_param("s", $id);

// Execute the query
$sqlQuery->execute();
$result = $sqlQuery->get_result();

// Check if the query was successful
if ($result === false) {
    echo json_encode(array('success' => false, 'error' => 'Query failed: ' . $connectNow->error), JSON_PRETTY_PRINT);
    exit;
}

// Check if any rows were returned
if ($result->num_rows === 0) {
    echo json_encode(array('success' => true, 'data' => [], 'message' => 'No data found'), JSON_PRETTY_PRINT);
    exit;
}

// Fetch all rows and store them in an array
$data = array();
while ($row = $result->fetch_assoc()) {
    // Decode the descriptions field from JSON string to an array
    if (isset($row['descriptions'])) {
        $row['descriptions'] = json_decode($row['descriptions'], true);
    }
    $data[] = $row;
}

// Output the data in JSON format with pretty print
echo json_encode(array('success' => true, 'data' => $data), JSON_PRETTY_PRINT);

// Close the statement and connection
$sqlQuery->close();
$connectNow->close();
?>

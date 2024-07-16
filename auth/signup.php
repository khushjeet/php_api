<?php
// Enable error reporting for development (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../connection.php";

// Retrieve POST data
$clientsName = $_POST["clientsName"];
$clientsPhone = $_POST["clientsPhone"];
$clientsPassword = $_POST["clientsPassword"];

// Prepare the SQL statement with placeholders
$query = "
    INSERT INTO clients (
        clientsName, 
        clientsPhone, 
        clientsPassword, 
        clientsCreatedTime
    ) VALUES (?, ?, ?, CURRENT_TIMESTAMP())
";

// Prepare the statement
$stmt = $connectNow->prepare($query);
if ($stmt === false) {
    echo json_encode(array('success' => false, 'error' => 'Prepare failed: ' . $connectNow->error));
    exit;
}

// Bind the parameters
$stmt->bind_param("sss", $clientsName, $clientsPhone, $clientsPassword);

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

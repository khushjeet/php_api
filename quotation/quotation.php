<?php
// Enable error reporting for development (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
$connectionFilePath = "./connection.php";
if (!file_exists($connectionFilePath)) {
    echo json_encode(array('success' => false, 'error' => 'Connection file not found'));
    exit;
}
require_once $connectionFilePath;

// Retrieve POST data
$postLoadByClients = $_POST["postLoadByClients"];
$mobile = $_POST["mobile"];

// Prepare the SQL statement with placeholders
$query = "
    INSERT INTO quatotation (
        postLoadByClients,
        mobile,
        time
    ) VALUES (?, ?, CURRENT_TIMESTAMP())
";

// Prepare the statement
$stmt = $connectNow->prepare($query);
if ($stmt === false) {
    echo json_encode(array('success' => false, 'error' => 'Prepare failed: ' . $connectNow->error));
    exit;
}

// Bind the parameters
$stmt->bind_param("ss", $postLoadByClients, $mobile);

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

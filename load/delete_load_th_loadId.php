<?php

// Enable error reporting for development (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../connection.php";

// Check if LoadId is set and not empty
if (!empty($_POST['LoadId'])) {
    $LoadId = $_POST['LoadId'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $connectNow->prepare("DELETE FROM postLoadByClients WHERE LoadId  = ?");
    
    // Bind parameters
    $stmt->bind_param("s", $LoadId);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode("deleted");
    } else {
        echo json_encode("Unsccuess");
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode("LoadId not set");
}

// Close the database connection
$connectNow->close();

?>

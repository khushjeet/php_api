<?php

// Enable error reporting for development (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../connection.php";

// Check if LoadId is set and not empty
if (!empty($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare the SQL statement to prevent SQL injection
    if ($stmt = $connectNow->prepare("DELETE FROM upload_all_atems_at_one_time WHERE id = ?")) {

        // Bind parameters
        $stmt->bind_param("s", $id);

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(array("deleted" => true));
        } else {
            echo json_encode(array("deleted" => false, "error" => $stmt->error));
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(array("deleted" => false, "error" => $connectNow->error));
    }
} else {
    echo json_encode(array("deleted" => false, "error" => "Id not set or empty"));
}

// Close the database connection
$connectNow->close();

?>

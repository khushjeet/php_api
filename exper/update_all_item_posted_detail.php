<?php
// Database connection parameters
include '../connection.php';

// Check connection
if ($connectNow->connect_error) {
    die("Connection failed: " . $connectNow->connect_error);
}

// Parameters for the update
$id = isset($_POST['id']) ? $_POST['id'] : null;
$description = isset($_POST['description']) ? $_POST['description'] : null;
$cgst = isset($_POST['cgst']) ? $_POST['cgst'] : null;
$rate = isset($_POST['rate']) ? $_POST['rate'] : null;
$total = isset($_POST['total']) ? $_POST['total'] : null;
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;

// Ensure all required parameters are provided
if ($id !== null && $description !== null && $cgst !== null && $rate !== null && $total !== null && $quantity !== null) {
    // SQL query to update the fields
    $sql = "UPDATE upload_all_atems_at_one_time 
            SET description = ?, 
                cgst = ?, 
                rate = ?, 
                total = ?, 
                quantity = ? 
            WHERE id = ?";

    // Prepare and bind
    $stmt = $connectNow->prepare($sql);
    $stmt->bind_param("ssssii", $description, $cgst, $rate, $total, $quantity, $id);

    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
} else {
    echo "Error: Missing required parameters.";
}

$connectNow->close();
?>

<?php
include "../connection.php";

$id = $_POST['id']; // Assuming you're passing the id to identify the record
$aprovels_by_admin = isset($_POST['aprovels_by_admin']) ? $_POST['aprovels_by_admin'] : null;

// If aprovels_by_admin is not set in the POST request, fetch the current value
if ($aprovels_by_admin === null) {
    $fetchQuery = "SELECT aprovels_by_admin FROM created_new_po WHERE id = ?";
    $fetchStmt = $connectNow->prepare($fetchQuery);
    $fetchStmt->bind_param("i", $id);
    $fetchStmt->execute();
    $fetchStmt->bind_result($aprovels_by_admin);
    $fetchStmt->fetch();
    $fetchStmt->close();
}

// Prepare the update statement
$updateQuery = "UPDATE created_new_po SET aprovels_by_admin = ?, time = CURRENT_TIMESTAMP() WHERE id = ?";

// Prepare the statement
$stmt = $connectNow->prepare($updateQuery);
if ($stmt === false) {
    echo json_encode(array('success' => false, 'error' => 'Prepare failed: ' . $connectNow->error));
    exit;
}

// Bind the parameters
$stmt->bind_param("ii", $aprovels_by_admin, $id);

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

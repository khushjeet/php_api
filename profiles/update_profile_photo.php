<?php
include "../connections.php"; // Ensure this file is properly secured
// Enable error reporting for debugging
error_reporting(0);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the driver ID and ensure it's a valid integer
    $driver_id = isset($_POST['driver_id']) ? intval($_POST['driver_id']) : 0;

    // Check if the driver ID and file are set and valid
    if ($driver_id > 0 && isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        // Set the target directory and file path
        $target_dir = "../uploads/driver_profile/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);

        // Debugging information
        error_log("Target directory: " . $target_dir);
        error_log("Target file: " . $target_file);

        // Move the uploaded file
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // File upload succeeded, update the database
            $driver_profile_image = $target_file; // Path to the uploaded file

            // Prepare and execute the database update query
            $stmt = $connectNow->prepare("UPDATE drivers SET driver_profile_image = ? WHERE driver_id = ?");
            if ($stmt) {
                $stmt->bind_param("si", $driver_profile_image, $driver_id);

                if ($stmt->execute()) {
                    echo json_encode(array("success" => true));
                } else {
                    echo json_encode(array("success" => false, "error" => "Database update failed."));
                }

                $stmt->close();
            } else {
                echo json_encode(array("success" => false, "error" => "Database query preparation failed."));
            }
        } else {
            echo json_encode(array("success" => false, "error" => "File upload failed."));
        }
    } else {
        echo json_encode(array("success" => false, "error" => "Invalid input. Check driver_id or file upload error."));
    }
} else {
    echo json_encode(array("success" => false, "error" => "Invalid request method."));
}
?>

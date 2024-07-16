<?php
include "../connection.php"; // Ensure this file is properly secured

// Enable detailed error reporting for debugging
error_reporting(0);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '../logs/php_errors.log');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the driver ID and ensure it's a valid integer
    $driver_id = isset($_POST['driver_id']) ? intval($_POST['driver_id']) : 0;

    // Check if the driver ID and file are set and valid
    if ($driver_id > 0 && isset($_FILES['insurance'])) {
        if ($_FILES['insurance']['error'] == UPLOAD_ERR_OK) {
            // Set the target directory and file path
            $target_dir = "../uploads/vehical_registration/insurance/";

            // Create the target directory if it does not exist
            if (!is_dir($target_dir)) {
                if (!mkdir($target_dir, 0777, true)) {
                    error_log("Failed to create directory: " . $target_dir);
                    echo json_encode(array("success" => false, "error" => "Failed to create upload directory."));
                    exit;
                }
            }

            // Generate a unique file name to avoid overwriting existing files
            $file_extension = pathinfo($_FILES["insurance"]["name"], PATHINFO_EXTENSION);
            $unique_file_name = uniqid('insurance_', true) . '.' . $file_extension;
            $target_file = $target_dir . $unique_file_name;

            // Debugging information
            error_log("Target directory: " . $target_dir);
            error_log("Target file: " . $target_file);

            // Check if the target directory is writable
            if (!is_writable($target_dir)) {
                error_log("Target directory is not writable: " . $target_dir);
                echo json_encode(array("success" => false, "error" => "Upload directory is not writable."));
                exit;
            }

            // Move the uploaded file
            if (move_uploaded_file($_FILES["insurance"]["tmp_name"], $target_file)) {
                // File upload succeeded, update the database
                $insurance = $target_file; // Path to the uploaded file

                // Prepare and execute the database update query
                $stmt = $connectNow->prepare("UPDATE drivers SET insurance = ? WHERE driver_id = ?");
                if ($stmt) {
                    $stmt->bind_param("si", $insurance, $driver_id);

                    if ($stmt->execute()) {
                        echo json_encode(array("success" => true));
                    } else {
                        error_log("Database update failed: " . $stmt->error);
                        echo json_encode(array("success" => false, "error" => "Database update failed."));
                    }

                    $stmt->close();
                } else {
                    error_log("Database query preparation failed: " . $connectNow->error);
                    echo json_encode(array("success" => false, "error" => "Database query preparation failed."));
                }
            } else {
                error_log("move_uploaded_file failed. Source: " . $_FILES["insurance"]["tmp_name"] . " Target: " . $target_file . " Error: " . $_FILES["insurance"]["error"]);
                echo json_encode(array("success" => false, "error" => "File upload failed. Unable to move the uploaded file."));
            }
        } else {
            error_log("File upload error: " . $_FILES['insurance']['error']);
            echo json_encode(array("success" => false, "error" => "File upload error. Code: " . $_FILES['insurance']['error']));
        }
    } else {
        error_log("Invalid input. Check driver_id or file upload error.");
        echo json_encode(array("success" => false, "error" => "Invalid input. Check driver_id or file upload error."));
    }
} else {
    error_log("Invalid request method.");
    echo json_encode(array("success" => false, "error" => "Invalid request method."));
}
?>

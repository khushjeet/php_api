<?php
include "../connection.php"; // Ensure this file is properly secured

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log errors to a file for debugging
ini_set('log_errors', 1);
ini_set('error_log', '../logs/php_errors.log');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the driver ID and ensure it's a valid integer
    $driver_id = isset($_POST['driver_id']) ? intval($_POST['driver_id']) : 0;

    // Check if the driver ID is valid
    if ($driver_id > 0) {
        $target_dir = "../uploads/vehical_registration/vehical_photos/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Validate and upload files
        $files = ['vehical_photos_front','vehical_photos_left', 'vehical_photos_right', 'vehical_photos_back'];
        $uploaded_files = [];

        $allowed_file_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_file_size = 6 * 1024 * 1024; // 6MB

        foreach ($files as $file_field) {
            if (isset($_FILES[$file_field]) && $_FILES[$file_field]['error'] == UPLOAD_ERR_OK) {
                $file_type = mime_content_type($_FILES[$file_field]["tmp_name"]);
                $file_size = $_FILES[$file_field]["size"];

                if (!in_array($file_type, $allowed_file_types)) {
                    echo json_encode(array("success" => false, "error" => "Invalid file type for $file_field. Allowed types: JPEG, PNG, GIF."));
                    exit;
                }

                if ($file_size > $max_file_size) {
                    echo json_encode(array("success" => false, "error" => "File size exceeds the limit of 6MB for $file_field."));
                    exit;
                }

                $file_extension = '';
                switch ($file_type) {
                    case 'image/jpeg':
                        $file_extension = 'jpg';
                        break;
                    case 'image/png':
                        $file_extension = 'png';
                        break;
                    case 'image/gif':
                        $file_extension = 'gif';
                        break;
                }

                $unique_file_name = $file_field . '_' . time() . '.' . $file_extension;
                $target_file = $target_dir . $unique_file_name;

                if (move_uploaded_file($_FILES[$file_field]["tmp_name"], $target_file)) {
                    $uploaded_files[$file_field] = $target_file;
                } else {
                    echo json_encode(array("success" => false, "error" => "File upload failed for $file_field."));
                    exit;
                }
            } elseif (isset($_FILES[$file_field]) && $_FILES[$file_field]['error'] != UPLOAD_ERR_NOFILE) {
                echo json_encode(array("success" => false, "error" => "Error uploading file $file_field. Error code: " . $_FILES[$file_field]['error']));
                exit;
            }
        }

        // Prepare the parameters to bind
        $vehical_photos_front = $uploaded_files['vehical_photos_front'] ?? null;
        $vehical_photos_left = $uploaded_files['vehical_photos_left'] ?? null;
        $vehical_photos_right = $uploaded_files['vehical_photos_right'] ?? null;
        $vehical_photos_back = $uploaded_files['vehical_photos_back'] ?? null;

        // Ensure the database connection is established
        if ($connectNow->connect_error) {
            error_log("Connection failed: " . $connectNow->connect_error);
            echo json_encode(array("success" => false, "error" => "Database connection failed."));
            exit;
        }

        // Update the database with new information
        $query = "UPDATE drivers SET vehical_photos_front = ?, vehical_photos_left = ?, vehical_photos_right = ?, vehical_photos_back = ? WHERE driver_id = ?";
        $stmt = $connectNow->prepare($query);

        if ($stmt) {
            $stmt->bind_param(
                "ssssi",
                
                $vehical_photos_front,
                $vehical_photos_left,
                $vehical_photos_right,
                $vehical_photos_back,
                 $driver_id
               
            );

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
        echo json_encode(array("success" => false, "error" => "Invalid driver ID."));
    }
} else {
    echo json_encode(array("success" => false, "error" => "Invalid request method."));
}
?>

<?php
include "../connection.php"; // Ensure this file is properly secured


error_reporting(0);

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log errors to a file for debugging
ini_set('log_errors', 1);
ini_set('error_log', '../logs/php_errors.log');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the driver ID and ensure it's a valid integer
    $driver_id = isset($_POST['driver_id']) ? intval($_POST['driver_id']) : 0;

    // Get other fields and ensure they are properly received
    $aadhar_number = isset($_POST['aadhar_number']) ? trim($_POST['aadhar_number']) : '';
    $driving_license_number = isset($_POST['driving_license_number']) ? trim($_POST['driving_license_number']) : '';

    // Check if the driver ID is valid
    if ($driver_id > 0) {
        $target_dir = "../uploads/driver_documents/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Validate and upload files
        $files = ['adhar_card_img', 'adhar_card_back_img', 'driving_lic_front_img', 'driving_lic_back_img'];
        $uploaded_files = [];

        $allowed_file_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_file_size = 6 * 1024 * 1024; // 2MB

        foreach ($files as $file_field) {
            if (isset($_FILES[$file_field]) && $_FILES[$file_field]['error'] == UPLOAD_ERR_OK) {
                $file_type = mime_content_type($_FILES[$file_field]["tmp_name"]);
                $file_size = $_FILES[$file_field]["size"];

                if (!in_array($file_type, $allowed_file_types)) {
                    echo json_encode(array("success" => false, "error" => "Invalid file type for $file_field. Allowed types: JPEG, PNG, GIF."));
                    exit;
                }

                if ($file_size > $max_file_size) {
                    echo json_encode(array("success" => false, "error" => "File size exceeds the limit of 2MB for $file_field."));
                    exit;
                }

                $file_extension = pathinfo($_FILES[$file_field]["name"], PATHINFO_EXTENSION);
                $unique_file_name = uniqid($file_field . '_', true) . '.' . $file_extension;
                $target_file = $target_dir . $unique_file_name;

                if (move_uploaded_file($_FILES[$file_field]["tmp_name"], $target_file)) {
                    $uploaded_files[$file_field] = $target_file;
                } else {
                    echo json_encode(array("success" => false, "error" => "File upload failed for $file_field."));
                    exit;
                }
            } elseif (isset($_FILES[$file_field]) && $_FILES[$file_field]['error'] != UPLOAD_ERR_NO_FILE) {
                echo json_encode(array("success" => false, "error" => "Error uploading file $file_field. Error code: " . $_FILES[$file_field]['error']));
                exit;
            }
        }

        // Prepare the parameters to bind
        $adhar_card_img = $uploaded_files['adhar_card_img'] ?? null;
        $adhar_card_back_img = $uploaded_files['adhar_card_back_img'] ?? null;
        $driving_lic_front_img = $uploaded_files['driving_lic_front_img'] ?? null;
        $driving_lic_back_img = $uploaded_files['driving_lic_back_img'] ?? null;

        // Update the database with new information
        $query = "UPDATE drivers SET aadhar_number = ?, driving_license_number = ?, adhar_card_img = ?, adhar_card_back_img = ?, driving_lic_front_img = ?, driving_lic_back_img = ? WHERE driver_id = ?";
        $stmt = $connectNow->prepare($query);

        if ($stmt) {
            $stmt->bind_param(
                "ssssssi",
                $aadhar_number,
                $driving_license_number,
                $adhar_card_img,
                $adhar_card_back_img,
                $driving_lic_front_img,
                $driving_lic_back_img,
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

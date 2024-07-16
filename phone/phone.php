<?php

    // Include the database connection
    error_reporting(0);
$servername = "localhost";
$username = "ankusame_root1";
$password = "Ankusam@123";
$dbname = "ankusame_vendors";

$connectNow = new mysqli($serverHost, $username, $password, $dbname);


    // Retrieve POST data
    $phone = $_POST["phone"];

    // Check if the phone number is set
    if (isset($phone)) {
        // Prepare the SQL query
        $sqlQuery = "INSERT INTO phone (phone) VALUES (?)";

        // Prepare statement
        if ($stmt = mysqli_prepare($connectNow, $sqlQuery)) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "s", $phone);

            // Execute the statement
            $resultOfQuery = mysqli_stmt_execute($stmt);

            // Check result and send response
            header('Content-Type: application/json');
            if ($resultOfQuery) {
                echo json_encode(array("success" => true));
            } else {
                echo json_encode(array("success" => false, "error" => mysqli_stmt_error($stmt)));
            }

            // Close statement
            mysqli_stmt_close($stmt);
        } else {
            // Handle statement preparation error
            header('Content-Type: application/json');
            echo json_encode(array("success" => false, "error" => mysqli_error($connectNow)));
        }
    } else {
        // Handle missing phone number
        header('Content-Type: application/json');
        echo json_encode(array("success" => false, "error" => "Phone number is required"));
    }

    // Close connection
    mysqli_close($connectNow);
?>

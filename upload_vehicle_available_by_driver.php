<?php
    // Enable error reporting for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Include the database connection
    include "./connection.php";

    // Retrieve POST data
    $driver_id = $_POST["driver_id"];
    $fromstate = $_POST["fromstate"];
    $fromcity = $_POST["fromcity"];
    $tostate = $_POST["tostate"];
    $tocity = $_POST["tocity"];
    $vehicle_capacity_in_tons = $_POST["vehicle_capacity_in_tons"];
    $typeOfVehicle = $_POST["typeOfVehicle"];
    $vehicleLength = $_POST["vehicleLength"];
    $phone = $_POST["phone"];

    // Prepare the SQL query
    $sqlQuery = "INSERT INTO availableVehiclePostedByDriver 
                 (fromState, fromCity, toState, toCity, vehicle_capacity_in_tons, vship, phone, vehicle_length, driver_id)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement
    if ($stmt = mysqli_prepare($connectNow, $sqlQuery)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssssdsdsi", $fromstate, $fromcity, $tostate, $tocity, $vehicle_capacity_in_tons, $typeOfVehicle, $phone, $vehicleLength, $driver_id);
        
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

    // Close connection
    mysqli_close($connectNow);
?>

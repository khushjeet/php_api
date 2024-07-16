<?php
include "../connection.php";

// Get the input values from the POST request
$vendorId = $_POST["vendorId"];
$FromState = $_POST["FromState"];
$FromCity = $_POST["FromCity"];
$ToState = $_POST["ToState"];
$ToCity = $_POST["ToCity"];
$VehicleType = $_POST["VehicleType"];
$PackageWeight = $_POST["PackageWeight"];
$NumberOFWheels = $_POST["NumberOfWheels"];
$GoodsType = $_POST["GoodsType"];
$VehicleLength = $_POST["VehicleLength"];
$ContactNumber = $_POST["ContactNumber"];
$PickUpDate = $_POST["PickUpDate"];
$time = $_POST['time'];
$alternativePhone = $_POST['alternativePhone'];

// Prepare the SQL query
$sqlQuery = "
    INSERT INTO postLoadByClients (
        clientsId, 
        fromState, 
        fromCity, 
        toState, 
        toCity, 
        vehicleType, 
        packageWeight, 
        numberOfWheels, 
        vehicleLength, 
        contactNumber, 
        time, 
        goodsType, 
        pickUPDate, 
        alternativePhone, 
        status, 
        postedTiming
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Active', NOW())";

// Prepare the statement
$stmt = $connectNow->prepare($sqlQuery);

if ($stmt === false) {
    die(json_encode(array(
        "success" => false,
        "message" => "Statement preparation failed: " . $connectNow->error
    )));
}

// Bind the parameters
$stmt->bind_param(
    "ssssssssssssss", 
    $vendorId, 
    $FromState, 
    $FromCity, 
    $ToState, 
    $ToCity, 
    $VehicleType, 
    $PackageWeight, 
    $NumberOFWheels, 
    $VehicleLength, 
    $ContactNumber, 
    $time, 
    $GoodsType, 
    $PickUpDate, 
    $alternativePhone
);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false, "message" => $stmt->error));
}

// Close the statement and connection
$stmt->close();
$connectNow->close();
?>

<?php

// Enable error reporting for debugging, but comment out or remove in production
// error_reporting(E_ALL);

// Include the database connection file
include "../connection.php";

// Get the input values from the POST request
$loadId = $_POST['LoadId'];
$vendorId = $_POST['vendorId'];
$fromState = $_POST['FromState'];
$fromCity = $_POST['FromCity'];
$toState = $_POST['ToState'];
$toCity = $_POST['ToCity'];
$typeOfVehicle = $_POST['TypeOfVehicle'];
$packageWeight = $_POST['PackageWeight'];
$numberOfWheels = $_POST['NumberOfWheels'];
$vehicleLength = $_POST['VehicleLength'];
$contactNumber = $_POST['ContactNumber'];
$goodsTypes = $_POST['GoodsTypes'];
$goodsPhotoOne = $_POST['GoodsPhotoOne'];
$pickUpDate = $_POST['PickUpDate'];
$status = $_POST['status'];
$alternativePhone = $_POST['alternativePhone'];
$time = $_POST['time'];

// Check connection
if ($connectNow->connect_error) {
    die(json_encode("Connection failed: " . $connectNow->connect_error));
}

// Fetch the current data from the database
$sqlFetch = "SELECT * FROM postLoadByClients WHERE LoadId = ?";
$stmtFetch = $connectNow->prepare($sqlFetch);
$stmtFetch->bind_param("s", $loadId);
$stmtFetch->execute();
$result = $stmtFetch->get_result();

if ($result->num_rows > 0) {
    $currentData = $result->fetch_assoc();

    // Prepare the update query with old data as default
    $vendorId = !empty($vendorId) ? $vendorId : $currentData['clientsId'];
    $fromState = !empty($fromState) ? $fromState : $currentData['fromState'];
    $status = !empty($status) ? $status : $currentData['status'];
    $fromCity = !empty($fromCity) ? $fromCity : $currentData['fromCity'];
    $toState = !empty($toState) ? $toState : $currentData['toState'];
    $toCity = !empty($toCity) ? $toCity : $currentData['toCity'];
    $typeOfVehicle = !empty($typeOfVehicle) ? $typeOfVehicle : $currentData['vehicleType'];
    $packageWeight = !empty($packageWeight) ? $packageWeight : $currentData['packageWeight'];
    $numberOfWheels = !empty($numberOfWheels) ? $numberOfWheels : $currentData['numberOfWheels'];
    $vehicleLength = !empty($vehicleLength) ? $vehicleLength : $currentData['vehicleLength'];
    $contactNumber = !empty($contactNumber) ? $contactNumber : $currentData['contactNumber'];
    $goodsTypes = !empty($goodsTypes) ? $goodsTypes : $currentData['GoodsTypes'];
    $goodsPhotoOne = !empty($goodsPhotoOne) ? $goodsPhotoOne : $currentData['goodsType'];
    $pickUpDate = !empty($pickUpDate) ? $pickUpDate : $currentData['pickUPDate'];
    $alternativePhone = !empty($alternativePhone) ? $alternativePhone : $currentData['alternativePhone'];
    $time = !empty($time) ? $time : $currentData['time'];

    // Prepare the SQL statement with placeholders
    $sqlUpdate = "UPDATE postLoadByClients SET 
        clientsId = ?, 
        fromState = ?, 
        fromCity = ?, 
        status = ?, 
        toState = ?, 
        toCity = ?, 
        vehicleType = ?, 
        packageWeight = ?, 
        numberOfWheels = ?, 
        vehicleLength = ?, 
        contactNumber = ?, 
        goodsType = ?, 
        pickUPDate = ?, 
        alternativePhone = ?,
        time = ?
        WHERE LoadId = ?";

    // Prepare the statement
    $stmtUpdate = $connectNow->prepare($sqlUpdate);
    if ($stmtUpdate === false) {
        die(json_encode("Statement preparation failed: " . $connectNow->error));
    }

    // Bind the parameters
    $stmtUpdate->bind_param("ssssssssssssssss", 
        $vendorId, $fromState, $fromCity, $status, $toState, $toCity, $typeOfVehicle, 
        $packageWeight, $numberOfWheels, $vehicleLength, $contactNumber, 
        $goodsTypes, $pickUpDate, $alternativePhone,$time,$loadId);

    // Execute the statement
    if ($stmtUpdate->execute()) {
        echo json_encode("Updated");
    } else {
        echo json_encode("Not Updated: " . $stmtUpdate->error);
    }

    // Close the statement and connection
    $stmtUpdate->close();
} else {
    echo json_encode("Record not found");
}

$stmtFetch->close();
$connectNow->close();

?>

<?php 
header("Content-type:application/json");
header("Access-control-allow-Method:POST");
header("Access-controll-allow-Origin: *");
include '../connection.php';

// Enable error reporting
error_reporting(0);
//ini_set('display_errors', 1);

// Retrieve POST data
$driver_id = $_POST["driver_id"];
$driver_name = $_POST["driver_name"]; 
$aadhar_number = $_POST["aadhar_number"];
$phone = $_POST["driver_mobile_number"];
$htown = $_POST["htown"];
$driving_license_number = $_POST["driving_license_number"];
$license_type = $_POST["license_type"];
$vehicle_register_number = $_POST["vehicle_register_number"];
$vehicle_make_and_model = $_POST["vehicle_make_and_model"];
$operator_type = $_POST["operator_type"];
$vehicle_name = $_POST["vehicle_name"];
$vehicle_length = $_POST["vehicle_length"];
$vehicle_capacity_in_tons = $_POST["vehicle_capacity_in_tons"];
$vehicle_type = $_POST["vehicle_type"];
$email = $_POST["email"];

// Fetch current data
$sqlFetch = "SELECT * FROM drivers WHERE driver_id = '$driver_id'";
$resultFetch = $connectNow->query($sqlFetch);

if ($resultFetch->num_rows > 0) {
    $currentData = $resultFetch->fetch_assoc();
    
    // Prepare updated data
    $updateData = [
        'name' => $driver_name ?: $currentData['name'],
        'aadhar_number' => $aadhar_number ?: $currentData['aadhar_number'],
        'phone' => $phone ?: $currentData['phone'],
        'htown' => $htown ?: $currentData['htown'],
        'driving_license_number' => $driving_license_number ?: $currentData['driving_license_number'],
        'license_type' => $license_type ?: $currentData['license_type'],
        'vehicle_register_number' => $vehicle_register_number ?: $currentData['vehicle_register_number'],
        'vehicle_make_and_model' => $vehicle_make_and_model ?: $currentData['vehicle_make_and_model'],
        'operator_type' => $operator_type ?: $currentData['operator_type'],
        'vehicle_name' => $vehicle_name ?: $currentData['vehicle_name'],
        'vehicle_length' => $vehicle_length ?: $currentData['vehicle_length'],
        'vehicle_capacity_in_tons' => $vehicle_capacity_in_tons ?: $currentData['vehicle_capacity_in_tons'],
        'vehicle_type' => $vehicle_type ?: $currentData['vehicle_type'],
        'email' => $email ?: $currentData['email']
    ];

    // Prepare SQL statement to prevent SQL injection
    $sqlUpdate = "
        UPDATE drivers 
        SET 
            name = '{$updateData['name']}', 
            aadhar_number = '{$updateData['aadhar_number']}', 
            phone = '{$updateData['phone']}', 
            htown = '{$updateData['htown']}', 
            driving_license_number = '{$updateData['driving_license_number']}', 
            license_type = '{$updateData['license_type']}', 
            vehicle_register_number = '{$updateData['vehicle_register_number']}', 
            vehicle_make_and_model = '{$updateData['vehicle_make_and_model']}', 
            operator_type = '{$updateData['operator_type']}', 
            vehicle_name = '{$updateData['vehicle_name']}', 
            vehicle_length = '{$updateData['vehicle_length']}', 
            vehicle_capacity_in_tons = '{$updateData['vehicle_capacity_in_tons']}', 
            vehicle_type = '{$updateData['vehicle_type']}', 
            email = '{$updateData['email']}'
        WHERE driver_id = '$driver_id'
    ";

    $resultUpdate = $connectNow->query($sqlUpdate);

    if ($resultUpdate) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, "error" => $connectNow->error));
    }
} else {
    echo json_encode(array("success" => false, "error" => "Driver not found"));
}

?>

<?php 
header("Content-type:application/json");

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
   
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: POST, OPTIONS"); // Allowed methods

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

include './connection.php';

$phone  = $_POST['phone'];
$password = $_POST['password'];

$sqlQuery = "SELECT * FROM admins_table WHERE phone = '$phone' AND password = '$password'";

$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery->num_rows > 0) {
    $userRecord = array();
    while ($rowFound = $resultOfQuery->fetch_assoc()) {
        $userRecord[] = $rowFound;
    }

    echo json_encode(array(
        "status" => true,
        "userData" => $userRecord[0]
    ));
} else {
    echo json_encode(array("status" => false));
}
?>

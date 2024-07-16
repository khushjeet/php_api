
<?php 
	header("Content-type:application/json");
	header("Access-control-allow-Method:POST");
	header("Access-controll-allow-Origin: * ");
	include './connection.php';
	
	
// Enable error reporting
error_reporting(0);
 
 $vehicle_number = $_POST['vehicle_number'];
 
 
  $sqlQuery="SELECT *FROM drivers
    WHERE vehicle_number  = '$vehicle_number'
    
    ";
    

$resultOfQuery = $connectNow->query($sqlQuery);



if ($resultOfQuery->num_rows > 0) {

    while ($fetch = mysqli_fetch_assoc($resultOfQuery)) {
        $load[] = $fetch;
    }
     echo json_encode(array(
        "status" => true,
        "userData" => $userRecord[0]
    ));
    echo json_encode(
        
        $load[0]
        );
} else {
    echo json_encode(array(
        "success" => false,
        "message" => "No Rows Found"
    ));
}

$connectNow->close();
?>

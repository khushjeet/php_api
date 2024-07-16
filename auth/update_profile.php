<?php

error_reporting(0); // Enable error reporting for debugging
ini_set('display_errors', 1); // Display errors

include "../connection.php";

// Check if connection is successful
if ($connectNow->connect_error) {
    die("Connection failed: " . $connectNow->connect_error);
}

// Function to check if all expected POST variables are set
function validate_post_vars($vars) {
    foreach ($vars as $var) {
        if (!isset($_POST[$var])) {
            return false;
        }
    }
    return true;
}

$expected_vars = ['clientId', 'clientsName', 'clientsPhone', 'clientsEmail', 'clientsAlternativeNumber', 'clientsAddress', 'clientsState', 'clientsCity'];

if (validate_post_vars($expected_vars)) {
    $clientId = $_POST['clientId'];
    $clientsName = $_POST['clientsName'];
    $clientsPhone = $_POST['clientsPhone'];
    $clientsEmail = $_POST['clientsEmail'];
    $clientsAlternativeNumber = $_POST['clientsAlternativeNumber'];
    $clientsAddress = $_POST['clientsAddress'];
    $clientsState = $_POST['clientsState'];
    $clientsCity = $_POST['clientsCity'];

    // Fetch the existing data
    $sqlFetch = "SELECT * FROM clients WHERE clientsId = ?";
    $stmtFetch = $connectNow->prepare($sqlFetch);
    if ($stmtFetch === false) {
        die("Prepare failed: " . $connectNow->error);
    }
    $stmtFetch->bind_param("s", $clientId);
    $stmtFetch->execute();
    $result = $stmtFetch->get_result();

    if ($result->num_rows > 0) {
        $currentData = $result->fetch_assoc();


        // Check which fields need to be updated
        $clientsName = !empty($clientsName) ? $clientsName : $currentData['clientsName'];
        $clientsPhone = !empty($clientsPhone) ? $clientsPhone : $currentData['clientsPhone'];
        $clientsEmail = !empty($clientsEmail) ? $clientsEmail : $currentData['clientsEmail'];
        $clientsAlternativeNumber = !empty($clientsAlternativeNumber) ? $clientsAlternativeNumber : $currentData['clientsAlternativeNumber'];
        $clientsAddress = !empty($clientsAddress) ? $clientsAddress : $currentData['clientsAddress'];
        $clientsState = !empty($clientsState) ? $clientsState : $currentData['clientsState'];
        $clientsCity = !empty($clientsCity) ? $clientsCity : $currentData['clientsCity'];
        $profilePercentage = !empty($profilePercentage) ? $profilePercentage : $currentData['profilePercentage'];

        $profilePercentage=0;
        $count = 25;
      

        $profilePercentage = $clientsEmail==="" || $clientsEmail==="0" ?$count:$count=$count+20;
        

        if( $clientsAlternativeNumber ===""|| $clientsAlternativeNumber ==="0"){
            $profilePercentage =$count;
        }
        else{
            $profilePercentage =$count+15;

           
        }


      if($clientsAddress===""||$clientsAddress==="0"||$clientsAddress===null){
        $profilePercentage =$profilePercentage;
    }else{
       $profilePercentage = $profilePercentage+30;
    }
   

        if($clientsState==="" || $clientsState==="0" ||$clientsState ===null  ){
        $profilePercentage =$profilePercentage;
        }
        else{
            $profilePercentage=$profilePercentage+5;
        }
       
       if( $clientsCity==="" || $clientsCity==="0" ||$clientsCity ===null  ){
       $profilePercentage =$profilePercentage;
       }
       else{
      $profilePercentage=$profilePercentage+5;
       }
        

       

        // Prepare an update statement
        $stmt = $connectNow->prepare("UPDATE clients SET clientsName = ?, clientsPhone = ?, clientsEmail = ?, clientsAlternativeNumber = ?, 
            clientsAddress = ?, clientsState = ?,
             clientsUpdatedTime = CURRENT_TIMESTAMP(), profilePercentage=?,clientsCity = ? WHERE clientsId = ?");
        if ($stmt === false) {
            die("Prepare failed: " . $connectNow->error);
        }

        $bind = $stmt->bind_param("sssssssss", $clientsName, $clientsPhone, $clientsEmail, $clientsAlternativeNumber, $clientsAddress, $clientsState,$profilePercentage ,$clientsCity, $clientId);
        if ($bind === false) {
            die("Bind failed: " . $stmt->error);
        }

        // Execute the statement
        $execute = $stmt->execute();
        if ($execute) {
            echo json_encode("updated");
        } else {
            echo json_encode("Not Updated: " . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode("Record not found");
    }

    $stmtFetch->close();
} else {
    echo json_encode("Invalid Input");
}

// Close the connection
$connectNow->close();

?>

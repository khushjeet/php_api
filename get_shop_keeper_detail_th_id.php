<?php
error_reporting(0);
include "./connection.php";

$id = $_POST['id'];

// Prepare the SQL statement to prevent SQL injection
$sqlQuery = $connectNow->prepare("SELECT * FROM shopkeeper WHERE id = ?");
$sqlQuery->bind_param("s", $id);

// Execute the query
$sqlQuery->execute();
$resultOfQuery = $sqlQuery->get_result();

if($resultOfQuery->num_rows > 0){
    while($fetch = $resultOfQuery->fetch_assoc()){
        $data[0] = $fetch; // Append each row to the $data array
    }
    echo json_encode($data);
} else {
    echo json_encode("No Data Found");
}

// Close the statement and the connection
$sqlQuery->close();
$connectNow->close();
?>

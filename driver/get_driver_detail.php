<?php 
header("Content-type: application/json");
include '../connection.php';

// Set default limit to 15 if not provided
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 15;

// Correct SQL query syntax
$sqlQuery = "SELECT * FROM drivers LIMIT $limit";

$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery && $resultOfQuery->num_rows > 0) {
    while ($fetch = $resultOfQuery->fetch_assoc()) {
        $driver[] = $fetch;
    }
    echo json_encode($driver);
} else {
    echo json_encode("No Data");
}
?>

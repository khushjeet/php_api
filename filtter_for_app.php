<?php
header('Content-Type: application/json');
include './connection.php';

$fromState = isset($_GET['fromState']) ? $_GET['fromState'] : '';
$fromCity = isset($_GET['fromCity']) ? $_GET['fromCity'] : '';
$toCity = isset($_GET['toCity']) ? $_GET['toCity'] : '';
$packageWeight = isset($_GET['packageWeight']) ? $_GET['packageWeight'] : '';

$query = "SELECT * FROM postLoadByClients WHERE pickUPDate = CURDATE()";

if ($fromState != '') {
    $query .= " AND fromState = '$fromState'";
}

if ($fromCity != '') {
    $query .= " AND fromCity = '$fromCity'";
}

if ($toCity != '') {
    $query .= " AND toCity = '$toCity'";
}

if ($packageWeight != '') {
    $query .= " AND packageWeight = '$packageWeight'";
}

$result = mysqli_query($connectNow, $query);

$loadData = array();

while($row = mysqli_fetch_assoc($result)) {
    $loadData[] = $row;
}

echo json_encode($loadData);

mysqli_close($connectNow);
?>

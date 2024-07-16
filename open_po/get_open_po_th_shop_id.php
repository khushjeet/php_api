<?php
include "../connection.php";
header("Content-type: application/json; charset=utf-8");

$shopkeeper_id = isset($_POST['shopkeeper_id']) ? $_POST['shopkeeper_id'] : null;

if ($shopkeeper_id) {
    $sqlQuery = "SELECT * FROM open_po WHERE shopkeeper_id = ?";
    $stmt = $connectNow->prepare($sqlQuery);
    $stmt->bind_param("s", $shopkeeper_id);

    if ($stmt->execute()) {
        $resultOfQuery = $stmt->get_result();

        if ($resultOfQuery->num_rows > 0) {
            $data = [];
            while ($row = $resultOfQuery->fetch_assoc()) {
                // Decode the JSON string to an array
                $row['descriptions'] = json_decode($row['descriptions'], true);
                $data[] = $row;
            }
            echo json_encode($data);
        } else {
            echo json_encode([]);
        }
    } else {
        echo json_encode(["error" => "Query execution failed"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "shopkeeper_id not provided"]);
}

$connectNow->close();
?>

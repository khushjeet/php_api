<?php
include "../connection.php";
header("Content-type: application/json; charset=utf-8");

$id = isset($_POST['id']) ? $_POST['id'] : null;

if ($id) {
    $sqlQuery = "SELECT * FROM shopkeeper WHERE id = ?";
    $stmt = $connectNow->prepare($sqlQuery);
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        $resultOfQuery = $stmt->get_result();

        if ($resultOfQuery->num_rows > 0) {
            $data = [];
            while ($row = $resultOfQuery->fetch_assoc()) {
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
    echo json_encode(["error" => "id not provided"]);
}

$connectNow->close();
?>

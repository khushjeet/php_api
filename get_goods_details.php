<?php
include './connection.php';
header("Content-type: application/json");

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if shopkeeper_id is set
if(isset($_POST['shopkeeper_id'])) {
    $shopkeeper_id = $_POST['shopkeeper_id'];

    // Prepare and execute the SQL query using a prepared statement
    $query = "
        SELECT * FROM shopkeeper 
        JOIN goods 
        ON shopkeeper.id = goods.shopkeeper_id
        WHERE shopkeeper.id = ?
    ";
    
    if ($stmt = $connectNow->prepare($query)) {
        $stmt->bind_param("i", $shopkeeper_id);  // Assuming shopkeeper_id is an integer
        $stmt->execute();
        $resultOfQuery = $stmt->get_result();

        if ($resultOfQuery->num_rows > 0) {
            $favoriteRecord = array();
            while ($rowFound = $resultOfQuery->fetch_assoc()) {
                $favoriteRecord[] = $rowFound;
            }

            echo json_encode(
                array(
                    "success" => true,
                    "data" => $favoriteRecord,
                )
            );
        } else {
            echo json_encode(array("success" => false, "message" => "No records found"));
        }

        $stmt->close();
    } else {
        echo json_encode(array("success" => false, "message" => "SQL query preparation failed: " . $connectNow->error));
    }
} else {
    echo json_encode(array("success" => false, "message" => "shopkeeper_id not set"));
}

$connectNow->close();
?>

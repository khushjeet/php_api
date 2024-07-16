<?php
header("Content-Type: application/json");
include '../connection.php';

// Get all shopkeeper IDs
$selQuery = "SELECT shopkeeper_id FROM upload_all_atems_at_one_time";
$resultOfSelQuery = $connectNow->query($selQuery);

if ($resultOfSelQuery) {
    $shopkeeperIDs = [];
    while ($row = $resultOfSelQuery->fetch_assoc()) {
        $shopkeeperIDs[] = $row['shopkeeper_id'];
    }

    // Check if there are any IDs to process
    if (!empty($shopkeeperIDs)) {
        $ids = implode(",", $shopkeeperIDs);

        // Get names of shopkeepers based on their IDs
        $sqlQuery = "SELECT name ,id FROM shopkeeper WHERE id IN ($ids)";
        $resultOfQuery = $connectNow->query($sqlQuery);

        if ($resultOfQuery) {
            $shopkeeperNames = [];
            while ($row = $resultOfQuery->fetch_assoc()) {
                $shopkeeperNames[] = $row;
            }

            echo json_encode([
                'status' => 'true',
                'data' => $shopkeeperNames
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to fetch shopkeeper names',
                'error' => $connectNow->error // Added error message
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No shopkeeper IDs found'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch shopkeeper IDs',
        'error' => $connectNow->error // Added error message
    ]);
}
?>

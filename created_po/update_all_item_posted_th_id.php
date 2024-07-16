<?php
include '../connection.php'; // Ensure this includes the database connection and sets $connectNow

// Parameters to update
$new_rate = "1300";
$new_quantity = 5;
$goods_id_to_update = 48;
$id_to_update = 34; // Change this to the ID you want to update

// Fetch the current JSON data from the database for the given ID
$sql = "SELECT id, item_all_detail FROM upload_all_atems_at_one_time WHERE id = ?";
$stmt = $connectNow->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $connectNow->error);
}

$stmt->bind_param("i", $id_to_update);

if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the data
    $row = $result->fetch_assoc();
    $id = $row['id'];
    $item_all_detail = json_decode($row['item_all_detail'], true);

    // Update the JSON data
    foreach ($item_all_detail as &$item) {
        if ($item['goods_id'] == $goods_id_to_update) {
            $item['rate'] = $new_rate;
            $item['quantity'] = $new_quantity;
        }
    }

    // Encode the updated JSON data
    $updated_item_all_detail = json_encode($item_all_detail);

    // Update the database with the new JSON data
    $update_sql = "UPDATE upload_all_atems_at_one_time SET item_all_detail = ? WHERE id = ?";
    $update_stmt = $connectNow->prepare($update_sql);

    if (!$update_stmt) {
        die("Prepare failed: " . $connectNow->error);
    }

    $update_stmt->bind_param("si", $updated_item_all_detail, $id);

    if ($update_stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $update_stmt->error;
    }

    $update_stmt->close();
} else {
    echo "No records found";
}

$stmt->close();
$connectNow->close();
?>

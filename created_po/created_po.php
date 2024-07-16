<?php
    include "../connection.php";
    
    $shopkeeper_id = $_POST['shopkeeper_id'];
    $goods_id = $_POST['goods_id'];
    $quantity = $_POST['quantity'];
    $cgst = $_POST['cgst'];
    $sgst  = $_POST['sgst'];
    $total = $_POST['total'];
    $igst = $_POST['igst'];
    $sqlQuery = "INSERT INTO  created_new_po 
               ( shopkeeper_id,
                	goods_id,
                	quantity,
                	cgst,
                	sgst,
                	total,
                	time,
                	aprovels_by_admin,igst) 
                	VALUES (?,?,?,?,?,?,CURRENT_TIMESTAMP(),0,?)
    ";

// Prepare the statement
$stmt = $connectNow->prepare($sqlQuery);
if ($stmt === false) {
    echo json_encode(array('success' => false, 'error' => 'Prepare failed: ' . $connectNow->error));
    exit;
}

// Bind the parameters
$stmt->bind_param("sssssss",$shopkeeper_id,$goods_id, $quantity,$cgst,$sgst,$total,$igst);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false, 'error' => $stmt->error));
}

// Close the statement
$stmt->close();

// Close the connection
$connectNow->close();


?>
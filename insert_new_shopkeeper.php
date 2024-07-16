<?php

error_reporting(0);

include './connection.php';

$name = $_POST['name'];
$address = $_POST['address'];
$state = $_POST['state'];
$mobile = $_POST['phone'];
$gst = $_POST['gst'];

$sqlQuery = "INSERT INTO 
shopkeeper 
SET
	name = '$name',
    address = '$address',
	state = '$state',
    mobile = '$mobile',
	gst = '$gst'
";

$resultOfQuery = $connectNow->query($sqlQuery);


if($resultOfQuery){

echo json_encode(array("success"=>true));
}
else{
echo json_encode(array("success"=>false));
}

?>
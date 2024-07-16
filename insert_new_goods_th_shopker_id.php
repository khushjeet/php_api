<?php

error_reporting(0);

include './connection.php';

$shopkeeper_id = $_POST['shopkeeper_id'];
$descriptions = $_POST['descriptions'];
$rate = $_POST['rate'];
$goods_measure_units = $_POST['goods_measure_units'];
$part_no = $_POST['part_no'];
$cgst=$_POST['cgst'];
$sgst=$_POST['sgst'];
$isgst=$_POST['isgst'];
$sqlQuery = "INSERT INTO 
goods 
SET
	shopkeeper_id = '$shopkeeper_id',
    descriptions = '$descriptions',
	rate = '$rate',
	goods_measure_units	= '$goods_measure_units',
	part_no = '$part_no',
	cgst='$cgst',
	sgst = '$sgst',
	isgst = '$isgst'
";

$resultOfQuery = $connectNow->query($sqlQuery);


if($resultOfQuery){

echo json_encode(array("success"=>true));
}
else{
echo json_encode(array("success"=>false));
}

?>
<?php
error_reporting(0);
include '../connection.php';

$clientsPhone = $_POST['clientsPhone'];

$sqlQuery = "SELECT * FROM clients WHERE clientsPhone ='$clientsPhone'";

$resultOfQuery = $connectNow->query($sqlQuery);

if($resultOfQuery->num_rows > 0) 
{

    echo json_encode(array("emailFound"=>true));
}
else
{
 
    echo json_encode(array("emailFound"=>false));
}




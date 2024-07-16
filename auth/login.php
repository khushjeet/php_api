<?php

error_reporting(0);
include '../connection.php';

//POST = send/save data to mysql db
//GET = retrieve/read data from mysql db

$clientsPhone = $_POST['clientsPhone'];
$clientsPassword = $_POST['clientsPassword']; 

$sqlQuery = "SELECT * FROM clients WHERE clientsPhone  = '$clientsPhone' AND clientsPassword = '$clientsPassword'";

$resultOfQuery = $connectNow->query($sqlQuery);

if($resultOfQuery->num_rows > 0) //allow user to login 
{
    $userRecord = array();
    while($rowFound = $resultOfQuery->fetch_assoc())
    {
        $userRecord[] = $rowFound;
    }

    echo json_encode(
        array(
            "success"=>true,
            "userData"=>$userRecord[0],
        )
    );
}
else //Do NOT allow user to login 
{
    echo json_encode(array("success"=>false));
}

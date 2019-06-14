<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
ini_set("memory_limit","512M");
set_time_limit(0);
ini_set('max_input_time', 3600);

include 'database.php';



for ($i=1; $i < 15560 ; $i++) { 
    
    $query1 = "SELECT Visit_Date FROM PatientVisit WHERE PatientRegistrationNo = '$i' AND PatientVisitID = '1'";

    $dateData = mysqli_query($con,$query1);

    $visitDate = mysqli_fetch_assoc($dateData);
    
    $visitDate =  $visitDate['Visit_Date'];
    // print_r($visitDate);exit;
    if($visitDate != '')
    {
        $visitDate = date("d-m-Y",strtotime($visitDate));
    }

    $query = "UPDATE patientregistration SET `RegistrationDate` =  '$visitDate' WHERE RegistrationNo = '$i'";

    if(!mysqli_query($con,$query))
    {
        echo mysql_error($con);
    }
    else
    {
        echo "<pre>";
        echo mysqli_affected_rows($con);
        echo "</pre>";
        flush();
    }
}

?>
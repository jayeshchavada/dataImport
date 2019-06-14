<?php
//////////////////////////////////

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
ini_set("memory_limit","512M");
set_time_limit(0);
ini_set('max_input_time', 3600);

//////////////////////////////////

include 'database.php';

$query = "SELECT OpdRegNo FROM patientregistration";

$run = $con->query($query);

while($AllOPD = mysqli_fetch_assoc($run))
{
    $OPDs[] = $AllOPD['OpdRegNo'];
}
sort($OPDs);
echo "<pre>";
print_r($OPDs);
echo "</pre>";
?>
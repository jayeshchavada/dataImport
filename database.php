<?php
//Database Credentials

$host = 'localhost';
$user = 'root';
$pass = 'pass';
$database = 'DoSoft_DrRajendraSonawane';

$con = mysqli_connect($host,$user,$pass,$database);

if(!$con)
{
	echo "error connecting the database";
}

// $host = 'localhost';
// $user = 'root';
// $pass = 'pass';
// $database = 'Test';

// $con_test = mysqli_connect($host,$user,$pass,$database);

// if(!$con_test)
// {
// 	echo "error connecting the database";
// }
?>
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

$host = 'localhost';
$user = 'root';
$pass = 'pass';
$database = 'DoSoft_DrRajendraSonawane_working';

$con_working = mysqli_connect($host,$user,$pass,$database);

if(!$con_working)
{
	echo "error connecting the database";
}
?>
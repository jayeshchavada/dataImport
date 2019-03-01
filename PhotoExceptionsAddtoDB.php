<?php
//////////////////////////////////

//error_reporting(E_ALL | E_STRICT);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 'On');
ini_set("memory_limit","3072M");
ini_set('max_execution_time', 6000);

//////////////////////////////////

include_once 'database.php';

//mysqli_query($con,"TRUNCATE TABLE `PatientPhotoUpload`");

$folderpath = "/media/mkadam_admin/Transcend3/Exceptions_in_photo_conversion/sub_folders_in_patient_directory";
//$folderpath = "/media/mkadam_admin/Transcend3/Priya"; //disk 2

$issue = "Subfolder in Photopath";
//$issue = "No Content";

$disk_name = "Disk1_(Rupali)";
//$disk_name = "Disk2_(Priya)";

$folders = glob("$folderpath/*",GLOB_BRACE);

foreach ($folders as $key => $eachfolderfiles)
{
	$name = end(explode("/",$eachfolderfiles));

	$query = $con->query("INSERT INTO PhotoExceptionsDetails (pathname,issue,disk_name) VALUES ('$name','$issue','$disk_name')");

	if(!$query)
	{
		echo "<pre>";
		echo mysqli_error($con);
		echo "</pre>";
	}
}

?>
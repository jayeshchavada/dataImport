<?php
//////////////////////////////////

error_reporting(E_ALL | E_STRICT);
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 'On');
ini_set("memory_limit","3072M");
ini_set('max_execution_time', 6000);

//////////////////////////////////

include_once 'database.php';

$con->query("SET FOREIGN_KEY_CHECKS = 0");
// mysqli_query($con,"TRUNCATE TABLE `PatientPhotoUpload`");

//Path for demo convert of few patient
$folderpath 		=	"/Volumes/Transcend-P/Compressed_Photos/001";
$target_path 		=	 "/Volumes/Transcend-P/Converted_Photos/temp";

//$folderpath = "/media/mkadam_admin/Transcend3/Rupali/Psoriasis-Patients-Photos";
// $folderpath = "/media/mkadam_admin/Transcend-Pune/Priya"; //disk 2

// $target_path = "/media/mkadam_admin/Transcend-Pune/new_converted_photo";

$folders = glob("$folderpath/*",GLOB_BRACE);

$process_count = 0;

echo "Script Started At: ".date("Y-m-d H:i:s");

foreach ($folders as $key => $eachfolderfiles)
{
	if($process_count == 101)
	{
		echo "<br>"."Count Limit Reached at $process_count";
		break;
	}


	$foldername = explode("/",$eachfolderfiles);

	$foldername =	end($foldername);
	$new_foldername = explode(" ",$foldername);
	$new_foldername = array_values(array_filter($new_foldername));

	$opd_no = 	explode(" ",$foldername);
	$opd_no	=	end($opd_no);

	$reg_no = get_reg_by_opd($opd_no);


	$RandomSuffix 	=	GetRandomSuffixByReg($reg_no);

	if(count($new_foldername) == 4)
	{
		$new_foldername = $new_foldername[0]."_".$new_foldername[1]."_".$new_foldername[2]."_".$RandomSuffix;
	}
	elseif(count($new_foldername) == 3)
	{
		$new_foldername = $new_foldername[0]."_".$new_foldername[1]."_".$RandomSuffix;
	}
	elseif(count($new_foldername) > 4)
	{
		$new_foldername = $new_foldername[0]."_".$new_foldername[1]."_".$RandomSuffix;
	}
	elseif(count($new_foldername) < 3)
	{
		$new_foldername = $new_foldername[0]."_".$RandomSuffix;
	}

	$image_data = glob("$eachfolderfiles/*");
	
	foreach ($image_data as $keys => $values)
	{
		$val = exif_read_data($values);

		$date_image = $path = array();

		// if(is_dir($values))
		// {	
			// echo "<pre>";
			// print_r($val['DateTimeOriginal']);
			// echo "</pre>";
		// 	//continue;
		// }

		$image_name = explode("/",$values);

		$image_name	=	end($image_name);

		$date_image = date("Y-m-d",strtotime($val['DateTimeOriginal']));

		$path = $target_path."/".$new_foldername;

		if(!is_dir($path))
		{
			// chmod($path, 777);
			mkdir($path,0777,true);
		}

		$new_path = $path."/patient_images";

		if (!is_dir($new_path))
		{
			mkdir($new_path,0777,true);
		}

		$date_path = $new_path."/".$date_image;

		if(!is_dir($date_path))
		{
			mkdir($date_path,0777,true);
		}

		if(is_dir($date_path))
		{
			$target_image_path = $date_path."/".$image_name;

			if(!file_exists($target_image_path))
			{	
				@copy($values,$target_image_path);
			}

			$start = strpos($date_path,$new_foldername);		

			$path_for_database_table = substr($date_path,$start);
			// echo "<pre>";
			// print_r($new_foldername);
			// echo "</pre>";
			$path_for_database_table = addslashes(mysqli_real_escape_string($con,$path_for_database_table));
			
			$query 	=	"INSERT IGNORE INTO PatientPhotoUpload (PatientRegistrationNo,PhotoUploadDate,PhotoPath,created_at,updated_at) VALUES ('$reg_no','$date_image','$path_for_database_table','$date_image','$date_image')";

			$queryRun = $con->query($query);
			
			if(!$queryRun)
			{
				echo "<pre>";
				echo mysqli_error($con);
				echo "</pre>";
			}

			$image_count = count(glob("$date_path/*"));

			$update_query = "UPDATE PatientPhotoUpload SET NumberOfPhotos = '$image_count' WHERE PhotoPath = '$path_for_database_table'";

			$update = $con->query($update_query);

			if(!$con->query($update_query))
			{
				echo "<pre>";
				echo "Update_Error: ".mysqli_error($con);
				echo "</pre>";
			}
		}
	 }

	$process_count += 1;
}
		
function get_reg_by_opd($opd)
{
	if($opd != '')
	{
		$filepath = "master_files/Follow_Data/PBNEW_2019_03_13.csv";

		$handle = fopen($filepath, "r");

		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
		{
			if($data[41] == $opd)
			{
				return $data[2];	
			}
		}
	}
	else
	{
		return 111;
	}
} 

function GetRandomSuffixByReg($reg)
{
	include 'database.php';

	$query	=	"SELECT RandomSuffix FROM patientregistration WHERE RegistrationNo = '$reg' Limit 1";

	$result	=	$con->query($query);

	$data 	=	mysqli_fetch_assoc($result);

	return $data['RandomSuffix'];
}
$con->query("SET FOREIGN_KEY_CHECKS = 1");
echo "<br>"."Script Ended At: ".date("Y-m-d H:i:s");
?>
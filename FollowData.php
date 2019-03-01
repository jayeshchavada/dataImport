<?php
//////////////////////////////////

// error_reporting(E_ALL | E_STRICT);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 'On');
ini_set("memory_limit","512M");
set_time_limit(0);
ini_set('max_input_time', 3600);

//////////////////////////////////

include_once 'database.php';

$con->query("SET FOREIGN_KEY_CHECKS = 0");
// $query = mysqli_query($con,"TRUNCATE TABLE `PatientVisit`");

$error_count = 0;

$import_count = 0;

$filepath = "master_files/FOLLOW_RegNo_9531_To_14647.csv";

$handle = fopen($filepath, "r");

$loop_count = 0;

$comt_length = 0;

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

	$loop_count += 1;

	if($loop_count == 1)
	{
		continue;
	}

	$reg_no = $data[1];

	$complaints_id = array();

	$base_comment = str_replace(array('+','>'),'',$data[3]);

	if($base_comment == '')
	{	
		$complaints_id = $complaints_id;
	}
	else
	{
		if(strpos(strtolower($base_comment),'psoriasis') !== false)
		{
			array_push($complaints_id,"1");
		}
		else
		{
			similar_text('psoriasis', strtolower($base_comment), $percent_match);

			if($percent_match > 50)
			{
				array_push($complaints_id,"1");
			}
			else
			{
				$complaints_id = $complaints_id;
			}
		}
			
		if(strpos(strtolower($base_comment),'lichen planus') !== false)
		{
			array_push($complaints_id,"2");
		}
		else
		{
			similar_text('lichen planus', strtolower($base_comment), $percent_match);

			if($percent_match > 50)
			{
				array_push($complaints_id,"2");
			}
			else
			{
				$complaints_id = $complaints_id;
			}
		}

		if(strpos(strtolower($base_comment),'vitiligo') !== false)
		{
			array_push($complaints_id,"3");
		}
		else
		{
			similar_text('vitiligo', strtolower($base_comment), $percent_match);

			if($percent_match > 50)
			{
				array_push($complaints_id,"3");
			}
			else
			{
				$complaints_id = $complaints_id;
			}
		}

		if(strpos(strtolower($base_comment),'eczema') !== false)
		{
			array_push($complaints_id,"4");
		}
		else
		{
			similar_text('eczema', strtolower($base_comment), $percent_match);

			if($percent_match > 50)
			{
				array_push($complaints_id,"4");
			}
			else
			{
				$complaints_id = $complaints_id;
			}
		}
	}

	$complaints_id = implode(",", $complaints_id);

	$PatientComments = addslashes(substr(mysqli_real_escape_string($con,$data[3]),0,499));

	$comt_length += strlen($PatientComments); 

	$Visit_Date = $data[2];

	$parts = explode('/', $Visit_Date);

	$Visit_Date  = "$parts[2]-$parts[0]-$parts[1]";

	/////////////////////////////

	$import="INSERT into PatientVisit(PatientRegistrationNo,ComplaintsId,PatientComments,Visit_Date) values('$reg_no','$complaints_id','$PatientComments','$Visit_Date')";
	
	// // // /////////////////////////////

	$query = mysqli_query($con,$import);

	 
	if(!$query)
    {
 		$error_count += 1;
    	echo "<pre>";
    	echo $reg_no;
    	echo "<br>";
    	echo $Visit_Date;
    	echo "<br>";
    	echo $PatientComments;
    	echo "<br>";
    	echo mysqli_error($con);
    	echo "</pre>";
    }
    else
    {
    	$import_count += 1;
    }

	// echo "<pre>";
	// print_r($Visit_Date);	
	// echo "</pre>";

}
$con->query("SET FOREIGN_KEY_CHECKS = 1");
echo "<pre>";
// print_r($comt_length);	
// echo "<br>";
echo "Import_count: ".$import_count;
echo "<br>";
echo "Error_count: ".$error_count;
echo "<br>";
echo 'Total_Records: '.$error_count += $import_count;
echo "<br>";
echo "</pre>";
fclose($handle);
?>
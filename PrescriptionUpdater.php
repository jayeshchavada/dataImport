<?php
//////////////////////////////////

// error_reporting(E_ALL | E_STRICT);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 'On');
ini_set("memory_limit","3072M");

//////////////////////////////////

include_once 'PrescriptionLibrary.php';

$con->query("SET FOREIGN_KEY_CHECKS = 0");
// mysqli_query($con,"TRUNCATE TABLE `PatientVisitPrescriptionDetails`");

$insert_count = 0;

$loop_count = 0;

$filepath = "master_files/FOLLOW_RegNo_9531_To_14647.csv";

$handle = fopen($filepath, "r");

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

	$loop_count += 1;

	if($loop_count == 1)
	{
		continue;
	}

	// 	echo "<pre>";
	// print_r($remedy);	
	// echo "</pre>";

	//////////////////////////////////////////////////
	//////////////////////////////////////////////////

	$Visit_Date = $data[2];

	$parts = explode('/', $Visit_Date);

	$Visit_Date  = "$parts[2]-$parts[0]-$parts[1]";

	$reg_no = $data[1];

	$visit_id = mysqli_fetch_assoc($con->query("SELECT PatientVisitID FROM PatientVisit WHERE PatientRegistrationNo = '$reg_no' AND Visit_Date = '$Visit_Date' LIMIT 1"));

	// echo "<pre>";
	// print_r($visit_id);
	// echo "</pre>";

	$visit_id = $visit_id['PatientVisitID'];

	$remedy = trim($data[4]);

	if($remedy != '')
	{
		$remedy_row = explode(":",$remedy);
	}

	$potency = trim($data[6]);

	if($potency != '')
	{
		$potency_row = explode(":",$potency);
	}

	$repetition = trim($data[7]);

	if($repetition != '')
	{
		$repetition_row = explode(":",$repetition);
	}

	$dosage = $data[8];

	if($dosage != '')
	{
		$dosage_row = explode(":",$dosage);
	}
	

	$days = str_replace(" ","",$data[9]);

	$days = get_days_id($days);

	$current_date = date("Y-m-d H:i:s");

	// if(count($remedy_row) > 3)
	// {
	// 	echo "<pre>";
	// 	print_r($remedy_row);
	// 	echo "</pre>";
	// }


	////////////////////////////////////////////////
	////////////////////////////////////////////////

	isset($remedy_row[0]) ? $remedy_1 = get_remedy_id(trim($remedy_row[0])) : $remedy_1 = '';
	isset($remedy_row[1]) ? $remedy_2 = get_remedy_id(trim($remedy_row[1])) : $remedy_2 = '';
	isset($remedy_row[2]) ? $remedy_3 = get_remedy_id(trim($remedy_row[2])) : $remedy_3 = '';

	isset($potency_row[0]) ? $potency_1 = get_potency_id(trim($potency_row[0])) : $potency_1 = '';
	isset($potency_row[1]) ? $potency_2 = get_potency_id(trim($potency_row[1])) : $potency_2 = '';
	isset($potency_row[2]) ? $potency_3 = get_potency_id(trim($potency_row[2])) : $potency_3 = '';

	isset($repetition_row[0]) ? $repetition_1 = get_repetition_id(trim($repetition_row[0])) : $repetition_1 = '';
	isset($repetition_row[1]) ? $repetition_2 = get_repetition_id(trim($repetition_row[1])) : $repetition_2 = '';
	isset($repetition_row[2]) ? $repetition_3 = get_repetition_id(trim($repetition_row[2])) : $repetition_3 = '';

	isset($dosage_row[0]) ? $dosage_1 = get_dosage_id(trim($dosage_row[0])) : $dosage_1 = '';
	isset($dosage_row[1]) ? $dosage_2 = get_dosage_id(trim($dosage_row[1])) : $dosage_2 = '';
	isset($dosage_row[2]) ? $dosage_3 = get_dosage_id(trim($dosage_row[2])) : $dosage_3 = '';


	
	if(count($remedy_row) == 2)
	{
		// Inserting Exception records into Database

		if($remedy_1 == '0' || $remedy_2 == '0')
		{
			if($potency_1 == '0' || $potency_2 =='0')
			{
				$insert_exce_query = "INSERT INTO VisitPrescriptionExceptions (PatientRegistrationNo,VisitId,VisitDate,Remedy,Potency,Dosage,Repetition,Days,issues) VALUES ('$reg_no','$visit_id','$Visit_Date','$remedy','$potency','$dosage','$repetition','$days','Potency Mismatched')";
			}
			else
			{
				$insert_exce_query = "INSERT INTO VisitPrescriptionExceptions (PatientRegistrationNo,VisitId,VisitDate,Remedy,Potency,Dosage,Repetition,Days,issues) VALUES ('$reg_no','$visit_id','$Visit_Date','$remedy','$potency','$dosage','$repetition','$days','Remedy Mismatched')";
			}

			$insert_ex = $con->query($insert_exce_query);

			if(!$insert_ex)
			{
				echo "<pre>";
				print_r("Exce: ".mysqli_error($con));
				echo "</pre>";
			}
		}
		//Exception insertion end 		
		if(count($potency_row) == 1)
		{
			$potency_2 	= $potency_1;
			$repetition_2 = $repetition_1;
		}

		$insert_query = "INSERT INTO PatientVisitPrescriptionDetails (PatientRegistrationNo,VisitId,Remedy,Potency,Dosage,Repetition,Days,created_at) VALUES ('$reg_no','$visit_id','$remedy_1','$potency_1','$dosage_1','$repetition_1','$days','$current_date'), 
		('$reg_no','$visit_id','$remedy_2','$potency_2','$dosage_2','$repetition_2','$days','$current_date')";

		$insert = $con->query($insert_query);

		if($insert)
		{
			$insert_count += 2;
		}
		else
		{
			echo "<pre>";
			print_r(mysqli_error($con));
			echo "</pre>";
		}
	}
	elseif(count($remedy_row) == 3)
	{
		// Inserting Exception records into Database

		if($remedy_1 == '0' || $remedy_2 == '0' || $remedy_3 == '0')
		{
			if($potency_1 == '0' || $potency_2 =='0' || $potency_3 == '0')
			{
				$insert_exce_query = "INSERT INTO VisitPrescriptionExceptions (PatientRegistrationNo,VisitId,VisitDate,Remedy,Potency,Dosage,Repetition,Days,issues) VALUES ('$reg_no','$visit_id','$Visit_Date','$remedy','$potency','$dosage','$repetition','$days','Potency Mismatched')";
			}
			else
			{
				$insert_exce_query = "INSERT INTO VisitPrescriptionExceptions (PatientRegistrationNo,VisitId,VisitDate,Remedy,Potency,Dosage,Repetition,Days,issues) VALUES ('$reg_no','$visit_id','$Visit_Date','$remedy','$potency','$dosage','$repetition','$days','Remedy Mismatched')";
			}

			$insert_ex = $con->query($insert_exce_query);

			if(!$insert_ex)
			{
				echo "<pre>";
				print_r("Exce: ".mysqli_error($con));
				echo "</pre>";
			}
		}
		//Exception insertion end		
		if(count($potency_row) == 2 || count($potency_row) == 1)
		{
			$potency_3 	= $potency_1;
			$repetition_3 = $repetition_1;
		}

		$insert_query = "INSERT INTO PatientVisitPrescriptionDetails (PatientRegistrationNo,VisitId,Remedy,Potency,Dosage,Repetition,Days,created_at) VALUES ('$reg_no','$visit_id','$remedy_1','$potency_1','$dosage','$repetition_1','$days','$current_date'), 
		('$reg_no','$visit_id','$remedy_2','$potency_2','$dosage_2','$repetition_2','$days','$current_date'),
		('$reg_no','$visit_id','$remedy_3','$potency_3','$dosage_3','$repetition_3','$days','$current_date')";

		$insert = $con->query($insert_query);

		if($insert)
		{
			$insert_count += 3;
		}
		else
		{
			echo "<pre>";
			print_r(mysqli_error($con));
			echo "</pre>";
		}
	}
	else
	{
		// Inserting Exception records into Database
		if($remedy_1 == '0' || $remedy_2 == '0' || $remedy_3 == '0')
		{
			$insert_exce_query = "INSERT INTO VisitPrescriptionExceptions (PatientRegistrationNo,VisitId,VisitDate,Remedy,Potency,Dosage,Repetition,Days,issues) VALUES ('$reg_no','$visit_id','$Visit_Date','$remedy','$potency','$dosage','$repetition','$days','Remedy Mismatched')";

			$insert_ex = $con->query($insert_exce_query);

			if(!$insert_ex)
			{
				echo "<pre>";
				print_r("Exce: ".mysqli_error($con));
				echo "</pre>";
			}
		}
		//Exception insertion end

		get_remedy_id(trim($remedy)) !== false ? $remedy = get_remedy_id(trim($remedy)) : $remedy = '';
		get_potency_id(trim($potency)) !== false ? $potency = get_potency_id(trim($potency)) : $potency = '';
		get_repetition_id(trim($repetition)) !== false ? $repetition = get_repetition_id(trim($repetition)) : $repetition = '';
		get_dosage_id(trim($dosage)) !== false ? $dosage = get_dosage_id(trim($dosage)) : $dosage = '';

		$insert_query = "INSERT INTO PatientVisitPrescriptionDetails (PatientRegistrationNo,VisitId,Remedy,Potency,Dosage,Repetition,Days,created_at) VALUES ('$reg_no','$visit_id','$remedy','$potency','$dosage','$repetition','$days','$current_date')";

		$insert = $con->query($insert_query);

		if($insert)
		{
			$insert_count += 1;
		}
		else
		{
			echo "<pre>";
			print_r(mysqli_error($con));
			echo "</pre>";
		}
	}
}
$con->query("SET FOREIGN_KEY_CHECKS = 1");
echo "Statistics:";
echo "<br>";
echo "Inserted Records: ".$insert_count;
echo "<br>";
fclose($handle);
?>
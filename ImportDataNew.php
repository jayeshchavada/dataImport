<?php
//////////////////////////////////

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
ini_set("memory_limit","512M");
set_time_limit(0);
ini_set('max_input_time', 3600);

//////////////////////////////////

include 'database.php';

$con->query("SET FOREIGN_KEY_CHECKS = 0");
$query = mysqli_query($con,"TRUNCATE TABLE `patientregistration`");

$error_count = 0;

$import_count = 0;

$loop_count = 0;

$filepath = "master_files/Follow_Data/PBNEW_2019_03_13.csv";

$handle = fopen($filepath, "r");

$AssignedOPDNumber = '6438';

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
{
	$loop_count = $loop_count + 1;

	if($loop_count == 1)
	{
		continue;
	}
	
	$reg_no = $data[2];

	$regNo2	=	$data[0];

	$PatientDate	=	$data[3];

	$PatientDate	=	date("Y-m-d H:i:s",strtotime($PatientDate));

	// echo "<pre>";
	// print_r($data);
	// echo "</pre>";exit;

	$opd_no	=	trim($data[41]);

	$RandomSuffix	=	mt_rand(1,999999);

	$HospitalBranchId = '2';

	$FirstName = preg_replace("/[^a-zA-Z]/","",stripslashes($data[6]));

	$MiddleName = preg_replace("/[^a-zA-Z]/","",stripslashes($data[7]));

	$LastName = preg_replace("/[^a-zA-Z]/","",stripslashes(str_replace("'","",substr($data[8],0,20))));

	$city = $data[19];

	$gender = $data[14];

	$email = trim($data[34]);
	
	if($data[13] == '')
	{
		$age_years = 0;
		$age_months = 0;
	}
	else
	{
		$age_array = explode('/',$data[13],2); // Age is given as years and months differently

		$age_years = $age_array[0];

		if(strlen($age_years) > 2)
		{
			$age_years = substr($age_years,1);
		}

		$age_months = @$age_array[1];

		$age_years = preg_replace("/[^0-9]/", "0", $age_years);

		$age_months = preg_replace("/[^0-9]/", "0", $age_months);
	}

	//////////////////////////////////////

	$dob = $data[12];

	$dob = explode('/', $dob);

	if(!isset($dob[0]) || !isset($dob[1]) || !isset($dob[2]))
	{
		$dob = '';
	}
	else
	{
		$dob  = "$dob[1]-$dob[0]-$dob[2]";
	}

	///////////////////////////////////////

	if(strlen($data[30]) > 9)
	{
		$ContactNumber = trim($data[30]);

		if(strlen($ContactNumber) > 12)
		{
			$temp_contact_number = explode("-", str_replace(array("-", "/", ".", ",", " ","'"), "-", $ContactNumber));
		
			$temp_contact_number = array_values(array_filter($temp_contact_number));

			$ContactNumber = $temp_contact_number[0];

			$ContactNumber = preg_replace("/[^0-9]/", "", $ContactNumber);
		}
	}
	else
	{
		if(strlen($data[33]) > 9)
		{
			$ContactNumber = trim($data[33]);

			if(strlen($ContactNumber) > 12)
			{
				$temp_contact_number = explode("-", str_replace(array("-", "/", ".", ",", " "), "-", $ContactNumber));
			
				$temp_contact_number = array_values(array_filter($temp_contact_number));

				$ContactNumber = $temp_contact_number[0];

				$ContactNumber = preg_replace("/[^0-9]/", "", $ContactNumber);
			}
		}
		elseif(strlen($data[36]) > 9)
		{
			$ContactNumber = trim($data[36]);

			if(strlen($ContactNumber) > 12)
			{
				$temp_contact_number = explode("-", str_replace(array("-", "/", ".", ",", " "), "-", $ContactNumber));
			
				$temp_contact_number = array_values(array_filter($temp_contact_number));

				$ContactNumber = $temp_contact_number[0];

				$ContactNumber = preg_replace("/[^0-9]/", "", $ContactNumber);
			}
		}
		else
		{
			$ContactNumber = "1234567890";
		}
	}

	// echo "<pre>";
	// print_r($FirstName);
	// echo "</pre>";

	$ContactNumber = preg_replace("/[^0-9]/", "", $ContactNumber);	

	$ContactNumber == '' ? $ContactNumber = 0 : $ContactNumber;

	$address = mysqli_real_escape_string($con,$data[16]);

	strlen($address) >= 200 ? $address = addslashes(substr($address,0,199)) : addslashes($address);

	/////////////////////////////

	if($opd_no == '')
	{
		$import="INSERT into patientregistration(RegistrationNo,HospitalBranchId,OpdRegNo,RandomSuffix,PatientRegistrationNo,FirstName,MiddleName,LastName,ContactNumber,AgeYear,AgeMonth,DateOfBirth,Gender,Email,Address,created_at,updated_at) values('$reg_no','$HospitalBranchId','$AssignedOPDNumber','$RandomSuffix','$regNo2','$FirstName','$MiddleName','$LastName','$ContactNumber','$age_years','$age_months','$dob','$gender','$email','$address','$PatientDate','$PatientDate')";
		$AssignedOPDNumber =  $AssignedOPDNumber - 1;
	}
	else
	{
		$import="INSERT into patientregistration(RegistrationNo,HospitalBranchId,OpdRegNo,RandomSuffix,PatientRegistrationNo,FirstName,MiddleName,LastName,ContactNumber,AgeYear,AgeMonth,DateOfBirth,Gender,Email,Address,created_at,updated_at) values('$reg_no','$HospitalBranchId','$opd_no','$RandomSuffix','$regNo2','$FirstName','$MiddleName','$LastName','$ContactNumber','$age_years','$age_months','$dob','$gender','$email','$address','$PatientDate','$PatientDate')";
	}

	///////////////////////////////

	$query = $con->query($import);

    if($query)
    {
    	$import_count = $import_count + 1;	
    }
    else
    {
		if(mysqli_errno($con) == '1062')
		{
			$import="INSERT into patientregistration(RegistrationNo,HospitalBranchId,OpdRegNo,RandomSuffix,PatientRegistrationNo,FirstName,MiddleName,LastName,ContactNumber,AgeYear,AgeMonth,DateOfBirth,Gender,Email,Address,created_at,updated_at) values('$reg_no','$HospitalBranchId','$AssignedOPDNumber','$RandomSuffix','$regNo2','$FirstName','$MiddleName','$LastName','$ContactNumber','$age_years','$age_months','$dob','$gender','$email','$address','$PatientDate','$PatientDate')";
			$query = $con->query($import);

			if($query)
			{
				$import_count = $import_count + 1;	
				$AssignedOPDNumber =  $AssignedOPDNumber - 1;
			}
			else
			{
				if(mysqli_errno($con) == '1062')
				{
					$import="INSERT into patientregistration(RegistrationNo,HospitalBranchId,OpdRegNo,RandomSuffix,PatientRegistrationNo,FirstName,MiddleName,LastName,ContactNumber,AgeYear,AgeMonth,DateOfBirth,Gender,Email,Address,created_at,updated_at) values('$reg_no','$HospitalBranchId','$AssignedOPDNumber','$RandomSuffix','$regNo2','$FirstName','$MiddleName','$LastName','$ContactNumber','$age_years','$age_months','$dob','$gender','$email','$address','$PatientDate','$PatientDate')";
					$query = $con->query($import);

					if($query)
					{
						$import_count = $import_count + 1;	
						$AssignedOPDNumber =  $AssignedOPDNumber - 1;
					}
					else
					{
						$error_count += 1;
						echo "<pre>";
						echo $reg_no;
						echo "<br>";
						echo "Assigned: ".mysqli_error($con);
						echo "</pre>";
					}
				}
			}
		}
	}
}
$con->query("SET FOREIGN_KEY_CHECKS = 1");
echo "imported count: ".$import_count;
echo "<br>";
echo "Error Count: ".$error_count;
echo "<br>";
$total = $import_count+$error_count;
echo "Total Records: ".$total;
echo "<br>";

fclose($handle);
echo "Importing Successfull"."<br>";
?>
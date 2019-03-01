<?php
//////////////////////////////////

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
ini_set("memory_limit","3072M");

//////////////////////////////////

include_once 'database.php';

	$get_dates = "SELECT * FROM PatientVisit GROUP BY PatientRegistrationNo,Visit_Date ORDER BY Visit_Date ASC";

	$query = $con->query($get_dates);

	while($ids = mysqli_fetch_assoc($query))
	{
		$main_ids[] = $ids['PatientVisitComplaintsID'];
		$visit_dates[] = $ids['Visit_Date'];
		$reg_id[] = $ids['PatientRegistrationNo'];
	}

	$reg_visit_count = array_count_values($reg_id);

	$unique_reg_no = array_unique($reg_id);

//	$current_reg = current($unique_reg_no);

	$counter = 1;

	while($counter <= $reg_visit_count[current($unique_reg_no)])
	{	
		$current_reg = current($unique_reg_no);

		$get_new = "SELECT * FROM PatientVisit WHERE PatientRegistrationNo = '$current_reg' ORDER BY Visit_Date ASC";

		$query2 = $con->query($get_new);
		
		while($ids2 = mysqli_fetch_assoc($query2))
		{

			$sorted_dates = $ids2['Visit_Date'];
			$id = $ids2['PatientVisitComplaintsID'];
			
			$update_query = "UPDATE PatientVisit SET PatientVisitID = '$counter' WHERE Visit_Date = '$sorted_dates' AND PatientVisitComplaintsID = '$id'"; 
			
			$process = $con->query($update_query);

			if($process)
			{
				$counter += 1;
			}
			else
			{
				echo "<pre>";
				print_r(mysqli_error($con));
				echo "</pre>";
			}

			// echo "<pre>";
			// print_r($update_query);
			// echo "</pre>";
		}

		$counter = 1;

		array_shift($unique_reg_no);
	}
	
echo "Update Successfull";
?>
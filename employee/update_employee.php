<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<?php

	include '../util/session.php';
	include '../util/db_connect.php';

	extract($_POST);

	if($session_department=="d0001"){

		$query = "UPDATE field_operation SET region = '$Region', workload = '$Capacity' WHERE e_id ='$EmployeeID'";


	}else if ($session_department=="d0002"){
		
		$query = "UPDATE delivery SET capacity = '$Capacity' WHERE e_id ='$EmployeeID'";

	}else if ($session_department=="d0003"){

		$query = "UPDATE technician SET specialty = '$Specialty', workload = '$Capacity' WHERE e_id ='$EmployeeID'";

	}

	$result = getResult($query);

	if ($result===true) {
		echo "<header class='major'><h2>Update Successful!<h2></header>";
	}else{
		echo "<header class='major'><h2>Update Failed!</h2></header>";
	}

?>
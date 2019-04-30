<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<?php

	include '../util/session.php';
	include '../util/db_connect.php';
	include '../util/loghelper.php';

	extract($_POST);

	if($session_department=="d0001"){

		$query = "UPDATE field_operation SET region = '$Region', workload = '$Capacity' WHERE e_id ='$EmployeeID'";


	}else if ($session_department=="d0002"){
		
		$query = "UPDATE delivery SET capacity = '$Capacity' WHERE e_id ='$EmployeeID'";

	}else if ($session_department=="d0003"){

		$query = "UPDATE technician SET specialty = '$Specialty', workload = '$Capacity' WHERE e_id ='$EmployeeID'";

	}

	$logger->info("User-".$session_userid." update employee SQL: ".$query);

	$result = getResult($query);

	if ($result===true) {

		$logger->info("User-".$session_userid." update employee successful");

		echo "<header class='major'><h2>Update Successful!<h2></header>";
	}else{

		$logger->error("User-".$session_userid." update employee failed");

		echo "<header class='major'><h2>Update Failed!</h2></header>";
	}

?>
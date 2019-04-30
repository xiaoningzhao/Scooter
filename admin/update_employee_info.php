<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<?php

	include '../util/session.php';
	include '../util/loghelper.php';

	extract($_POST);

	$json_db = file_get_contents('../db.json');
	$db = json_decode($json_db, true);

	$db_servername = $db['servername'];
	$db_username = $db['username'];
	$db_password = $db['password'];
	$db_dbname = $db['dbname'];

	$conn = new mysqli($db_servername, $db_username, $db_password, $db_dbname);
	
	if ($conn->connect_error) {
		die("Could not connect database.".$conn->connect_error);
	}

	$query_update="";
	$query = "UPDATE employee SET e_fname = '$FirstName', e_lname = '$LastName', e_ssn = '$SSN', address = '$Address', e_gender = '$Gender',birthday = '$Birthday' WHERE e_id ='$EmployeeID'";

	if($Department=="d0001"){

		$query_update = "UPDATE field_operation SET region = '$Region', workload = '$Capacity' WHERE e_id ='$EmployeeID'";


	}else if ($Department=="d0002"){
		
		$query_update = "UPDATE delivery SET capacity = '$Capacity' WHERE e_id ='$EmployeeID'";

	}else if ($Department=="d0003"){

		$query_update = "UPDATE technician SET specialty = '$Specialty', workload = '$Capacity' WHERE e_id ='$EmployeeID'";

	}

	$conn->autocommit(FALSE);

	$logger->info("User-".$session_userid." update employee info SQL: ".$query);
	$logger->info("User-".$session_userid." update employee info SQL: ".$query_update);

	$result = $conn->query($query);
	$result_update = false;
	if($JobType=="Manager"){
		$result_update=true;
	}else{
		$result_update = $conn->query($query_update);
	}

	if ($result==true && $result_update==true) {

		$conn->commit();

		$logger->info("User-".$session_userid." update employee info successful");

		echo "<header class='major'><h2>Update Successful!<h2></header>";
	}else{

		$logger->error("User-".$session_userid." update employee info failed: ".$conn->error);

		$conn->rollback();

		echo "<header class='major'><h2>Update Failed! ".$conn->error."</h2></header>";
	}

	$conn->autocommit(TRUE);

	$conn->close();

?>
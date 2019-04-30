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

	$query = "";

	if($birthday==""){
		$query = "INSERT INTO employee VALUES ('$employee_id',MD5('$password'),'$firstname','$lastname','$ssn','$address','$gender',null ,'$jobtype','$department')";
	}else{
		$query = "INSERT INTO employee VALUES ('$employee_id',MD5('$password'),'$firstname','$lastname','$ssn','$address','$gender','$birthday','$jobtype','$department')";
	}

	$logger->info("User-".$session_userid." Create employee SQL: ".$query);

	$query_department = "";
	if($department=="d0001"){
		$query_department = "INSERT INTO field_operation VALUES ('$employee_id','Region_A',5)";
	}else if($department=="d0002"){
		$query_department = "INSERT INTO delivery VALUES ('$employee_id',5)";
	}else if($department=="d0003"){
		$query_department = "INSERT INTO technician VALUES ('$employee_id','00000',5)";
	}

	$logger->info("User-".$session_userid." Create employee SQL: ".$query_department);

	$conn->autocommit(FALSE);

	$result = $conn->query($query);

	$result_department = $conn->query($query_department);

	if ($result==true && $query_department==true) {
		$conn->commit();

		$logger->info("User-".$session_userid." Create employee successful");

		echo "<header class='major'><h2>Create Employee Successful!<h2></header>";
	}else{
		$conn->rollback();

		$logger->error("User-".$session_userid." Create employee failed: ".$conn->error);

		echo "<header class='major'><h2>Create Employee Failed! ".$conn->error."</h2></header>";
	}
	$conn->autocommit(TRUE);

	$conn->close();

?>
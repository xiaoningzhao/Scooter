<?php

	include 'session.php';
	//include 'db_connect.php';

	extract($_POST);

	$json_db = file_get_contents('db.json');
	$db = json_decode($json_db, true);

	$db_servername = $db['servername'];
	$db_username = $db['username'];
	$db_password = $db['password'];
	$db_dbname = $db['dbname'];

	$conn = new mysqli($db_servername, $db_username, $db_password, $db_dbname);
	
	if ($conn->connect_error) {
		die("Could not connect database.".$conn->connect_error);
	}
	
	$conn->autocommit(FALSE);

	//select employees whose number of tickets is less than his/her workload and region covers scooter's location
	$query = "SELECT e.e_id, f.workload, count(t.t_id) 
				FROM employee e 
				JOIN field_operation f ON f.e_id = e.e_id 
				LEFT JOIN ticket t ON e.e_id = t.e_id AND t.t_status <> '90000'
				WHERE e.d_id ='d0001' 
					AND f.region IN 
						(SELECT l.region FROM scooter s JOIN location_region l ON s.location = l.location WHERE s_id = '$scooter_id')
				GROUP BY e.e_id, f.workload
				HAVING count(t.t_id) < f.workload
				ORDER BY count(t.t_id) ASC";
	$result = $conn->query($query);
	$employee = "";
	if ($result->num_rows > 0){

		$row = $result->fetch_assoc();
		$employee = $row['e_id'];
		$query = "INSERT INTO ticket (t_status, t_issue, t_message, e_id, d_id, s_id, c_id, created_date, created_time) VALUES ('00000', '$issue', '$message', '$employee','d0001', '$scooter_id', '$session_userid', curdate(), curtime())";

	}else{

		$query = "INSERT INTO ticket (t_status, t_issue, t_message, e_id, d_id, s_id, c_id, created_date, created_time) VALUES ('00000', '$issue', '$message', (SELECT e_id from employee where job_type = 'Manager' and d_id = 'd0001'),'d0001', '$scooter_id', '$session_userid', curdate(), curtime())";
	}

	$result = $conn->query($query);

	if ($result===true) {
		$conn->commit();
		echo "<header class='major'><h2>Create Successful!<h2></header>";
	}else{
		$conn->rollback();
		echo "<header class='major'><h2>Create Failed!</h2></header>";
	}
	$conn->autocommit(TRUE);

	$conn->close();

?>
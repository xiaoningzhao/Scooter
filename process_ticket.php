<?php

	include 'session.php';

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
	
	if($session_department=="d0001"){

		$conn->autocommit(FALSE);

		//select employees whose number of tickets is less than his/her workload
		$query_employee = "SELECT e.e_id, delivery.capacity, count(t.t_id) 
					FROM employee e 
					JOIN delivery ON delivery.e_id = e.e_id 
					LEFT JOIN ticket t ON e.e_id = t.e_id AND t.t_status <> '90000'
					WHERE e.d_id ='d0002' 
					GROUP BY e.e_id, delivery.capacity
					HAVING count(t.t_id) < delivery.capacity
					ORDER BY count(t.t_id) ASC";


		$result = $conn->query($query_employee);
		$employee = "";
		if ($result->num_rows > 0){

			$row = $result->fetch_assoc();
			$employee = $row['e_id'];
			$query_update = "UPDATE ticket SET t_status = '10000', e_id = '$employee', t_issue = '$Issue', t_message = '$Message', d_id = 'd0002' WHERE t_id ='$TicketID'";

		}else{
			$query_update = "UPDATE ticket SET t_status = '10000', e_id = (SELECT e_id from employee where job_type = 'Manager' and d_id = 'd0002'), t_issue = '$Issue', t_message = '$Message', d_id = 'd0002' WHERE t_id ='$TicketID'";
		}

		$result = $conn->query($query_update);

		$query_insert_history = "INSERT INTO ticket_history (t_id, e_id, operation_type, logtime) VALUES ('$TicketID', '$session_userid', 'verify', now())";

		$resulthistory = $conn->query($query_insert_history);

		$query_scooter = "UPDATE scooter SET s_status_code = 'Issue' where s_id = '$ScooterID'";

		$resultscooter = $conn->query($query_scooter);

		if ($result===true && $resulthistory===true && $resultscooter===true) {
			$conn->commit();
			echo "<header class='major'><h2>Process Successful!<h2></header>";
		}else{
			$conn->rollback();
			echo "<header class='major'><h2>Process Failed!</h2></header>";
		}
		$conn->autocommit(TRUE);

	}else if ($session_department=="d0002"){
		
		$conn->autocommit(FALSE);

		//select employees whose number of tickets is less than his/her workload
		$query_employee = "SELECT e.e_id, technician.workload, count(t.t_id) 
					FROM employee e 
					JOIN technician ON technician.e_id = e.e_id AND technician.specialty = '$Issue' 
					LEFT JOIN ticket t ON e.e_id = t.e_id AND t.t_status <> '90000'
					WHERE e.d_id ='d0003' 
					GROUP BY e.e_id, technician.workload
					HAVING count(t.t_id) < technician.workload
					ORDER BY count(t.t_id) ASC";
		$result = $conn->query($query_employee);
		$employee = "";
		if ($result->num_rows > 0){

			$row = $result->fetch_assoc();
			$employee = $row['e_id'];
			$query_update = "UPDATE ticket SET t_status = '20000', e_id = '$employee', t_issue = '$Issue', t_message = '$Message', d_id = 'd0003' WHERE t_id ='$TicketID'";

		}else{
			$query_update = "UPDATE ticket SET t_status = '20000', e_id = (SELECT e_id from employee where job_type = 'Manager' and d_id = 'd0003'), t_issue = '$Issue', t_message = '$Message', d_id = 'd0003' WHERE t_id ='$TicketID'";
		}

		$result = $conn->query($query_update);

		$query_insert_history = "INSERT INTO ticket_history (t_id, e_id, operation_type, logtime) VALUES ('$TicketID', '$session_userid', 'deliver', now())";

		$resulthistory = $conn->query($query_insert_history);

		if ($result===true && $resulthistory===true) {
			$conn->commit();
			echo "<header class='major'><h2>Process Successful!<h2></header>";
		}else{
			$conn->rollback();
			echo "<header class='major'><h2>Process Failed!</h2></header>";
		}
		$conn->autocommit(TRUE);

	}else if ($session_department=="d0003"){

		$conn->autocommit(FALSE);

		//select employees whose number of tickets is less than his/her workload
		$query_employee = "SELECT e.e_id, delivery.capacity, count(t.t_id) 
					FROM employee e 
					JOIN delivery ON delivery.e_id = e.e_id 
					LEFT JOIN ticket t ON e.e_id = t.e_id AND t.t_status <> '90000'
					WHERE e.d_id ='d0002' 
					GROUP BY e.e_id, delivery.capacity
					HAVING count(t.t_id) < delivery.capacity
					ORDER BY count(t.t_id) ASC";
		$result = $conn->query($query_employee);
		$employee = "";
		if ($result->num_rows > 0){

			$row = $result->fetch_assoc();
			$employee = $row['e_id'];
			$query_update = "UPDATE ticket SET t_status = '30000', e_id = '$employee', t_issue = '$Issue', t_message = '$Message' , d_id = 'd0002'WHERE t_id ='$TicketID'";

		}else{
			$query_update = "UPDATE ticket SET t_status = '30000', e_id = (SELECT e_id from employee where job_type = 'Manager' and d_id = 'd0002'), t_issue = '$Issue', t_message = '$Message', d_id = 'd0002' WHERE t_id ='$TicketID'";
		}

		$result = $conn->query($query_update);

		$query_insert_history = "INSERT INTO ticket_history (t_id, e_id, operation_type, logtime) VALUES ('$TicketID', '$session_userid', 'maintain', now())";

		$resulthistory = $conn->query($query_insert_history);

		if ($result===true && $resulthistory===true) {
			$conn->commit();
			echo "<header class='major'><h2>Process Successful!<h2></header>";
		}else{
			$conn->rollback();
			echo "<header class='major'><h2>Process Failed!</h2></header>";
		}
		$conn->autocommit(TRUE);
	}

	$conn->close();
?>
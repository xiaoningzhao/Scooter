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

	$conn->autocommit(FALSE);

	$query = "UPDATE ticket SET t_status = '90000', e_id = 'e0000', d_id ='d0000', closed_date = curdate(), closed_time = curtime() WHERE (t_id = '$ticket_id')";

	$result = $conn->query($query);

	$query_insert_history = "INSERT INTO ticket_history (t_id, e_id, operation_type, logtime) VALUES ('$ticket_id', '$session_userid', 'close', now())";

	$resulthistory = $conn->query($query_insert_history);

	$query_scooter = "UPDATE scooter SET s_status_code = 'OK' where s_id = '$scooter_id'";

	$resultscooter = $conn->query($query_scooter);

	if ($result===true && $resulthistory===true && $resultscooter===true) {
		$conn->commit();
		echo "<h2>Close Successful!</h2>";
	}else{
		$conn->rollback();
		echo "<h2>Close Failed!</h2>";
	}
	$conn->autocommit(TRUE);

	$conn->close();

?>
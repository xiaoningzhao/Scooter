<?php
	function getResult($querySQL){
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
		
		$result = $conn->query($querySQL);

		$conn->close();

		return $result;
	}
?>
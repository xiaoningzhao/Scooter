<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<?php

	include '../util/session.php';
	include '../util/db_connect.php';
	include '../util/loghelper.php';

	extract($_POST);

	if($session_logintype== "User"){
		$query = "SELECT c_password from customer  where c_id = '$session_userid' and c_password = '".md5($old_password)."'";
	}else if ($session_logintype== "Employee"){
		$query = "SELECT e_password from employee  where e_id = '$session_userid' and e_password = '".md5($old_password)."'";
	}else if ($session_logintype== "Admin"){
		$query = "SELECT e_password from employee  where e_id = '$session_userid' and e_password = '".md5($old_password)."'";
	}

	$logger->info("User-".$session_userid." change password - verify SQL: ".$query);

	$result = getResult($query);
	if ($result->num_rows > 0) {

		if($session_logintype== "User"){
			$query = "UPDATE customer SET c_password = md5('$new_password') where c_id = '$session_userid'";
		}else if ($session_logintype== "Employee"){
			$query = "UPDATE employee SET e_password = md5('$new_password') where e_id = '$session_userid'";
		}else if ($session_logintype== "Admin"){
			$query = "UPDATE employee SET e_password = md5('$new_password') where e_id = '$session_userid'";
		}

		$logger->info("User-".$session_userid." change password SQL: ".$query);

		$result = getResult($query);
		if ($result===true) {

			$logger->info("User-".$session_userid." change password successful");

			echo "<h2>Update Successful!</h2>";
		}else{

			$logger->error("User-".$session_userid." change password failed");

			echo "<h2>Update Failed!</h2>";
		}
	}else{

		$logger->info("User-".$session_userid." change password - verify failed");

		echo "<h2>Update Failed! Old password does not match!</h2>";
	}

?>
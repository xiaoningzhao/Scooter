<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<?php

	include '../util/session.php';
	include '../util/db_connect.php';

	extract($_POST);

	if($session_logintype== "User"){
		$query = "UPDATE customer SET c_name = '$username', phone = '$phone', email = '$email' WHERE (c_id = '$session_userid')";
	}else if ($session_logintype== "Employee"){
		$query = "UPDATE employee SET e_fname = '$firstname', e_lname = '$lastname', e_ssn = '$ssn', address = '$address', e_gender = '$gender', birthday = '$birthday' WHERE (e_id = '$session_userid')";
	}else if ($session_logintype== "Admin"){
		$query = "UPDATE employee SET e_fname = '$firstname', e_lname = '$lastname', e_ssn = '$ssn', address = '$address', e_gender = '$gender', birthday = '$birthday' WHERE (e_id = '$session_userid')";
	}

	$result = getResult($query);
	if ($result===true) {
		echo "<h2>Update Successful!</h2>";
	}else{
		echo "<h2>Update Failed!</h2>";
	}

?>
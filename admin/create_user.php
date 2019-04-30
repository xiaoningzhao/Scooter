<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<?php

	include '../util/session.php';
	include '../util/db_connect.php';
	include '../util/loghelper.php';

	extract($_POST);

	$query = "INSERT INTO customer VALUES ('$userid',MD5('$password'),'$name','$phone','$email')";

	$logger->info("User-".$session_userid." Create user SQL: ".$query);

	$result = getResult($query);

	if ($result==true) {
		$logger->info("User-".$session_userid." Create user successful");

		echo "<header class='major'><h2>Create User Successful!<h2></header>";
	}else{
		$logger->error("User-".$session_userid." Create employee failed.");

		echo "<header class='major'><h2>Create User Failed!</h2></header>";
	}

?>
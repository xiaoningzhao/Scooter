<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<?php

	include '../util/session.php';
	include '../util/db_connect.php';
	include '../util/loghelper.php';

	extract($_POST);

	$query = "UPDATE customer SET c_name = '$Name', phone = '$Phone', email = '$Email' WHERE c_id ='$UserID'";

	$logger->info("User-".$session_userid." update user info SQL: ".$query);

	$result = getResult($query);

	if ($result==true) {

		$logger->info("User-".$session_userid." update user info successful");

		echo "<header class='major'><h2>Update Successful!<h2></header>";
	}else{

		$logger->error("User-".$session_userid." update user info failed");

		echo "<header class='major'><h2>Update Failed!</h2></header>";
	}

?>
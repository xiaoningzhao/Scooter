<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<?php

	include '../util/session.php';
	include '../util/db_connect.php';
	include '../util/loghelper.php';

	extract($_POST);

	$query = "UPDATE ticket SET e_id = '$e_id' WHERE t_id ='$ticket_id'";

	$logger->info("User-".$session_userid." assign ticket SQL: ".$query);

	$result = getResult($query);

	if ($result===true) {

		$logger->info("User-".$session_userid." assign ticket successful");

		echo "<header class='major'><h2>Assign Successful!<h2></header>";
	}else{
		
		$logger->error("User-".$session_userid." assign ticket failed");

		echo "<header class='major'><h2>Assign Failed!</h2></header>";
	}

?>
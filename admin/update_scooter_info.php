<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<?php

	include '../util/session.php';
	include '../util/db_connect.php';
	include '../util/loghelper.php';

	extract($_POST);

	$query = "UPDATE scooter SET s_status_code = '$Status', s_model = '$Model', onboard_date = '$OnboardDate' WHERE s_id ='$ScooterID'";

	$logger->info("User-".$session_userid." update scooter info SQL: ".$query);

	$result = getResult($query);

	if ($result==true) {

		$logger->info("User-".$session_userid." update scooter info successful");

		echo "<header class='major'><h2>Update Successful!<h2></header>";
	}else{

		$logger->error("User-".$session_userid." update scooter info failed");

		echo "<header class='major'><h2>Update Failed!</h2></header>";
	}

?>
<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<?php
	$session_login = false;
	$session_name = "";
	$session_userid = "";
	$session_logintype = "";
	$session_jobtype = "";
	$session_department = "";

	session_start();
	if (isset($_SESSION["session_login"]) && $_SESSION["session_login"] === true) {
	    $session_login = $_SESSION["session_login"];
	    $session_name = $_SESSION["session_name"];
	    $session_userid = $_SESSION["session_userid"];
	    $session_logintype = $_SESSION["session_logintype"];
	    $session_jobtype = $_SESSION["session_jobtype"];
	    $session_department = $_SESSION["session_department"];

	} else {
	    $_SESSION["session_login"] = false;
	    die("You are not login. Access denied.");
	}
?>
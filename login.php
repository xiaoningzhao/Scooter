<!DOCTYPE HTML>

<html>
	<head>
		<title>Scooter Management System</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
		<body class="is-preload">
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header">
					<h1 id="logo"><a href="index.html">Scooter Management System</a></h1>
				</header>
				<div id="main" class="wrapper style1">
					<div class="container">
<?php
	include 'db_connect.php';
	extract($_POST);

	switch ($loginType) {
		case 'Employee':
			$query = "SELECT e.e_id as id, e.e_password, concat(e.e_fname, ', ' ,e.e_lname) as name, e.job_type, d.d_id as department from employee e left join department d on e.d_id = d.d_id where e.e_id = '$userid' and e.e_password = '".md5($password)."'";
			$page = "employee.php";
			break;
		case 'User':
			$query = "SELECT c_id as id, c_password, c_name as name, 'customer' as job_type, '' as department from customer where c_id = '$userid' and c_password = '".md5($password)."'";
			$page = "customer.php";
			break;
		case 'Admin':
			$query = "SELECT e.e_id as id, e.e_password, concat(e.e_fname, ', ' ,e.e_lname) as name, e.job_type, d.d_id as department from employee e left join department d on e.d_id = d.d_id where e.e_id = '$userid' and e.job_type ='Admin' and e.e_password = '".md5($password)."'";
			$page = "admin.php";
			break;
		default:
			$query = "";
			$page = "";
			break;
	}

	$result = getResult($query);

	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();

		session_start();
	    $_SESSION["session_login"] = true;
	    $_SESSION["session_logintype"] = $loginType;
	    $_SESSION["session_userid"] = $row['id'];
	    $_SESSION["session_name"] = $row['name'];
	    $_SESSION["session_jobtype"] = $row['job_type'];
   	    $_SESSION["session_department"] = $row['department'];


 		echo "<header class='major'><h2>Welcome ".$_SESSION["session_name"]."! Login Successful.</h2></header>";
 		header("Refresh:1;url=$page");

	}else{
		echo "<header class='major'><h2>Login Failed.</h2></header>";
		header("Refresh:1;url=index.html");
	}

?>

					</div>
				</div>

			<!-- Footer -->
				<footer id="footer">
					<ul class="copyright">
						<li>&copy; Scooter Management System Powered By Team 4.</li>
					</ul>
				</footer>
		</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<?php
	include 'util/session.php';
?>

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
					<nav id="nav">
						<ul>
							<?php echo "<li>Welcome  <b> $session_name </b></li>"; ?>
							<?php if($session_jobtype == "Manager") echo "<li><a id='manage_department' page='employee/manage_department.php' href='#'>Department</a></li>"; ?>
							<li><a id="edit_profile" page="employee/edit_employee_profile.html" href="#">Edit Profile</a></li>
							<li><a id="change_password" page="common/change_password.html" href="#">Change Password</a></li>
							<li><a id="logout" href="logout.php">Logout</a></li>
						</ul>
					</nav>
				</header>

			<!-- Main -->
				<div id="main" class="wrapper style1">
					<div class="container">
						<div class="row gtr-150">
							<div class="col-3 col-12-medium">

								<!-- Sidebar -->
									<section id="sidebar">
										<section id="user_profile">
										</section>
										<section>
											<div class="col-3 col-6-medium col-12-xsmall">
												<ul class="actions stacked">
													<li><a id="list_tickets" page= "common/list_tickets.php" href="#" class="button fit">List Tickets</a></li>
												</ul>
											</div>
										</section>
									</section>

							</div>
							<div class="col-9 col-12-medium imp-medium">

								<!-- Content -->
									<section id="content">
									</section>

							</div>
						</div>
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

			<script>
			$(document).ready(function(){
				$("#user_profile").load("common/user_profile.php",function(responseTxt,statusTxt,xhr){
			    });
			    $("#content").load("common/list_tickets.php",function(responseTxt,statusTxt,xhr){
		    	});
			});

			$("a").on("click", function(){
		    	$("#content").load($(this).attr("page"),function(responseTxt,statusTxt,xhr){
		    	});
		  	});

			$("#edit_profile").click(function(){
				$("#content").load("employee/edit_employee_profile.html",function(responseTxt,statusTxt,xhr){
					$("#firstname").val($("#FirstName").attr("value"));
					$("#lastname").val($("#LastName").attr("value"));
					$("#ssn").val($("#SSN").attr("value"));
					$("#gender").val($("#Gender").attr("value"));
					$("#address").val($("#Address").attr("value"));
					$("#birthday").val($("#Birthday").attr("value"));
		    	});
			});

			//submit form to page defined in form page attribute
			$("#content").on("click", ":submit", function() {
				$(this).closest("form").submit(function() {
				    return false;
				});
				$.post($(this).closest("form").attr("page"), $(this).closest("form").serialize(), function(responseTxt,statusTxt,xhr) {
					
					$("#content").html(responseTxt);
				});
				if($(this).closest("form").attr("page")=="common/edit_profile.php"){
					$("#user_profile").load("common/user_profile.php",function(responseTxt,statusTxt,xhr){
			    	});
			    }
			});

			//handle table row click event, to show detail of each row in detail page
			$("#content").on("click", "tr", function(){
			 	$.post($("table").attr("page"), {uid:$(this).children("td").eq(0).text()}, function(responseTxt,statusTxt,xhr) {
					$("#content").html(responseTxt);
				}); 
			});

			//handle change password request
			$("#content").on("click", ":button", function() {
				if($("#new_password").val() != $("#new_password_again").val()){
					alert("New passwords do not match!");
					return;
				}
				$.post($("#password_form").attr("page"), $("#password_form").serialize(), function(responseTxt,statusTxt,xhr) {
					$("#content").html(responseTxt);
				});
			});
			</script>

	</body>
</html>
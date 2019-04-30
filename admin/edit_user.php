<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<h3>User Detail</h3>
<?php

	include '../util/session.php';
	include '../util/db_connect.php';
	include '../util/loghelper.php';

	extract($_POST);


		$query = "select 
					c_id as UserID, c_name as Name, phone as Phone, email as Email   
					from customer
					where c_id = '$uid'";

	$logger->info("User-".$session_userid." user detail SQL: ".$query);

	$result = getResult($query);
	if ($result->num_rows > 0) {
		echo "<form page='admin/update_user_info.php'><div class='row gtr-uniform gtr-50'>";
		while($row = $result->fetch_assoc()) {
			foreach($row as $key => $value){
				echo "<div class='col-4'> <b>$key</b> <input type='text' name='$key' id='$key' value='$value' /> </div>";
			}
		}
		echo "<div class='col-12'><ul class='actions'><li><input type='submit' value='Update' class='primary' /></li></ul></div>";
		echo "</div></form>";

	}

?>

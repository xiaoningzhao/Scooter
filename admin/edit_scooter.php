<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<h3>Scooter Detail</h3>
<?php

	include '../util/session.php';
	include '../util/db_connect.php';
	include '../util/loghelper.php';

	extract($_POST);


		$query = "select 
					s_id as ScooterID, s_status_code as Status, s_model as Model, onboard_date as OnboardDate  
					from scooter
					where s_id = '$uid'";

	$logger->info("User-".$session_userid." user detail SQL: ".$query);

	$result = getResult($query);
	if ($result->num_rows > 0) {
		echo "<form page='admin/update_scooter_info.php'><div class='row gtr-uniform gtr-50'>";
		while($row = $result->fetch_assoc()) {
			foreach($row as $key => $value){
				echo "<div class='col-4'> <b>$key</b> <input type='text' name='$key' id='$key' value='$value' /> </div>";
			}
		}
		echo "<div class='col-12'><ul class='actions'><li><input type='submit' value='Update' class='primary' /></li></ul></div>";
		echo "</div></form>";

	}

?>

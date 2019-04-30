<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<h3>Scooter</h3>
<div class="table-wrapper">
<table id="scooters" page="admin/edit_scooter.php">
<?php

	include '../util/session.php';
	include '../util/db_connect.php';
	include '../util/loghelper.php';

	$query = "select s_id as ScooterID, s_status_code as Status, s_model as Model, location as Location from scooter";

	$logger->info("User-".$session_userid." List scooters SQL: ".$query);

	$result = getResult($query);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		echo "<thead><tr>";
		foreach ($row as $key => $value) {
			echo "<th>$key</th>";
		}
		echo "</tr></thead>";
		echo "<tbody>";
		echo "<tr>";
		foreach ($row as $key => $value) {
			echo "<td>$value</td>";
		}
		echo "</tr>";
		while($row = $result->fetch_assoc()) {
			echo "<tr>";
			foreach ($row as $key => $value) {
				echo "<td>$value</td>";
			}
			echo "</tr>";
		}
		echo "</tbody>";
	} else {
		echo "<h4>No Scooters</h4>";
	}
?>
</table>
</div>
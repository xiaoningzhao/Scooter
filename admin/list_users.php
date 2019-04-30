<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<h3>Users</h3>
<div class="table-wrapper">
<table id="users" page="admin/edit_user.php">
<?php

	include '../util/session.php';
	include '../util/db_connect.php';
	include '../util/loghelper.php';

	$query = "select c_id as UserID, c_name as Name, phone as Phone, email as Email from customer";

	$logger->info("User-".$session_userid." List users SQL: ".$query);

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
		echo "<h4>No Users</h4>";
	}
?>
</table>
</div>
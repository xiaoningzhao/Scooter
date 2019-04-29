<h3>Employees</h3>
<div class="table-wrapper">
<table id="employees" page="">
<?php

	include 'session.php';
	include 'db_connect.php';
		
	$query = "select e.e_id as EmployeeID, concat(e.e_fname,', ' ,e.e_lname) as EmployeeName, e.e_ssn as SSN, e.address as Address, e.e_gender as Gender, e.birthday as Birthday, e.job_type as JobType, department.d_id as Department
			from employee e 
			left join department on department.d_id = e.d_id";

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
		echo "<h4>No Employees</h4>";
	}

?>
</table>
</div>
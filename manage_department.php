<h3>Employees</h3>
<div class="table-wrapper">
<table id="employees" page="employee_detail.php">
<?php

	include 'session.php';
	include 'db_connect.php';


	if($session_department=="d0001"){
			
		$query = "select 
					e.e_id as EmployeeID, concat(e.e_fname,', ' ,e.e_lname) as EmployeeName, f.region as Region, f.workload as Capacity, count(t.t_id) as Tickets 
					from employee e 
					join field_operation f on e.e_id = f.e_id
					left join ticket t on e.e_id = t.e_id 
					group by e.e_id, concat(e.e_fname,', ' ,e.e_lname), f.region, f.workload";

	}else if($session_department=="d0002"){
			
		$query = "select 
					e.e_id as EmployeeID, concat(e.e_fname,', ' ,e.e_lname) as EmployeeName, d.capacity as Capacity, count(t.t_id) as Tickets 
					from employee e 
					join delivery d on e.e_id = d.e_id
					left join ticket t on e.e_id = t.e_id 
					group by e.e_id, concat(e.e_fname,', ' ,e.e_lname), d.capacity";

	}else if ($session_department=="d0003"){
		
		$query = "select 
					e.e_id as EmployeeID, concat(e.e_fname,', ' ,e.e_lname) as EmployeeName, code.t_issue_description as Specialty, technician.workload as Capacity, count(t.t_id) as Tickets 
					from employee e 
					join technician on e.e_id = technician.e_id
					join ticket_issue_code code on technician.specialty = code.t_issue 
					left join ticket t on e.e_id = t.e_id 
					group by e.e_id, concat(e.e_fname,', ' ,e.e_lname), code.t_issue_description, technician.workload";
	}

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
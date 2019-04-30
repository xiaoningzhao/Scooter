<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<h3>Tickets</h3>
<div class="table-wrapper">
<table id="tickets" page="common/ticket_detail.php">
<?php

	include '../util/session.php';
	include '../util/db_connect.php';


	if($session_logintype== "User"){
		
		$query = "select 
						t.t_id as TicketID, status.t_status_description as Status, issue.t_issue_description as Issue, 
						t.t_message as Message, s_id as ScooterID, t.created_date as Created_Date, t.closed_date as Closed_Date 
					from ticket t 
					join ticket_status_code status on status.t_status = t.t_status 
					join ticket_issue_code issue on issue.t_issue = t.t_issue 
					where t.c_id ='$session_userid' 
					order by t.t_status";

	}else if ($session_logintype== "Employee"){
		if($session_jobtype=="Manager"){
			
			$query = "select 
						t.t_id as TicketID, status.t_status_description as Status, issue.t_issue_description as Issue, 
						t.t_message as Message, concat(e.e_fname,', ' ,e.e_lname) as EmployeeName, s_id as ScooterID, t.created_date as Created_Date, t.closed_date as Closed_Date 
					from ticket t 
					left join employee e on t.e_id = e.e_id 
					join ticket_status_code status on status.t_status = t.t_status 
					join ticket_issue_code issue on issue.t_issue = t.t_issue 
					where t.d_id in 
						(select d_id from employee where e_id ='$session_userid') 
					order by t.t_status";

		}else{
			
			$query = "select 
						t.t_id as TicketID, status.t_status_description as Status, issue.t_issue_description as Issue, 
						t.t_message as Message, s_id as ScooterID, t.created_date as Created_Date, t.closed_date as Closed_Date  
					from ticket t 
					left join employee e on t.e_id = e.e_id 
					join ticket_status_code status on status.t_status = t.t_status 
					join ticket_issue_code issue on issue.t_issue = t.t_issue 
					where t.e_id ='$session_userid' 
					order by t.t_status";

		}
	}else if ($session_logintype== "Admin"){
		$query = "select 
						t.t_id as TicketID, status.t_status_description as Status, issue.t_issue_description as Issue, 
						t.t_message as Message, concat(e.e_fname,', ' ,e.e_lname) as EmployeeName, d.d_name as Department, 
						s_id as ScooterID, t.created_date as Created_Date, t.closed_date as Closed_Date  
					from ticket t 
					left join employee e on t.e_id = e.e_id 
					left join department d on d.d_id = t.d_id 
					join ticket_status_code status on status.t_status = t.t_status 
					join ticket_issue_code issue on issue.t_issue = t.t_issue 
					order by t.t_status";
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
		echo "<h4>No Tickets</h4>";
	}

?>
</table>
</div>






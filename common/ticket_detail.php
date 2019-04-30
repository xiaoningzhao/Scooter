<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<h3>Ticket Detail</h3>
<?php

	include '../util/session.php';
	include '../util/db_connect.php';

	extract($_POST);

	$query = "select 
					t.t_id as TicketID, status.t_status_description as Status, concat(e.e_fname,', ' ,e.e_lname) as EmployeeName, d.d_name as Department, t.s_id as ScooterID, t.created_date as Created_Date, t.created_time as Created_Time, t.closed_date as Closed_Date, t.closed_time as Closed_Time, t.t_issue as Issue, t.t_message as Message 
				from ticket t 
				left join employee e on t.e_id = e.e_id 
				left join department d on d.d_id = t.d_id 
				join scooter s on t.s_id = s.s_id 
				join ticket_status_code status on status.t_status = t.t_status 
				where t.t_id ='$uid'";
	$ticket_status ="";
	$scooter_id = "";	
	$result = getResult($query);
	if ($result->num_rows > 0) {
		echo "<form page='employee/process_ticket.php'><div class='row gtr-uniform gtr-50'>";
		while($row = $result->fetch_assoc()) {
			foreach($row as $key => $value){
				if($key=="Message"){
					echo "<div class='col-12'> <b>$key</b> <textarea name='$key' id='$key' rows='6'>$value</textarea></div>";
				}else if($key =="Issue"){

					$queryissue = "select t_issue code, t_issue_description issue from ticket_issue_code";
					$resultissue = getResult($queryissue);

					echo "<div class='col-8'> <b>$key</b> <select name='$key' id='$key'>";
						if ($resultissue->num_rows > 0) {
							while($rowissue = $resultissue->fetch_assoc()) {
								if($rowissue['code']==$value){
									echo "<option value= '".$rowissue['code']."' selected='selected' >".$rowissue['issue']."</option>";
								}else{
									echo "<option value= '".$rowissue['code']."'>".$rowissue['issue']."</option>";
								}
							}
						}
					echo "</select></div>";

				}else if($key=="Status"){
					$ticket_status = $value;
					echo "<div class='col-4'> <b>$key</b> <input type='text' name='$key' id='$key' value='$value' readonly /> </div>";
				}else if($key=="ScooterID"){
					$scooter_id = $value;
					echo "<div class='col-4'> <b>$key</b> <input type='text' name='$key' id='$key' value='$value' readonly /> </div>";
				}else {
					echo "<div class='col-4'> <b>$key</b> <input type='text' name='$key' id='$key' value='$value' readonly /> </div>";
				}


			}
		}
		if($ticket_status!="Returning" && $session_jobtype!="Admin"){
			echo "<div class='col-12'><ul class='actions fit small'><li><input type='submit' value='Process' class='button primary fit small' /></li></ul></div>";
		}

		echo "</div></form>";

		if($session_jobtype=="Manager" || $session_jobtype=="Admin"){
			echo "<form page='employee/close_ticket.php'><div class='row gtr-uniform gtr-50'><input type='hidden' name='ticket_id' id='ticket_id' value='$uid' /><input type='hidden' name='scooter_id' id='scooter_id' value='$scooter_id' /><div class='col-12'><ul class='actions fit small'><li><input type='submit' value='Close' class='button primary fit small' /></li></ul></div></div></form>";
		}else{
			if($session_department=="d0001"){
				echo "<form page='employee/close_ticket.php'><div class='row gtr-uniform gtr-50'><input type='hidden' name='ticket_id' id='ticket_id' value='$uid' /><input type='hidden' name='scooter_id' id='scooter_id' value='$scooter_id' /><div class='col-12'><ul class='actions fit small'><li><input type='submit' value='Close' class='button primary fit small' /></li></ul></div></div></form>";
			}else if($session_department=="d0002"){
				if($ticket_status=="Returning"){
					echo "<form page='employee/close_ticket.php'><div class='row gtr-uniform gtr-50'><input type='hidden' name='ticket_id' id='ticket_id' value='$uid' /><input type='hidden' name='scooter_id' id='scooter_id' value='$scooter_id' /><div class='col-12'><ul class='actions fit small'><li><input type='submit' value='Close' class='button primary fit small' /></li></ul></div></div></form>";
				}
			}
		}

		if($session_jobtype=="Manager"){
			$queryemployee = "select e_id, concat(e_fname,', ' ,e_lname) as EmployeeName from employee where d_id = '$session_department'";
			$resultemployee = getResult($queryemployee);
			echo "<form page='employee/assign_ticket.php'>Assign Employee<div class='row gtr-uniform gtr-50'><input type='hidden' name='ticket_id' id='ticket_id' value='$uid' />";
					echo "<div class='col-4'><select name='e_id' id='e_id'>";
						if ($resultemployee->num_rows > 0) {
								while($rowemployee = $resultemployee->fetch_assoc()) {
										echo "<option value= '".$rowemployee['e_id']."'>".$rowemployee['EmployeeName']."</option>";
									}
							}
					echo "</select></div>";
			echo "<div class='col-3'><ul class='actions'><li><input type='submit' value='Assign' class='primary' /></li></ul></div></div></form>";
		}

		echo "<h3>Scooter Detail</h3>";
		$query = "select s.s_model as Model, s.s_status_code as Status, s.location as Location, s.onboard_date as Onboard_Date from scooter s join ticket t on s.s_id = t.s_id where t.t_id = '$uid'";
		$result = getResult($query);
			while($row = $result->fetch_assoc()) {
				foreach($row as $key => $value){
					echo "<div class='col-6'><li id= '$key' value= '$value'><b>$key:</b>  $value<br></li></div>";
			}
		}

	}

?>

<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<h3>Employee Detail</h3>
<?php

	include '../util/session.php';
	include '../util/db_connect.php';
	include '../util/loghelper.php';

	extract($_POST);

	$query = "";

	if($session_department=="d0001"){
			
		$query = "select 
					e.e_id as EmployeeID, concat(e.e_fname,', ' ,e.e_lname) as EmployeeName, f.region as Region, f.workload as Capacity 
					from employee e 
					join field_operation f on e.e_id = f.e_id
					where e.e_id = '$uid'";

	}else if($session_department=="d0002"){
			
		$query = "select 
					e.e_id as EmployeeID, concat(e.e_fname,', ' ,e.e_lname) as EmployeeName, d.capacity as Capacity 
					from employee e 
					join delivery d on e.e_id = d.e_id 
					where e.e_id = '$uid'";

	}else if ($session_department=="d0003"){
		
		$query = "select 
					e.e_id as EmployeeID, concat(e.e_fname,', ' ,e.e_lname) as EmployeeName, technician.specialty as Specialty, technician.workload as Capacity 
					from employee e 
					join technician on e.e_id = technician.e_id 
					where e.e_id = '$uid'";
	}

	$logger->info("User-".$session_userid." employee detail SQL: ".$query);

	$result = getResult($query);
	if ($result->num_rows > 0) {
		echo "<form page='employee/update_employee.php'><div class='row gtr-uniform gtr-50'>";
		while($row = $result->fetch_assoc()) {
			foreach($row as $key => $value){
				if($key=="EmployeeID" || $key=="EmployeeName"){
					echo "<div class='col-6'> <b>$key</b> <input type='text' name='$key' id='$key' value='$value' readonly /> </div>";
				}else if($key =="Region"){

					$queryregion = "select distinct region from location_region";
					$resultregion = getResult($queryregion);

					echo "<div class='col-6'> <b>$key</b> <select name='$key' id='$key'>";
						if ($resultregion->num_rows > 0) {
							while($rowissue = $resultregion->fetch_assoc()) {
								if($rowissue['region']==$value){
									echo "<option value= '".$rowissue['region']."' selected='selected' >".$rowissue['region']."</option>";
								}else{
									echo "<option value= '".$rowissue['region']."'>".$rowissue['region']."</option>";
								}
							}
						}
					echo "</select></div>";

				}else if($key =="Specialty"){

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

				}else {
					echo "<div class='col-6'> <b>$key</b> <input type='text' name='$key' id='$key' value='$value' /> </div>";
				}


			}
		}
		echo "<div class='col-12'><ul class='actions'><li><input type='submit' value='Update' class='primary' /></li></ul></div>";
		echo "</div></form>";

	}

?>

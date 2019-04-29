<h3>User Profile</h3>
<?php 
	include 'session.php';
	include 'db_connect.php';

	if($session_logintype== "User"){
		$query = "select c_id as UserID, c_name as UserName, phone as Phone, email as Email from customer where c_id = '".$session_userid."'";
	}else if ($session_logintype== "Employee"){
		if($session_jobtype=="Manager"){
			$query = "SELECT e.e_id as EmployeeID, e.e_fname as FirstName, e.e_lname as LastName, e.e_ssn as SSN, e.address as Address, e.e_gender as Gender, e.birthday as Birthday, e.Job_type as Type, d.d_name as Department FROM employee e join department d on e.d_id = d.d_id where e.e_id = '$session_userid'";
		}else{
			switch ($session_department) {
				case 'd0001':
					$query = "SELECT e.e_id as EmployeeID, e.e_fname as FirstName, e.e_lname as LastName, e.e_ssn as SSN, e.address as Address, e.e_gender as Gender, e.birthday as Birthday, e.Job_type as Type, d.d_name as Department, f.region as Region, f.workload as Capacity FROM employee e join department d on e.d_id = d.d_id join field_operation f on e.e_id = f.e_id where e.e_id = '$session_userid'";
					break;
				case 'd0002':
					$query = "SELECT e.e_id as EmployeeID, e.e_fname as FirstName, e.e_lname as LastName, e.e_ssn as SSN, e.address as Address, e.e_gender as Gender, e.birthday as Birthday, e.Job_type as Type, d.d_name as Department, delivery.capacity as Capacity FROM employee e join department d on e.d_id = d.d_id join delivery on e.e_id = delivery.e_id where e.e_id = '$session_userid'";
					break;
				case 'd0003':
					$query = "SELECT e.e_id as EmployeeID, e.e_fname as FirstName, e.e_lname as LastName, e.e_ssn as SSN, e.address as Address, e.e_gender as Gender, e.birthday as Birthday, e.Job_type as Type, d.d_name as Department, code.t_issue_description as Specialty, t.workload as Capacity FROM employee e join department d on e.d_id = d.d_id join technician t on e.e_id = t.e_id join ticket_issue_code code on t.specialty = code.t_issue where e.e_id = '$session_userid'";
					break;					
				default:
					break;
			}
		}
	}else if ($session_logintype== "Admin"){
		$query = "SELECT e.e_id as EmployeeID, e.e_fname as FirstName, e.e_lname as LastName, e.e_ssn as SSN, e.address as Address, e.e_gender as Gender, e.birthday as Birthday, e.Job_type as Type, d.d_name as Department FROM employee e join department d on e.d_id = d.d_id where e.job_type ='Admin' and e.e_id = '$session_userid'";
	}
	$result = getResult($query);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			foreach($row as $key => $value){
				echo "<li id= $key value= '$value'><b>$key:</b>  $value<br></li>";
			}
		}
	}
?>
<br>
<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<?php
	include '../util/session.php';
	include '../util/db_connect.php';

	$query = "select t_issue code, t_issue_description issue from ticket_issue_code";

	$result = getResult($query);
?>

<h3>Create Ticket</h3>
<form method="post" page="user/create_ticket.php">
	<div class="row gtr-uniform gtr-50">
		<div class="col-4 col-12-xsmall">
			<b>Scooter ID</b><input type="text" name="scooter_id" id="scooter_id" value="" placeholder="Scooter ID" required/>
		</div>
		<div class="col-4">
			<b>Issue</b><select name="issue" id="issue">
				<?php
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						echo "<option value= '".$row['code']."'>".$row['issue']."</option>";
					}
				}
				?>
			</select>
		</div>
		<div class="col-12">
			<b>Message</b><textarea name="message" id="message" placeholder="Enter your message" rows="6" required></textarea>
		</div>
		<div class="col-12">
			<ul class="actions">
				<li><input type="submit" value="Create" class="primary" /></li>
				<li><input type="reset" value="Reset" /></li>
			</ul>
		</div>
	</div>
</form>
<?php
	include_once('forcelogin.php');
	$menuActive=4;
	$title="Enter Paycheck";
	include_once('dbutils.php');
	include_once('header.php');
?>

<?php

echo "<h2>$email</h2>";
// Back to PHP to perform the search if one has been submitted. Note
// that $_POST['submit'] will be set only if you invoke this PHP code as
// the result of a POST action, presumably from having pressed Submit
// on the form we just displayed above.
if (isset($_POST['submit'])) {
//	echo '<p>we are processing form data</p>';
//	print_r($_POST);

	// get data from the input fields
	$jobID = $_POST['jobID'];
	$checkStartDate = $_POST['checkStartDate'];
    $checkEndDate = $_POST['checkEndDate'];
	$wagesEarned = $_POST['wagesEarned'];
	$employeeID = $_SESSION['employeeId'];
	$goodform = true;
	
	// check to make sure we have a paycheck
	if (!$wagesEarned) {
		echo("Please enter amount of pay <br>");
		$goodform = false;
	}
	// check to make sure we have a Start date on paycheck
	if (!$checkStartDate) {
		echo("Please enter a Starting date for a pay period <br>");
		$goodform = false;
	}
        
    // check to make sure we have a End date on paycheck
	if (!$checkEndDate) {
		echo("Please enter a Ending date for this pay period <br>");
		$goodform = false;
	}
	
	// check to make sure we have a jobID
	if (!$jobID) {
		echo("Please enter a Job <br>");
		$goodform = false;
	}

	// set up my query
	if ($goodform) {
		$query = "INSERT INTO Paychecks(employeeID, jobID, checkStartDate, checkEndDate, hoursWorked, wagesEarned) VALUES ('$employeeID','$jobID', '$checkStartDate', '$checkEndDate', '$hoursWorked','$wagesEarned');";
		
		// run the query
		$result = queryDB($query, $db);
		
		$query = "UPDATE Hours
				SET paycheckID=(SELECT paycheckID from Paychecks WHERE employeeID='$employeeID' AND jobID='$jobID' AND checkStartDate='$checkStartDate' AND checkEndDate='$checkEndDate' AND hoursWorked='$hoursWorked')
				WHERE date BETWEEN '$checkStartDate' AND '$checkEndDate'
				AND employeeID='$employeeID';";
		$result = queryDB($query, $db);
				
	}
}

?>

<!-- Form to enter club teams -->
<div class="row">
<div class="col-xs-12">

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<div class="form-group">
<label for="jobID">Job Name:</label>
	<?php
	$employeeId = $_SESSION['employeeId'];
		$sql = "SELECT jobID, workname FROM Jobs WHERE jobId IN (SELECT jobId FROM EmployeeJobs WHERE employeeId = '$employeeId')";
		$result = queryDB($sql, $db);

		echo "<select name='jobID'>";
		while ($row = nextTuple($result)) {
			echo "<option value='" . $row['jobID'] . "'>" . $row['workname'] . "</option>";
		}
		echo "</select>";
		
	?>
</div>

<div class="form-group">
	<label for="checkStartDate">Paycheck Start Day Worked (MM/DD/YYYY)</label>
	<input type="date" class="form-control" name="checkStartDate"/>
</div>

<div class="form-group">
	<label for="checkEndDate">Paycheck End Day Worked  (MM/DD/YYYY) </label>
	<input type="date" class="form-control" name="checkEndDate"/>
</div>

<div class="form-group">
	<label for="hoursWorked">Enter Pay here </label>
	<input type="text" class="form-control" name="wagesEarned"/>
</div>


<button type="submit" class="btn btn-default" name="submit">Add Pay</button>

</form>

</div>
</div>


<!----------------->
<!---List Paychecks--->
<!----------------->
<div class="row">
<div class="col-xs-12">
	<h2><?php echo "Paychecks"; ?></h2>
</div>
</div>

<div class="row">
<div class="col-xs-12">
<table class="table table-hover">


<thead>
<tr>
	<th>Pay Start Date</th>
	<th>Pay Check Date</th>
	<th>Workplace</th>
	<th>Wages Earned</th>
	<th>Validate Paycheck</th>
</tr>
</thead>

<tbody>
<?php
    $employeeID = $_SESSION['employeeId'];    
	// set up my query
	$query = "SELECT * from Paychecks join Jobs on Paychecks.jobID=Jobs.jobID where employeeID=$employeeID;";

	// run the query
	$result = queryDB($query, $db);
	
	while($row = nextTuple($result)) {
		echo "\n <tr>";
		echo "<td>" . $row['checkStartDate'] . "</td>";
		echo "<td>" . $row['checkEndDate'] . "</td>";
		echo "<td>" . $row['workname'] . "</td>";
		echo "<td>" . $row['wagesEarned'] . "</td>";
		echo "<td><a href='validatepaycheck.php?paycheckID=" . $row['paycheckID'] . "'>Validate this paycheck</a></td>";
		echo "</tr>";
	}
?>

</tbody>
</table>
</div>
</div>


<?php
include_once ('footer.php');	
?>        

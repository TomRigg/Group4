<?php
	include_once('forcelogin.php');
	$menuActive=3;
	$title="Please enter your hours";
	
	include_once('config.php');
	include_once('dbutils.php');
	include_once('hashutil.php');
	include_once('header.php');
?>



<?php
echo "<h2>$email</h2>";
echo "<h2>$jobID</h2>";
// Back to PHP to perform the search if one has been submitted. Note
// that $_POST['submit'] will be set only if you invoke this PHP code as
// the result of a POST action, presumably from having pressed Submit
// on the form we just displayed above.
if (isset($_POST['submit'])) {
//	echo '<p>we are processing form data</p>';
//	print_r($_POST);

	// get data from the input fields
	$jobID = $_POST['jobID'];
	$hoursWorked = $_POST['hoursWorked'];
	$dayWorked = $_POST['dayWorked'];
	$employeeId = $_SESSION['employeeId'];
	$goodform = true;
	
	// check to make sure we have an email
	if (!$hoursWorked) {
		echo("Please enter hours <br>");
		$goodform = false;
	}
	
	if (!$dayWorked) {
		echo("Please enter a date <br>");
		$goodform = false;
	}

	$query = "SELECT * from EmployeeJobs where employeeID=$employeeId and jobID=$jobID;";
	$result = queryDB($query, $db);
	if ($result) {
        $numberofrows = $result->num_rows;
		if ($numberofrows == 0){
			echo "Error you are not registered for this job. <br /><a href='paycheck.php'>Paycheck</a>";
			exit;
		}
		if ($numberofrows > 1){
			echo "You are registered for this job multiple times, contact webmaster. <br /><a href='paycheck.php'>Paycheck</a>";
			exit;
		}
		$employeejob = nextTuple($result);
		$hourlywage = $employeejob['hourlyWage'];
	}
	
	// set up my query
	//$query = "INSERT INTO Hours(jobID, employeeID, date, hoursWorked, wagesEarned) VALUES ('$jobID', (SELECT employeeID from Employees where email='$email'), '$dayWorked', '$hoursWorked', ((SELECT hourlyWage from Jobs where jobID='$jobID')*$hoursWorked));";
	$query = "INSERT INTO Hours(jobID, employeeId, date, hoursWorked, wagesEarned) VALUES ('$jobID', '$employeeId', '$dayWorked', '$hoursWorked', ((SELECT hourlyWage from EmployeeJobs where jobID='$jobID' AND employeeID=$employeeId)*$hoursWorked));";
	
	// run the query
	$result = queryDB($query, $db);

	
		
	
	}


?>


<!-- Form to enter club teams -->

<div class="row">
<div class="col-xs-12">

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<form action="hourentry.php" method="post" enctype="multipart/form-data">
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
	<label for="dayWorked">Day Worked (MM/DD/YYYY)</label>
	<input type="date" class="form-control" name="dayWorked"/>
</div>

<div class="form-group">
	<label for="hoursWorked">Hours Worked</label>
	<input type="text" class="form-control" name="hoursWorked"/>
</div>


<button type="submit" class="btn btn-default" name="submit">Add Hours</button>

</form>

</div>
</div>

<!----------------->
<!---List hours--->
<!----------------->
<div class="row">
<div class="col-xs-12">
	<h2><?php echo "Hours"; ?></h2>
</div>
</div>

<div class="row">
<div class="col-xs-12">
<table class="table table-hover">

<!-- Titles for table -->
<thead>
<tr>
	<th>Hours</th>
	<th>Job Name</th>
	<th>Date Worked</th>
	<th>Wages Earned</th>
</tr>
</thead>

<tbody>
<?php	
	// set up my query
	$query = "SELECT hoursWorked, date, workName, wagesEarned, Jobs.jobID FROM Hours, Jobs WHERE Jobs.jobID = Hours.jobID AND Hours.employeeID = $employeeId;";
	
	// run the query
	$result = queryDB($query, $db);
	
	while($row = nextTuple($result)) {
		echo "\n <tr>";
		echo "<td>" . $row['hoursWorked'] . "</td>";
		echo "<td>" . $row['workName'] . "</td>";
		echo "<td>" . $row['date'] . "</td>";
		echo "<td>" . $row['wagesEarned'] . "</td>";
		echo "</tr>";
	}
?>

</tbody>
</table>
</div>
</div>

</div> <!-- closing bootstrap container -->
</body>



<?php
include_once ('footer.php');	
?>
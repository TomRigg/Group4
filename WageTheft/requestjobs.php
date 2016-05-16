<?php
	include_once('forcelogin.php');
	$menuActive=5;
	$title="Job Requests";
	include_once('dbutils.php');
	include_once('hashutil.php');
	include_once('header.php');

	if (isset($_POST['submit'])) {
		$workname = $_POST['workname'];
		$workAddress = $_POST['workAddress'];
		$notes = $_POST['notes'];
		$employeeID = $_SESSION['employeeId'];
		$goodform = true;
		
		// check to make sure we have a workAddress
		if (!$workAddress) {
			echo("Please enter a workAddress <br>");
			$goodform = false;
		}
			
		// check to make sure we have a workname 
		if (!$workname ) {
			echo("Please enter a workname <br>");
			$goodform = false;
		}
		
		// check to make sure we have a notes
		if (!$notes) {
			echo("Please enter some notes <br>");
			$goodform = false;
		}

		// set up my query
		if ($goodform) {
			$query = "INSERT INTO JobRequests (workname, workAddress, notes, employeeID) values ('$workname', '$workAddress', '$notes', $employeeID);";
			
			// run the query
			$result = queryDB($query, $db);
			echo "job request added";
		}
	}
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<div class="form-group">
	<label for="workname">Enter the job name </label>
	<input type="text" class="form-control" name="workname"/>
</div>

<div class="form-group">
	<label for="workAddress">Enter a the job address </label>
	<input type="text" class="form-control" name="workAddress"/>
</div>

<div class="form-group">
	<label for="notes">Enter some notes </label>
	<input type="text" class="form-control" name="notes"/>
</div>

<button type="submit" class="btn btn-default" name="submit">Request Job</button>

</form>

<h2> Existing requests </h2>
<div class="row">
<div class="col-xs-12">
<table class="table table-hover">


<thead>
<tr>
	<th>Job Name</th>
	<th>Job Address</th>
	<th>Notes</th>
	<?php
		if ($userRole == 1)
	{ ?>
	<th>Add Job</th>
	<th>Delete Request</th>
	<?php } ?>
</tr>
</thead>

<tbody>
<?php
    $employeeID = $_SESSION['employeeId'];    
	// set up my query
	$query = "SELECT * from JobRequests;";

	// run the query
	$result = queryDB($query, $db);
	
	while($row = nextTuple($result)) {
		echo "\n <tr>";
		echo "<td>" . $row['workname'] . "</td>";
		echo "<td>" . $row['workAddress'] . "</td>";
		echo "<td>" . $row['notes'] . "</td>";
		if ($userRole == 1){
			echo "<td><a href='jobrequestmanagement.php?jobRequestID=" . $row['jobRequestID'] . "&action=add'>Add this job</a></td>";
			echo "<td><a href='jobrequestmanagement.php?jobRequestID=" . $row['jobRequestID'] . "&action=delete'>Delete this request</a></td>";
		}
		echo "</tr>";
	}
?>

</tbody>
</table>
</div>
</div>
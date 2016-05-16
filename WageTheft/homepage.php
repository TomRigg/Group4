<?php
	include_once('forcelogin.php');
	$menuActive=2;
	$title="Employee Home";
	include_once('dbutils.php');
	include_once('hashutil.php');
	include_once('header.php');


?>


<?php

$email = $_SESSION['email'];

$query = "select userid, hashedPass from Users where email='" . $email . "'";
    $result = $db->query($query);
    if ($result) {
        $numberofrows = $result->num_rows;
        $row = $result->fetch_assoc();
        if ($numberofrows > 0) {
            $hashedPass = $row['hashedPass'];
			$userID = $row['userid'];
				$employeeQuery = "select employeeId From Employees Where userId ='" .$row['userid']. "'";
				$employeeResult = $db->query($employeeQuery);
				if ($employeeResult) {
					$employeeNumberOfRows = $employeeResult->num_rows;
					$employeeRow = $employeeResult->fetch_assoc();
					if ($employeeNumberOfRows > 1) {
						reportErrorAndDie("Error more than one employee is associated with that email address, contact your web admin. <a href='login.php'>Try again</a>.<p>" . $db->error, $query);
					}
					if ($employeeNumberOfRows == 1) {
						$_SESSION['employeeId'] = $employeeRow['employeeId'];
					}
				}
			}
	}
?>



<?php

echo '<h2>Your Hours</h2>';
$employeeId = $_SESSION['employeeId'];

$query = "SELECT workName, sum(hoursWorked) AS hoursWorked, date
			FROM Hours
				JOIN Jobs ON Jobs.jobID = Hours.jobID
				JOIN EmployeeJobs ON Jobs.jobID = EmployeeJobs.jobID 
				JOIN Employees ON Employees.employeeID = EmployeeJobs.employeeID
				JOIN Users ON Employees.userID = Users.userID
			WHERE Hours.employeeID = '$employeeId'
			AND Users.email = '$email'
			GROUP BY workName;";
	
	// run the query 
	$result = queryDB($query, $db);

	$dataArray = array(array( 'workName', 'hoursWorked', 'date'));
		while($row = mysqli_fetch_array($result)) {
    // parse the values as integer (int) or floating point (float), as appropriate
    $dataArray[] = array( (string) $row['workName'], (float) $row['hoursWorked'], (string) Date($row['date']));
}
	
?>

<html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable(<?php echo json_encode($dataArray); ?>);
	  
	  var options = {
          title: 'Hours Worked',
          legend: { position: 'bottom' }
        };
      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data, {width: 800, height: 300});
	  
	  
	  
    }

    </script>
  </head>

  <body>
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
  </body>
</html>
<?php
// Back to PHP to perform the search if one has been submitted. Note
// that $_POST['submit'] will be set only if you invoke this PHP code as
// the result of a POST action, presumably from having pressed Submit
// on the form we just displayed above.

if (isset($_POST['submit'])) {
	
	
//	echo '<p>we are processing form data</p>';
//	print_r($_POST);

	// get data from the input fields
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	
	// check to make sure we have an email
	if (!$email) {
		header("Location: register.php");
	}
	
	if (!$password) {
		header("Location: register.php");
	}

	// check if user is in the database
		// connect to database
	$db = connectDB($DBHost,$DBUser,$DBPasswd,$DBName);
	
	// set up my query
	$query = "SELECT email, hashedPass FROM Users WHERE email='$email';";
	
	// run the query
	$result = queryDB($query, $db);
	
	
	// check if the email is there
	if (nTuples($result) > 0) {
		$row = nextTuple($result);
		
		if ($row['hashedPass'] == crypt($password, $row['hashedPass'])) {
			// Password is correct
			if (session_start()) {
				$_SESSION['email'] = $email;
				header('Location: register.php');
			} else {
				punt("Unable to create session");
			}
		} else {
			// Password is not correct
			punt('The password you entered is incorrect');
		}
	} else {
		punt("The email '$email' is not in our database");
	}	
	
}

?>
	<h2>Missing Wages</h2>
<div class="row">
<div class="col-xs-12">
<table class="table table-hover">

<!-- Titles for table -->
<thead>
<tr>
	<th>Employee</th>
	<th>Wages Earned</th>
	<th>Wages Missing</th>
	<th>Employer</th>
	<th>Submit a Wage Theft claim</th>
</tr>
</thead>

<tbody>
<?php
	// connect to database
	$db = connectDB($DBHost,$DBUser,$DBPasswd,$DBName);
	
	$query = "SELECT workName, Hours.employeeID, name, sum(Hours.wagesEarned) AS HourswagesEarned, (sum(Paychecks.wagesEarned)- sum(Hours.wagesEarned)) AS WagesMissing
			FROM Hours 
				JOIN Paychecks ON Paychecks.employeeID = Hours.employeeID
				JOIN Employees ON Employees.employeeID = Hours.employeeID
				JOIN EmployeeJobs ON EmployeeJobs.employeeID = Employees.employeeID
				JOIN Jobs on Jobs.jobID = Hours.jobID
				JOIN Users on Users.userID = Employees.userID
			WHERE Hours.employeeID = '$employeeId'
			GROUP BY Hours.employeeID
			HAVING ((sum(Hours.wagesEarned) - sum(Paychecks.wagesEarned)) > 0)";
			
	// run the query
	$result = queryDB($query, $db);
	
	while($row = nextTuple($result)) {
		echo "\n <tr>";
		echo "<td>" . $row['name'] . "</td>";
		echo "<td>" . $row['HourswagesEarned'] . "</td>";
		echo "<td>" . $row['WagesMissing'] . "</td>";
		echo "<td>" . $row['workName'] . "</td>";
		echo "<td>" . "<a href='mailto:abc@hotmail.com?subject=Wage%20Theft%20Claim'>Submit a claim</a>" . "</td>";
		echo "</tr>";
	}
	
?>

</tbody>



<div class="row">
<div class="col-xs-12">
<table class="table table-hover">

<!-- Titles for table -->
<thead>
<tr>
	<th>Your Jobs</th>
	<th>Hourly Wages</th>
	<th>Remove Job</th>
</tr>
</thead>

<tbody>
<?php
	// connect to database
	$db = connectDB($DBHost,$DBUser,$DBPasswd,$DBName);
	
	// set up my query
	//$query = "SELECT Jobs.workname FROM Jobs, Users WHERE Jobs.employeeID = Users.userID AND Users.email='$_SESSION['email']';";
	
	//$query = "SELECT Jobs.workname FROM Jobs INNER JOIN Users ON Jobs.employeeID = Users.userID WHERE Users.email='$_SESSION['email']';";
	
	//$query = "SELECT workname FROM Jobs WHERE employeeID IN (SELECT userID FROM Users WHERE email='$email');";
	
	$query = "SELECT workname, hourlyWage, Jobs.jobID
			FROM Jobs 
				JOIN EmployeeJobs ON Jobs.jobID = EmployeeJobs.jobID 
				JOIN Employees ON Employees.employeeID = EmployeeJobs.employeeID
				JOIN Users ON Employees.userID = Users.userID 
			WHERE Users.email = '$email';";
			
	// run the query
	$result = queryDB($query, $db);
	
	while($row = nextTuple($result)) {
        $jobID = $row['jobID'];
		echo "\n <tr>";
		echo "<td>" . $row['workname'] . "</td>";
		echo "<td>" . $row['hourlyWage'] . "</td>";
        echo "<td><a href='employeeremovejob.php?jobID=$jobID&employeeID=$employeeId'>Remove this job</a></td>";
		echo "</tr>";
	}
?>

</tbody>
</table>
</div>
</div>

<div class="container-fluid">
		<img align='left' src="">
</div>

<!-- Page header -->
<div class="row">
<div class="col-xs-12">
<div class="page-header">
	<h1><?php echo "Add a Job!"?></h1>
</div>
</div>
</div>
<!--
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Wage Theft Homepage Please log in below!</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Employee</a></li>
      <li><a href="#">Wage Theft</a></li>
      <li><a href="register.php">Please Register Here First!</a></li>
    </ul>
  </div>
</nav>
-->
<form action="employeeaddjob.php" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="jobname">Job Name:</label>
	<?php
		$sql = "SELECT jobID, workname FROM Jobs";
		$result = queryDB($sql, $db);

		echo "<select name='jobID'>";
		while ($row = nextTuple($result)) {
			echo "<option value='" . $row['jobID'] . "'>" . $row['workname'] . "</option>";
		}
		echo "</select>";
	?>
	<br>
	<label for="jobWage">Job Wage:</label>
	<input type="text" class="form-control" id="jobWage" name="jobWage" >
  </div>

  <button type="submit" class="btn btn-default">Submit Job</button>
</form>

<?php
include_once ('footer.php');	
?>
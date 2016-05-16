<?php
include_once('config.php');
include_once('util.php');
include_once('dbutils.php');
include_once('utils.php');
include_once('header.php');
$menuActive=9;
?>

	<h2>Possible Wage Theft Cases</h2>
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
	<th>Email</th>
</tr>
</thead>

<tbody>
<?php
	// connect to database
	$db = connectDB($DBHost,$DBUser,$DBPasswd,$DBName);
	
	$query = "SELECT workName, Hours.employeeID, name, sum(Hours.wagesEarned) AS HourswagesEarned, (sum(Paychecks.wagesEarned)- sum(Hours.wagesEarned)) AS WagesMissing, email
			FROM Hours 
				JOIN Paychecks ON Paychecks.employeeID = Hours.employeeID
				JOIN Employees ON Employees.employeeID = Hours.employeeID
				JOIN EmployeeJobs ON EmployeeJobs.employeeID = Employees.employeeID
				JOIN Jobs on Jobs.jobID = Hours.jobID
				JOIN Users on Users.userID = Employees.userID
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
		echo "<td>" . $row['email'] . "</td>";
		echo "</tr>";
	}
	
?>

</tbody>
</table>
</div>
</div>



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

echo '<h2>Total Hours</h2>';
$employeeId = $_SESSION['employeeId'];

$query = "SELECT workName, sum(hoursWorked) AS hoursWorked, date
			FROM Hours
				JOIN Jobs ON Jobs.jobID = Hours.jobID
				JOIN EmployeeJobs ON Jobs.jobID = EmployeeJobs.jobID 
				JOIN Employees ON Employees.employeeID = EmployeeJobs.employeeID
				JOIN Users ON Employees.userID = Users.userID
			GROUP BY workName;";
	
	// run the query 
	$result = queryDB($query, $db);
	$dataArray = array(array( 'workName', 'hoursWorked', 'date'));
		while($row = mysqli_fetch_array($result)) {
    // parse the values as integer (int) or floating point (float), as appropriate
    $dataArray[] = array( (string) $row['workName'], (int) $row['hoursWorked'],  (string) Date($row['date']));
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

<?php echo '<h2>Job Table</h2>'; ?>
<div class="row">
<div class="col-xs-12">
<table class="table table-hover">

<!-- Titles for table -->
<thead>
<tr>
	<th>All Jobs</th>
	<th>Hourly Wages</th>
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
	
	$query = "SELECT workname, hourlyWage 
			FROM Jobs 
				JOIN EmployeeJobs ON Jobs.jobID = EmployeeJobs.jobID 
				JOIN Employees ON Employees.employeeID = EmployeeJobs.employeeID
				JOIN Users ON Employees.userID = Users.userID
			ORDER BY workName";
			
	// run the query
	$result = queryDB($query, $db);
	
	while($row = nextTuple($result)) {
		echo "\n <tr>";
		echo "<td>" . $row['workname'] . "</td>";
		echo "<td>" . $row['hourlyWage'] . "</td>";
		echo "</tr>";
	}
?>

</tbody>
</table>
</div>
</div>


<?php echo '<h2>Employee Table</h2>'; ?>
<div class="row">
<div class="col-xs-12">
<table class="table table-hover">

<!-- Titles for table -->
<thead>
<tr>
	<th>Name</th>
	<th>Hourly Wages</th>
	<th>Work Name</th>
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
	
	$query = "SELECT name, hourlyWage, workName 
			FROM Jobs 
				JOIN EmployeeJobs ON Jobs.jobID = EmployeeJobs.jobID 
				JOIN Employees ON Employees.employeeID = EmployeeJobs.employeeID
				JOIN Users ON Employees.userID = Users.userID
			ORDER BY name";
	// run the query
	$result = queryDB($query, $db);
	
	while($row = nextTuple($result)) {
		echo "\n <tr>";
		echo "<td>" . $row['name'] . "</td>";
		echo "<td>" . $row['hourlyWage'] . "</td>";
		echo "<td>" . $row['workName'] . "</td>";
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
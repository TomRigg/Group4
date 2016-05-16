<?php
include_once('forcelogin.php');
include_once('config.php');
include_once('util.php');
include_once('dbutils.php');
include_once('utils.php');

$menuActive=9;
?>
<?php
include_once('header.php');
?>

	<h2>Total Users and Pending Job requests</h2>
<div class="row">
<div class="col-xs-12">
<table class="table table-hover">

<!-- Titles for table -->
<thead>
<tr>
	<th>First Name</th>
	<th>Last Name</th>
	<th>Email</th>
</tr>
</thead>

<tbody>
<?php

// connect to database
$db = connectDB($DBHost,$DBUser,$DBPasswd,$DBName);

	$query = "SELECT * from Users";
			
	// run the query
	$result = queryDB($query, $db);
	
	while($row = nextTuple($result)) {
		echo "\n <tr>";
		echo "<td>" . $row['firstname'] . "</td>";
		echo "<td>" . $row['lastname'] . "</td>";
		echo "<td>" . $row['email'] . "</td>";
		echo "</tr>";
	}
	

?>

<?php

echo '<h2>Total Users</h2>';
$userId = $_SESSION['userID'];

$query = "SELECT * from Users;";
	
	// run the query 
	$result = queryDB($query, $db);
	$dataArray = array(array( 'fname', 'lname', 'email'));
		while($row = mysqli_fetch_array($result)) {
    // parse the values as integer (int) or floating point (float), as appropriate
    $dataArray[] = array( (string) $row['fname'], (int) $row['lname'],  (string) Date($row['email']));
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
          title: 'Total Users on Site',
          legend: { position: 'side' }
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
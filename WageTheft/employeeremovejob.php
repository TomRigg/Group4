<?php
	include_once('forcelogin.php');
	$menuActive=7;
	$title="Employee Remove Job Page";
	include_once('header.php');
 // get data from fields
    $useremail = $_SESSION['email'];
    $employeeId = $_GET['employeeID'];
    $jobID = $_GET['jobID'];
    
  // Set up the deletion query.
  $query1 = "DELETE FROM EmployeeJobs WHERE employeeId='$employeeId' AND jobID='$jobID';";
  $result1 = queryDB($query1, $db); 
  
?>

	<div class='panel panel-default'>
	<div class='panel-body'>
	The job <?php echo $jobID; ?> was deleted from your list of jobs<br>
	Return to <a href='homepage.php'>Homepage</a>
	</div></div>
	<?php include_once ('footer.php');?>


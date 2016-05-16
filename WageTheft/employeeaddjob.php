<?php
	include_once('forcelogin.php');
	$menuActive=2;
	$title="Employee Add Job Page";
	include_once('header.php');
 // get data from fields
    $useremail = $_SESSION['email'];
	$employeeId = $_SESSION['employeeId'];
    $jobID = $_POST['jobID'];
	$jobWage = $_POST['jobWage'];
	
// check that we have an jobID
    if (!$jobID) {
        echo "Hey, you didn't add a job name. Please try again. <br /><a href='homepage.php'>Homepage</a>";
		
        exit;
    }
	 if (!$jobWage) {
        echo "Hey, you didn't add a job wage. Please try again. <br /><a href='homepage.php'>Homepage</a>";
		
        exit;
    }
 
	$query1 = "INSERT INTO EmployeeJobs(employeeID, jobID, hourlyWage) VALUES ($employeeId, $jobID, $jobWage);";
	$result1 = queryDB($query1, $db);
	
	$query = "SELECT workname from Jobs where jobID = $jobID";
	$result = queryDB($query, $db);
	$jobname = nextTuple($result);
	
	echo "<div class='panel panel-default'>\n";
	echo "\t<div class='panel-body'>\n";
	echo "\t\tThe job " . $jobname['workname'] . " was added to your list of jobs<br>";
	echo "Return to <a href='homepage.php'>Homepage</a>";
	echo "</div></div>\n";
	include_once ('footer.php');
?>
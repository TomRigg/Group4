<?php
 // get data from fields
	include_once('forcelogin.php');
	include_once('adminonly.php');
	include_once('header.php');
    $jobname = $_POST['jobname'];
    $jobaddress = $_POST['jobaddress'];
	
    // check that we have a name
/*	
   if (!$jobname) {
        echo "Hey, you didn't add a job name. Please try again.";
		
        exit;
    }
    
        // check that we have an address
    if (!$jobaddress) {
        echo "Hey, you didn't add an address. Please try again.";

		exit;
    }
	
	if (!$hourlywage) {
        echo "Hey, you didn't add an hourly wage. Please try again.";

		exit;
    }
	*/
	
	$query = "INSERT INTO Jobs(workAddress, workname) VALUES ('$jobaddress', '$jobname');";
	$result = queryDB($query, $db);
	
	echo "<div class='panel panel-default'>\n";
	echo "\t<div class='panel-body'>\n";
	echo "\t\tThe job " . $jobname . " was added to the database\n";
	echo "</div></div>\n";
?>
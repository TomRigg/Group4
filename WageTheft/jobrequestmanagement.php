<?php
 // get data from fields
	include_once('forcelogin.php');
	include_once('adminonly.php');
	include_once('header.php');
    $jobRequestID = $_GET['jobRequestID'];
    $action = $_GET['action'];
	
    // check that we have a name

   if (!$jobRequestID) {
        echo "Hey, you didn't provide a jobRequestID.";
		
        exit;
    }
    
        // check that we have an address
    if (!$action) {
        echo "Hey, you didn't provide a action.";

		exit;
    }
	
	if ($action == "add"){
		$jrquery = "SELECT * from JobRequests WHERE jobRequestID = $jobRequestID;";
		$jrresult = queryDB($jrquery, $db);
		$numberofrows = $jrresult->num_rows;
		$row = $jrresult->fetch_assoc();
		if ($numberofrows == 0) {
			echo "no job request with that ID found";
		}
		if ($numberofrows > 1) {
			echo "Multiple job request found with that ID, contact webmaster";
		}
		if ($numberofrows == 1) {
			$jobaddress = $row['workAddress'];
			$jobname = $row['workname'];
			$query = "INSERT INTO Jobs(workAddress, workname) VALUES ('$jobaddress', '$jobname');";
			$result = queryDB($query, $db);
			
			echo "<div class='panel panel-default'>\n";
			echo "\t<div class='panel-body'>\n";
			echo "\t\tThe job " . $jobname . " was added to the database\n";
			echo "</div></div>\n";
		}
	}
	
	if ($action == "delete" || $action == "add"){
		$query = "delete FROM JobRequests WHERE jobRequestID = $jobRequestID;";
		$result = queryDB($query, $db);
		echo "<div class='panel panel-default'>\n";
		echo "\t<div class='panel-body'>\n";
		echo "\t\tThe job request " . $jobRequestID . " was deleted from the database\n";
		echo "</div></div>\n";
	}
	
	include_once('footer.php');
?>
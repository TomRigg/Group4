<?php
	include_once('forcelogin.php');
	$menuActive=7;
	$title="Set permissions for users";
	include_once('config.php');
	include_once('dbutils.php');
	include_once('header.php');
	
	$roleID = $_GET['roleID'];
	$userID = $_GET['userID'];
	$goodform = true;
	if (!$roleID) {
		echo("Please enter roleID <br>");
		$goodform = false;
	}
	if (!$userID) {
		echo("Please enter userID <br>");
		$goodform = false;
	}
	if ($goodform){
		$query = "update Users set role=". ($roleID) . " where userID = " . ($userID);
		$result = queryDB($query, $db);
		echo "\t\tThe user " . $userID . " was assigned role id ".$roleID."<br>";
	}
	echo "Return to <a href='permissions.php'>Permissions</a>";
?>

<?php
include_once ('footer.php');	
?> 
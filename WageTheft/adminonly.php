<?php
include_once('config.php');
include_once('dbutils.php');

    session_start();
    if (!isset($_SESSION['email'])) {
        // if this variable is not set, then kick user back to login screen
        header("Location: " . $baseURL . "login.php");
    }
	$email = $_SESSION['email'];
	$query = "select role from Users where email = '" . $email . "'";
	$result = queryDB($query, $db);
	$numberofrows = $result->num_rows;
    $row = $result->fetch_assoc();
    if ($numberofrows == 0) {
		// if number of rows is 0, then kick user to register page
        header("Location: " . $baseURL . "register.php");
	}
	if ($numberofrows > 1) {
		// if number of rows is greater than 1, we have multiple users with the same email
		echo "error, your email was found multiple times, contact webmaster";
		exit();
	}
	if ($numberofrows == 1) { 
		if ($row['role'] != 1){
			header("Location: " . $baseURL . "login.php");
		}
	}
?>	
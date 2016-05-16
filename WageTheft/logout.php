<?php
	// logout user by unsetting session variable and destroying session
	
	session_start();
	session_unset();
	session_destroy();

	// redirect user to login.php
	header('Location: login.php');
	
?>
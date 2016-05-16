<?php

    session_start();
    if (!isset($_SESSION['email'])) {
        // if this variable is not set, then kick user back to login screen
        header("Location: " . $baseURL . "login.php");
    }
	$email = $_SESSION['email'];
?>
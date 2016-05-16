<?php
// Site configuration.

include_once "utils.php";

// Server information.
$Proto = "http://";
$Host = $_SERVER['SERVER_NAME'];
$Base = "/~jdmolumby/web/";

// Title to use in browser title bar.
$Name = "Jacob Molumby";
$Email = "jacob-molumby@uiowa.edu";
$Logo = "music-note-5.png";

// DB connection (on localhost, the web server).
$DBName = "db_jdmolumby";
$DBHost = "dbdev.cs.uiowa.edu";
$DBUser = "jdmolumby";
$DBPasswd = "Niyuw5qVL.KH";
$db = connectDB ($DBHost,$DBUser,$DBPasswd,$DBName);
?>
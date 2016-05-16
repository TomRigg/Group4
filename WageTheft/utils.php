<?php
// Include the DB utilities.
include_once "dbutils.php";

// A few basic utilities for URL manipulation. 
function genURL($path) {
  // Remind PHP you want the global values of these variables (config.php).
  global $Proto, $Host, $Base;
  return($Proto . $Host . $Base . $path);
}
?>

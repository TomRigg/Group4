<?php
// Contains some common PHP db functions. Here, we always check the  
// return object/value for errors.  Uses the mysqli functional interface
// as opposed to the mysqli object interface.

// Connect to DB: config.php contains DB configuration.
function connectDB($dbhost,$dbuser,$dbpasswd,$dbname) {
  $db = mysqli_connect($dbhost,$dbuser,$dbpasswd,$dbname);
  if (mysqli_connect_errno() != 0)
    punt("Can't connect to MySQL server $dbhost db $dbname as user $dbuser");
  return($db);
}

// Submit a query and return a result object. This is just syntactic 
// sugar and error trapping.
function queryDB($query, $db) {
  $result = mysqli_query($db, $query);
  if (!$result)
    punt ('Error in queryDB()', $query, $db);
  return ($result);
}

// How many tuples in the result? Syntactic sugar.
function nTuples($result) {
  return(mysqli_num_rows($result));
}

// Get next record as an associative array. Syntactic sugar.
function nextTuple($result) {
  return (mysqli_fetch_assoc($result));
}

// Used for debugging. If invoked with a SQL query string
// as the optional second argument, will also retrieve and
// display MySQL error information. Otherwise, if invoked
// only with one argument, will print that argument.
function punt($message, $query = '', $db = '') {
  $lastPart = '';
  // Check to see if error resulted from a bad query
  if ($query != '')
    $lastPart = "<br><i>$query</i>\n" . '<br>[' . mysqli_errno($db) . '] ' . mysqli_error($db) . "\n";
  die("\n<br><br><b>Error: $message</b>\n" . $lastPart);
}
?>

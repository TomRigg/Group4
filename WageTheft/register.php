<?php
	$menuActive=1;
	$title="Please enter your information to register";
	
	include_once('config.php');
	include_once('dbutils.php');
	include_once('hashutil.php');
	include_once('header.php');
?>


<?php
// Back to PHP to perform the search if one has been submitted. Note
// that $_POST['submit'] will be set only if you invoke this PHP code as
// the result of a POST action, presumably from having pressed Submit
// on the form we just displayed above.
if (isset($_POST['submit'])) {
//	echo '<p>we are processing form data</p>';
//	print_r($_POST);

	// get data from the input fields
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	$goodform = true;
	
	// check to make sure we have an email
	if (!$firstname) {
		echo("Please enter a first name <br>");
		$goodform = false;
	}
	
	if (!$lastname) {
		echo("Please enter a last name <br>");
		$goodform = false;
	}
	
	if (!$email) {
		echo("Please enter an email <br>");
		$goodform = false;
	}

	if (!$password1) {
		echo("Please enter a password <br>");
		$goodform = false;
	}

	if (!$password2) {
		echo("Please enter your password twice <br>");
		$goodform = false;
	}
	
	if ($password1 != $password2) {
		echo("Your two passwords are not the same <br>");
		$goodform = false;
	}
	
	// set up my query
	$query = "SELECT email FROM Users WHERE email='$email';";
	
	// run the query
	$result = queryDB($query, $db);
	
	// check if the email is there
	if (nTuples($result) > 0) {
		echo("The email address $email is already in the database <br>");
		$goodform = false;
	}
	
	// generate hashed password
	if ($goodform) {
		$hashedPass = crypt($password1, getSalt());
		
		// set up my query
		$query = "INSERT INTO Users(hashedPass, firstname, lastname, email, role) VALUES ('$hashedPass', '$firstname', '$lastname', '$email', 2);";
		
		// run the query
		$result = queryDB($query, $db);
		
		//$query1 = "SELECT userID from Users WHERE email='$email';";
		//$userid = queryDB($query1, $db);
		
		$query2 = "INSERT INTO Employees(name, userID) VALUES ('$firstname $lastname', (SELECT userID from Users WHERE email='$email'));";
		$result2 = queryDB($query2, $db);
		
		//$useridquery = "SELECT userID from Users WHERE email='$email';";
		//$userid = queryDB($useridquery, $db);
		//$alterquery = "UPDATE Employees SET userID='$userid' WHERE "
		
		

		
		
		// tell users that we added the player to the database
		echo "<div class='panel panel-default'>\n";
		echo "\t<div class='panel-body'>\n";
		echo "\t\tThe user " . $email . " was added to the database\n";
		echo "</div></div>\n";
	}
}
?>


<!-- Form to enter club teams -->
<div class="container">
<div class="col-xs-12">

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<div class="form-group">
	<label for="firstname">First Name</label>
	<input type="text" class="form-control" name="firstname"/>
</div>

<div class="form-group">
	<label for="lastname">Last Name</label>
	<input type="text" class="form-control" name="lastname"/>
</div>

<div class="form-group">
	<label for="email">Email</label>
	<input type="email" class="form-control" name="email"/>
</div>

<div class="form-group">
	<label for="password1">Password</label>
	<input type="password" class="form-control" name="password1"/>
</div>

<div class="form-group">
	<label for="password2">Please enter password again</label>
	<input type="password" class="form-control" name="password2"/>
</div>

<button type="submit" class="btn btn-default" name="submit">Add</button>

</form>

</div>
</div>

</body>
</html>

<?php
include_once ('footer.php');	
?>
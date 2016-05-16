<?php
   	$Title = "Login Please";
	include_once('header.php');

    // get data from fields
    $email = $_POST['email'];
    $password = $_POST['password'];
	
    // check that we have an email
    if (!$email) {
        echo "Hey, you didn't add an email. Please <a href='login.php'>try again</a>";
        exit;
    }
    
        // check that we have an email
    if (!$password) {
        echo "No password received";
?>
		 <form action="login.php">
			<button type="submit">Try again</button>
		</form>
<?php 
		exit;
    }
    
	
    // get hashed password based on email
    $query = "select userid, hashedPass from Users where email='" . $email . "'";
    $result = $db->query($query);
    if ($result) {
        $numberofrows = $result->num_rows;
        $row = $result->fetch_assoc();
        if ($numberofrows > 0) {
            $hashedPass = $row['hashedPass'];
            
            // check if the password matches the hashed version in the database
            // for version 5.5 or later we would use
            // if (password_verify($password, $hashedPass)) {
            if ($hashedPass == crypt($password, $hashedPass)) {
                // we have verified the password, query db for employee ID
				//$sessionquery = "SELECT userID FROM Users WHERE email='$email';";
	
				// run the query
				//$result = queryDB($query, $db);
                session_start();
				//$_SESSION['result'] = $result;
                $_SESSION['email'] = $email;
				$_SESSION['userId'] = $row['userid'];
				$employeeQuery = "select employeeId From Employees Where userId ='" .$row['userid']. "'";
				$employeeResult = $db->query($employeeQuery);
				if ($employeeResult) {
					$employeeNumberOfRows = $employeeResult->num_rows;
					$employeeRow = $employeeResult->fetch_assoc();
					if ($employeeNumberOfRows > 1) {
						reportErrorAndDie("Error more than one employee is associated with that email address, contact your web admin. <a href='login.php'>Try again</a>.<p>" . $db->error, $query);
					}
					if ($employeeNumberOfRows == 1) {
						$_SESSION['employeeId'] = $employeeRow['employeeId'];
					}
				}
				// Below (replace input.php with content page)
					Header("Location: " . $baseURL . "homepage.php");
            } else {
                // wrong password
                reportErrorAndDie("Wrong password. <a href='login.php'>Try again</a>.<p>" . $db->error, $query);
            }
        } else {
            reportErrorAndDie("Email not in our system. <a href='login.php'>Try again</a>.<p>" . $db->error, $query);
        }
    } else {
        reportErrorAndDie("Could not run authorization.<p>" . $db->error, $query);
    }
	
    include_once('footer.php');
?>
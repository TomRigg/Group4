<?php
	include_once('forcelogin.php');
	$menuActive=3;
	$title="Paycheck Validation";
	include_once('dbutils.php');
	include_once('hashutil.php');
	include_once('header.php');

	$paycheckID = $_GET['paycheckID'];
	
	if (!$paycheckID) {
        echo "Hey, you didn't choose a paycheck. Please try again. <br /><a href='paycheck.php'>Paycheck</a>";
        exit;
    }
	
	$query = "SELECT * from Paychecks where paycheckID=$paycheckID;";
	
	$result = queryDB($query, $db);
	$paycheck = nextTuple($result);
	$employeeID = $paycheck['employeeID'];
	$jobID = $paycheck['employeeID'];
	$checkStartDate = $paycheck['checkStartDate'];
	$checkEndDate = $paycheck['checkEndDate'];
	$wagesfrompaycheck = $paycheck['wagesEarned'];
	$wagesfromhours = 0;
	
	$hoursquery = "SELECT SUM(wagesEarned) as wagesSummed from Hours where employeeID=$employeeID and jobID=$jobID and date >= '$checkStartDate' and date <= '$checkEndDate';";
	$hoursresult = queryDB($hoursquery, $db);
	if ($hoursresult) {
		$wagesfromhours = nextTuple($hoursresult)['wagesSummed'];
	}
	else {
		echo "Error calculating wages from hours, contact webmaster. <br /><a href='paycheck.php'>Paycheck</a>";
        exit;
	}
	echo "wagesfrompaycheck = $wagesfrompaycheck <br>";
	echo "wagesfromhours = $wagesfromhours <br>";
?>


<?php
echo "Return to <a href='paycheck.php'>Paycheck</a>";
include_once ('footer.php');	
?>
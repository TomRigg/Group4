<?php
	include_once('forcelogin.php');
	include_once('adminonly.php');
	include_once('config.php');
	include_once('dbutils.php');
	$menuActive=7;
	$title="Set permissions for users";
	include_once('header.php');
	

?>
<table class="table table-hover">

<!-- Titles for table -->
<thead>
<tr>
	<th>User</th>
	<th>Current Role</th>
	<th>Set as User</th>
	<th>Set as NonProfit</th>
	<th>Set as Admin</th>
</tr>
</thead>

<tbody>
<?php

	
		
	$query = "Select Users.userID, Users.email, Roles.roleID, Roles.rolename FROM Users JOIN Roles ON Users.role = Roles.roleID";
			
	// run the query
	$queryresult = queryDB($query, $db);
	
	while($row = nextTuple($queryresult)) {
		
		echo "\n <tr>";
		echo "<td>" . $row['email'] . "</td>";
		echo "<td>" . $row['rolename'] . "</td>";
		echo "<td><a href='setpermission.php?userID=" . $row['userID'] . "&roleID=2'>Set as User</a></td>";
		echo "<td><a href='setpermission.php?userID=" . $row['userID'] . "&roleID=3'>Set as NonProfit</a></td>";
		echo "<td><a href='setpermission.php?userID=" . $row['userID'] . "&roleID=1'>Set as Admin</a></td>";
		echo "</tr>";
	}
	
?>

</tbody>
</table>

<?php
include_once ('footer.php');	
?>
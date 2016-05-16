<?php
	include_once('forcelogin.php');
	include_once('adminonly.php');
	$menuActive=6;
	include_once('dbutils.php');
	include_once('header.php');

?>

<form action="jobprocess.php" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="jobname">Job Name:</label>
    <input type="text" class="form-control" id="jobname" name="jobname">

	<label for="jobaddress">Job Address:</label>
    <input type="text" class="form-control" id="jobaddress" name="jobaddress" >
	
  </div>

  <button type="submit" class="btn btn-default">Submit Job</button>
</form>

<?php
include_once ('footer.php');	
?>
<?php
include_once('config.php');
include_once('util.php');
include_once('dbutils.php');
include_once('utils.php');
if(!isset($_SESSION)) session_start();
?>

<link rel="stylesheet" type="text/css" href="style.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link href='https://fonts.googleapis.com/css?family=Anonymous+Pro' rel='stylesheet' type='text/css'>

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <style>
    body {
      font: 16px Anonymous Pro, sans-serif;
      line-height: 1.8;
      color: #696969;
  }
  .navbar {
      padding-top: 15px;
      padding-bottom: 15px;
      border: 0;
      border-radius: 0;
      margin-bottom: 0;
      font-size: 15px;
      letter-spacing: 3px;
  }
  .navbar-nav  li a:hover {
      color: #3c4f49 !Hover Color;
  </style>
</head>	


	
<?php 
$email = $_SESSION['email'];
$userRole = 0;
$query = "select userid, role from Users where email='" . $email . "'";
    $result = $db->query($query);
    if ($result) {
        $numberofrows = $result->num_rows;
        $row = $result->fetch_assoc();
        if ($numberofrows > 0) {
			$userID = $row['userid'];
			$userRole = $row['role'];
		}
	}
?>			
  
 <body>
	<div class="container">

	<!-- Header -->
	<div class="row">
	<div class="col-sm-12">
	<div class="page-header">
		<h1><?php echo $title; ?></h1>
	</div>
	</div>
	</div>
	
	<!-- Menu bar -->
	<div class="row">
	<div class="col-sm-12">
	<div class="collapse navbar-collapse navbar-inverse" id="myNavbar">
		<ul class="nav navbar-nav">
			<li <?php if ($menuActive==0) echo "class='active'"; ?>><a href="login.php"><span class="glyphicon glyphicon-briefcase"> Login </span></a></li>
			<li <?php if ($menuActive==1) echo "class='active'"; ?>><a href="register.php"><span class="glyphicon glyphicon-eye-open"> Register </span></a></li>
			<?php
				if ($userRole > 0)
				{ ?>
					<li <?php if ($menuActive==2) echo "class='active'"; ?>><a href="homepage.php"><span class="glyphicon glyphicon-home"> Employee Home </span></a></li>
			<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Employee Tools <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li <?php if ($menuActive==3) echo "class='active'"; ?>><a href="hourentry.php"><span class="glyphicon glyphicon-plus"> Enter Hours </span></a></li>
					<li <?php if ($menuActive==4) echo "class='active'"; ?>><a href="paycheck.php"><span class="glyphicon glyphicon-folder-close"> Enter Paycheck </span></a></li>
					<li <?php if ($menuActive==5) echo "class='active'"; ?>><a href="requestjobs.php"><span class="glyphicon glyphicon-plus"> Request Jobs </span></a></li>
				</ul>
			</li>
			<?php } ?>
			<?php
				if ($userRole == 1)
				{ ?>
			<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Admin Tools <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li <?php if ($menuActive==10) echo "class='active'"; ?>><a href="requestjobs.php"><span class="glyphicon glyphicon-plus"> Requested Jobs </span></a></li>
					<li <?php if ($menuActive==6) echo "class='active'"; ?>><a href="adminaddjob.php"><span class="glyphicon glyphicon-file"> Add Job </span></a></li>
					<li <?php if ($menuActive==7) echo "class='active'"; ?>><a href="permissions.php"><span class="glyphicon glyphicon-user"> Permissions </span></a></li>
					<li <?php if ($menuActive==9) echo "class='active'"; ?>><a href="statistics.php"><span class="glyphicon glyphicon-home"> Admin Home </span></a></li>
	
				</ul>
			</li>
			<?php } ?>
			<?php
				if ($userRole == 1 || $userRole == 3)
				{ ?>
			<li <?php if ($menuActive==10) echo "class='active'"; ?>><a href="nonprofithome.php"><span class="glyphicon glyphicon-briefcase"> Non-Profit Home </span></a></li>
			<?php } ?>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li <?php if ($menuActive==8) echo "class='active'"; ?>><a href="logout.php"><span class="glyphicon glyphicon-log-out"> Logout&nbsp; </span></a></li>
		</ul>

		
	</div>
	</div>
	</div>
	

	

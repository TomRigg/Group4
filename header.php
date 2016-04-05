<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

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
</head>	
	
	
	
	
  
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
	<div class="navbar navbar-inverse">
		<ul class="nav nav-pills">
			<li <?php if ($menuActive==0) echo "class='active'"; ?>><a href="login.php"><span class="glyphicon glyphicon-home"> Login </span></a></li>
			<li <?php if ($menuActive==1) echo "class='active'"; ?>><a href="inputartist.php"><span class="glyphicon glyphicon-eye-open"> Input Artist </span></a></li>
			<li <?php if ($menuActive==2) echo "class='active'"; ?>><a href="input.php"><span class="glyphicon glyphicon-briefcase"> Input Song </span></a></li>
			<li <?php if ($menuActive==3) echo "class='active'"; ?>><a href="inputuser.php"><span class="glyphicon glyphicon-music"> Input User </span></a></li>
			<li <?php if ($menuActive==4) echo "class='active'"; ?>><a href="logout.php"><span class="glyphicon glyphicon-music"> Logout </span></a></li>
		</ul>
	</div>
	</div>
	</div>
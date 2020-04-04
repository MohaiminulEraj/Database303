<?php
	session_start();
?>


<!DOCTYPE html>
<html>
<head>
	<title>DARS</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="main.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="chart.php">DARS</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			    <span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
			    <ul class="navbar-nav mr-auto">

			    <?php
			    	if(isset($_SESSION['u_email'])){
			   	?>			
			    	<span>--</span>
			    	<li><a class="nav-link" href="DataEntry.php">Enter Data</a></li>
			    	<li><a class="nav-link" href="DataEntry.php">Edit Data</a></li>
			    </ul>


			    <form action="logout.php" method= "POST">
			    <button class="btn btn-outline-success my-2 my-sm-0" type="SUBMIT" name="submit">Logout</button>
			    </form>
			    <?php
			    	}else{
			    		echo'</ul><a class="btn btn-outline-success my-2 my-sm-0" href="login.php">Log in</a>
			    					<span>..</span>
			    				  <a class="btn btn-outline-success my-2 my-sm-0" href="sign.php">Sign Up</a>
			    		';
			    	}
			    ?>

		</div>
	</div>
	</nav>
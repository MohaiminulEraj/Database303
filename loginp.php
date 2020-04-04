<?php
	session_start();
	
	if(isset($_POST['submit'])){
		include_once 'connect.php';
	} else {
		header("Location: login.php");
		exit();
	}
	$mail = mysqli_real_escape_string($conn,$_POST['email']);
	$password = mysqli_real_escape_string($conn,$_POST['password']);

	if(empty($mail) || empty($password)){
		header("Location: login.php?login=empty");
		exit();
	}

	$sql= "SELECT * FROM users WHERE email='$mail'";

	$result = mysqli_query($conn, $sql);
	$resultCheck= mysqli_num_rows($result);

	if($resultCheck<1){
		header("Location: login.php?login=error");
		exit();
	}
	if($row= mysqli_fetch_assoc($result)){
		$hashPassCheck = password_verify($password, $row['password']); 
		if($hashPassCheck == false){
			header("Location: login.php?login=error");
			exit();

		}else if($hashPassCheck == true){
			$_SESSION['u_email']=  $row['email'];
			header("Location: chart.php?login=success");
			exit();
		}else{
			echo("error");
		}
	}


?>
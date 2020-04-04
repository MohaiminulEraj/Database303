<?php
	

	if(isset($_POST['submit'])){
		include_once 'connect.php';
	} else {
		header("Location: sign.php");
		exit();
	}

	$mail = mysqli_real_escape_string($conn,$_POST['email']);
	$password = mysqli_real_escape_string($conn,$_POST['password']);

	if(empty($mail) || empty($password) ){
		header("Location: sign.php?signup=empty");
		exit();
	}

	$sql= "SELECT * FROM users WHERE email='$mail'"; 

	$result = mysqli_query($conn, $sql);
	$resultCheck= mysqli_num_rows($result);

	if($resultCheck>0){
		header("Location: sign.php?signup=usertaken");
		exit();
	}else{
		$hashpass= password_hash($password, PASSWORD_DEFAULT);
		//Insert User
		$sql ="INSERT into users(email,password) VALUES ('$mail', '$hashpass') ";
		$result = mysqli_query($conn, $sql);
		
		header("Location: login.php");

		exit();
	}


?>
<?php

	if(isset($_POST['submit'])){
		include_once 'connect.php';
	} else {
		header("Location: DataEntry.php");
		exit();
	}

	$schoolId = mysqli_real_escape_string($conn,$_POST['schoolId']);
	$schoolName = mysqli_real_escape_string($conn,$_POST['schoolName']);

		if(empty($schoolId) || empty($schoolName) ){
		header("Location: DataEntry.php?School=empty");
		exit();
	}

	$sql ="INSERT into tbl_school(schoolID,schoolName) VALUES ('$schoolId', '$schoolName') ";
	
	if($result = mysqli_query($conn, $sql)){
		header("Location: DataEntry.php?addSchool=success");
	}else{
		header("Location: DataEntry.php?addSchool=error");
	}

	exit();

?>

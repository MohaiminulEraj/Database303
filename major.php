<?php

	if(isset($_POST['submit'])){
		include_once 'connect.php';
	} else {
		header("Location: DataEntry.php");
		exit();
	}

	$majorId = mysqli_real_escape_string($conn,$_POST['majorId']);
	$majorName = mysqli_real_escape_string($conn,$_POST['majorName']);
	$departmentId = $_POST['departmentId'];

	if(empty($majorId) || empty($majorName) || empty($departmentId) ){
		header("Location: DataEntry.php?major=empty");
		exit();
	}

	$sql ="INSERT into tbl_major(majorID,majorName,deptID) VALUES ('$majorId', '$majorName', 'departmentId') ";

	if($result = mysqli_query($conn, $sql)){
		header("Location: DataEntry.php?major=success");
	}else{
		header("Location: DataEntry.php?major=error");
	}


	exit();

?>
<?php

	if(isset($_POST['submit'])){
		include_once 'connect.php';
	} else {
		header("Location: DataEntry.php");
		exit();
	}

	$departmentId = mysqli_real_escape_string($conn,$_POST['departmentId']);
	$departmentName = mysqli_real_escape_string($conn,$_POST['departmentName']);
	$schoolId = $_POST['dSchoolId'];

	if(empty($departmentId) || empty($departmentName) || empty($schoolId) ){
		header("Location: DataEntry.php?deaprtment=empty");
		exit();
	}

	$sql ="INSERT into tlb_department(deptID, deptName, schoolID) VALUES ('$departmentId', '$departmentName', 'schoolId') ";

	if($result = mysqli_query($conn, $sql)){
		header("Location: DataEntry.php?department=success");
	}else{
		header("Location: DataEntry.php?department=error");
	}

	exit();

?>
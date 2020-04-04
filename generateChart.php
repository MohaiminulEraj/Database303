<?php

	if(!isset($_POST['submit'])){
		header("Location: chart.php");
	}

	$focus =$_POST['focus'];
	$start = $_POST['start'];
	$end = $_POST['end'];

	//Wahid:: write your code here
	
	include_once 'graph.php';
	include_once 'Datareport.php';
	include_once 'Datareport.view.php';



	
?>

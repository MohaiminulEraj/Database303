<?php
	session_start();
	include_once 'connect.php';
?>


<!DOCTYPE html>
<html>
<head>
	<title>DARS</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
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
			    	<li><a class="nav-link" href="updateData.php">Edit Data</a></li>
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


	<div style="background-image: url('data.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center; height: 100%; padding-top: 10%; padding-bottom: 10%; ">

	
	<div class="container">
		<?php
			$fullUrl = "http//:$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			if(strpos($fullUrl, "addSchool=empty") == true){
				echo '<div class="alert alert-danger" role="alert">
					  	All fields were not entered!
					</div>';
			}elseif(strpos($fullUrl, "addSchool=success") == true){
				echo '<div class="alert alert-success" role="alert">
					  	School Added Successfull!
					</div>';
			}elseif(strpos($fullUrl, "examMajor=success") == true){
				echo '<div class="alert alert-success" role="alert">
					  	New data Added Successfull
					</div>';
			}
	?>
        <div class="jumbotron">
			<form action="addSchool.php" method="post">
          		<h3>SCHOOL</h3>
          		<br>
			    <div class="form-row">
				    <div class="form-group col-md-4">
				      <label for="schoolId">School ID:</label>
				      <input type="text" class="form-control" id="schoolId" name="schoolId" placeholder="School ID">
				    </div>
				    <div class="form-group col-md-6">
					    <label for="schoolName">School Name:</label>
					    <input type="text" class="form-control" id="schoolName" name= "schoolName" placeholder="School of Computer Science and Engineering">
					</div>
					<div class="col-md-2">
						<br>
					   	<button type="submit" class="btn btn-primary" name="submit">Enter School</button>
					</div>
				</div>
			</form>
        </div>
        <div class="jumbotron">
			<form action="department.php" method="POST">
          		<h3>DEPARTMENT</h3>
          		<br>
			    <div class="form-row">
				    <div class="form-group col-md-3">
				      <label for="departmentId">Department ID:</label>
				      <input type="text" class="form-control" name="departmentId" placeholder="Department ID">
				    </div>
				    <div class="form-group col-md-4">
					    <label for="departmentName">Department Name:</label>
					    <input type="text" class="form-control" name="departmentName" name= "departmentName" placeholder="Department Name">
					</div>
					<div class="form-group col-md-3">
				      <label for="dSchoolId">School ID:</label>
				      <select name="dSchoolId" class="form-control">
					        <?php 
					    		$sql ="SELECT schoolID FROM tbl_school";
					    		$result = mysqli_query($conn, $sql);
					    		while($row = $result->fetch_assoc()) {
					    			echo '
					    				<option>' . $row["schoolID"]. '</option>
					    			';
					    			
					    		}
					    	?>
					    </select>
				    </div>
					<div class="col-md-2">
						<br>
					   	<button type="submit" class="btn btn-primary" name="submit">Enter Department</button>
					</div>
				</div>
			</form>
        </div>

        <div class="jumbotron">
			<form action="major.php" method="POST">
          		<h3>MAJOR</h3>
          		<br>
			    <div class="form-row">
				    <div class="form-group col-md-3">
				      <label for="majorId">Major ID:</label>
				      <input type="text" class="form-control" name="majorId" placeholder="Major ID">
				    </div>
				    <div class="form-group col-md-4">
					    <label for="majorName">Major Name:</label>
					    <input type="text" class="form-control" name="majorName" placeholder="Computer Science">
					</div>
					<div class="form-group col-md-3">
				      <label for="mDepartmentId">Deaprtment ID:</label>
				      <select name="departmentId" class="form-control">
					        <?php 
					    		$sql ="SELECT deptID FROM `tlb_department`";
					    		$result = mysqli_query($conn, $sql);
					    		while($row = $result->fetch_assoc()) {
					    			echo '
					    				<option>' . $row["deptID"]. '</option>
					    			';
					    			
					    		}
					    	?>
					    </select>
				    </div>
					<div class="col-md-2">
						<br>
					   	<button type="submit" class="btn btn-primary" name="submit">Enter Major</button>
					</div>
				</div>
			</form>
        </div>

        <div class="jumbotron">
			<form action="exam.php" method="POST">
          		<h3>EXAM</h3>
          		<br>
			    <div class="form-row">
				    <div class="form-group col-md-5">
				      <label for="Year">Year</label>
				      <input type="text" class="form-control" name="year" placeholder="2019">
				    </div>	
				    <div class="form-group col-md-4">
					    <label for="Semester">Semester</label>
					    <input type="text" class="form-control" name="semester" placeholder="Autumn">
					</div>
					
				</div>
				<div class="form-row">
					<div class="form-group col-md-5">
					    <label for="Slot">Slot</label>
					    <input type="text" class="form-control" name="slot" placeholder="1">
					</div>
				</div>  
				   <button type="submit" class="btn btn-primary" name="submit">Enter Exam</button>
			</form>
		</div>

		<div class="jumbotron">
			<form action="examMajor.php" method="POST">
          		<h3>New Major wise Exam data</h3>
          		<br>
			    <div class="form-row">
				    <div class="form-group col-md-4">
				      <label for="Year">Year</label>
				      <select name="year" class="form-control">
					        <?php 
					    		$sql ="SELECT DISTINCT year FROM `tbl_exam`";
					    		$result = mysqli_query($conn, $sql);
					    		while($row = $result->fetch_assoc()) {
					    			echo '
					    				<option>' . $row["year"]. '</option>
					    			';
					    		}
					    	?>
					    </select>
				    </div>
				    <div class="form-group col-md-4">
					    <label for="Semester">Semester</label>
					    <select name="semester" class="form-control">
					        <?php 
					    		$sql ="SELECT DISTINCT semester FROM `tbl_exam`";
					    		$result = mysqli_query($conn, $sql);
					    		while($row = $result->fetch_assoc()) {
					    			echo '
					    				<option>' . $row["semester"]. '</option>
					    			';
					    		}
					    	?>
					    </select>
					</div>
					<div class="form-group col-md-4">
					    <label for="Slot">Slot</label>
					    <select name="slot" class="form-control">
					    	<option>1</option>
					    	<option>2</option>
					    </select>
					</div>
				</div>  
				<div class="form-row">
					<div class="form-group col-md-9">
					    <label for="new">New Major wise Count:</label>
					    <textarea class="md-textarea form-control" id="New" name= "copy" placeholder="Copy Paste data Here" rows="3"></textarea>
					</div>
				</div>
				   <button type="submit" class="btn btn-primary" name="submit">Enter Exam</button>
					</div>
				</div>
			</form>
        </div>
	</div>
</div>

<?php
	include_once 'footer.php';
?>
	    
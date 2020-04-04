<?php
	include_once 'header.php';
	include_once 'connect.php';

?>

<div style="background-image: url('1.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center; height: 100%; padding-top: 10%; padding-bottom: 10%; ">

	<div class="container my-auto"> 
		<form id="chartForm" action="generateChart.php" method="POST">
        	<div class="row">
	        		<div class="col-lg-6"></div>
			        <div class="col-lg-6">
		          		<h1>Enter Parameters:</h1>
		          		<br>
					    <div class="form-row">
					    	<div class="form-group col-md-12">
						      <label for="focus" name="focus"><h4>Focus Year:  </h4></label>
						      <select name="focus" class="form-control">
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
					  	</div>
					  	<div class="form-row">
					    	<div class="form-group col-md-6">
								<label for="count"><h4>Start Year:  </h4></label>
								<select id="count" name="start" class="form-control">
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
							<div class="form-group col-md-6">
						        <label for="count"><h4>End Year:  </h4></label>
						        <select id="count" name="end" class="form-control">
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
						</div>
						<div class="form-row">
							<div class="col-lg-12"><button type="submit" name ="submit" class="btn btn-outline-light btn-lg">Create Graph</button></div>
				        </div>
					</div>
			</div>
		</form>
		
			
	      </div>
		</div>
	<div class="graph">
		<div class="container">
			<!-- 
				PLEASE ENTER GRAPHS HERE
			-->
		</div>
	</div>
	<div class="abc">
		<div class="container">
			<div class="col-lg-12"><button type="submit" class="btn btn-outline-dark btn-lg">Generate Report</button></div>
		</div>
	</div>

<?php
	include_once 'footer.php';
?>
	    
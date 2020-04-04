<?php
	include_once('header.php');
?>
	<div style="background-image: url('header.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center; height: 100%; padding-top: 10%; padding-bottom: 10%; ">
		<div class="container my-auto"> 
        <div class="row">
        	<div class="col-lg-6">
        		<?php
					$fullUrl = "http//:$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
					if(strpos($fullUrl, "signup=empty") == true){
						echo '<div class="alert alert-danger" role="alert">
							  	All fields were not entered!
							</div>';
					}elseif(strpos($fullUrl, "signup=usertaken") == true){
						echo '<div class="alert alert-danger" role="alert">
							  	A user with the email already exists!
							</div>';
					}
				?>
        	</div>
        	<div class="col-lg-5">

          	<form id="signupForm" action="signup.php" method="post">
          		<h1>Sign Up Today</h1>
          		<br>
			    <div class="form-row">
			  	  
				    <div class="form-group col-md-10">
				      <label for="inputEmail">Email</label>
				      <input type="email" class="form-control" id="email" name ="email" placeholder="Email">
				    </div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-10">
				        <label for="inputPassword">Password</label>
				        <input type="password" class="form-control" id="password" name= "password" placeholder="Password">
				    </div>
				</div>
				    <div class="form-check">
				      <input class="form-check-input" type="checkbox" id="gridCheck" name="check">
				      <label class="form-check-label" for="gridCheck">
				        I agree to give up all my Information
				      </label>
				    </div>

				   <button type="submit" class="btn btn-primary" name="submit">Sign Up</button>
			</form>
			</div>
        </div>
      </div>
	</div>
</body>
</html>



	<footer class="page-footer font-small cyan darken-3">
    
    <div class="footer-copyright text-center py-3">© 2018 Copyright:
      <a href="">Shehzan Chowdhury</a>
    </div>
  </footer>



</body>
</html>>
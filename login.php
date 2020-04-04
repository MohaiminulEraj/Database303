<?php
	include_once 'header.php';

?>

<div id="loginBody">
	<div class="container" id="loginContainer">
		<form class="text-center border border-light p-5"  action="loginp.php" method="post">

		    <h3 class="card-header py-4">
	        	<strong>Sign In</strong>
	    	</h3>
		    <input type="email" id="email" name="email" class="form-control mb-4" placeholder="E-mail">
		    <input type="password" id="password" name="password" class="form-control mb-4" placeholder="Password">

		    <button class="btn btn-info btn-block my-4" type="submit" name="submit">Sign in</button>

		    <p>Not a member?
		        <a href="sign.php">Register</a>
		    </p>
		</form>
		<?php
			$fullUrl = "http//:$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			if(strpos($fullUrl, "login=empty") == true){
				echo '<div class="alert alert-danger" role="alert">
					  	All fields were not entered!
					</div>';
			}elseif(strpos($fullUrl, "login=error") == true){
				echo '<div class="alert alert-danger" role="alert">
					  	Username or password is incorrect!
					</div>';
			}elseif(strpos($fullUrl, "logout=success") == true){
				echo '<div class="alert alert-success" role="alert">
					  	Logout Successfull!
					</div>';
			}
		?>
	</div>
</div>

<?php
	include_once 'footer.php';
?>
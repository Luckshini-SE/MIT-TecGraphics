<!DOCTYPE html>
<html lang="en">

<head>
	<?php 
	include('header.php'); 

	if(isset($_GET['ref'])){
		$qid = $_GET['ref'];
	} else {
		$qid = '';
	}
	?>

	<style>
	
	span {
		color: red;
	}

	</style>
</head>

<body>
	<main class="d-flex w-100" style="background-color:#fae8de">
		<div class="container d-flex flex-column" >
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
						<h3>Sign in to your account to continue</h3>	
							<!-- 
							<p class="lead" style="color:black">
								Sign in to your account to continue
							</p>
							-->
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
									<!--
									<div class="text-center">
										<img src="img/avatars/avatar.jpg" alt="Charles Hall" class="img-fluid rounded-circle" width="132" height="132" />
									</div>
									-->
									<form name="signin_form" method="post" action="signin_submit.php" onsubmit="return validateForm()" >
										<div class="row mb-3">
											<?php
											if(isset($_SESSION['error']) && $_SESSION['error'] != ''){
												echo '<div class="alert alert-danger" role="alert"><div class="alert-message">'.$_SESSION['error'].'</div></div>';
												$_SESSION['error'] = '';
											}
											?>
										</div>
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
											<span id="email_error" ></span>
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" />
											<span id="passw_error" ></span>
											<small>
												<a href="forgotpass.php" style="color:#eb5d1e">Forgot password?</a>
											</small>
										</div>
										<div>
											
										</div>
										<div class="text-center mt-3">
											<input type="hidden" name="quot" id="quot" value="<?php echo $qid; ?>" />
											<!-- <a href="index.html" class="btn btn-lg btn-primary">Sign in</a> -->
											<button type="submit" class="btn btn-lg" style="background-color:#eb5d1e; color:white">Sign in</button>
											<a href="index.php" class="btn btn-lg" style="background-color:white; border: 1px solid #eb5d1e; color:#eb5d1e; margin:10px;">Back</a>
										</div>
										<div class="text-center mt-3">
											<?php if(isset($_GET['ref'])){ ?>
											<p>New member? <a href="signup.php?ref=<?php echo $qid; ?>" style="color:#eb5d1e">Click here</a> to sign up!</p>
											<?php } else { ?>
											<p>New member? <a href="signup.php" style="color:#eb5d1e">Click here</a> to sign up!</p>
											<?php } ?>
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="js/app.js"></script>

	<script>

	function validateForm() {
		
		let email = document.forms["signin_form"]["email"].value;
		if (email == "") {
			document.getElementById("email_error").innerHTML = "Fill email";
			return false;
		} else {
			document.getElementById("email_error").innerHTML = "";
		}

		let password = document.forms["signin_form"]["password"].value;
		if (password == "") {
			document.getElementById("passw_error").innerHTML = "Fill password";
			return false;
		} else {
			document.getElementById("passw_error").innerHTML = "";
		}
	}

	</script>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('header.php'); ?>
</head>

<body>
	<main class="d-flex w-100" style="background-image: url('assets/img/bg1.png'); background-color:#474747; height: 650px;background-position: center;background-repeat: no-repeat;background-size: cover;position: relative;">
		<div class="container d-flex flex-column" >
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
						<h3 style="color:white">Login to continue</h3>	
							<!-- 
							<p class="lead" style="color:black">
								Sign in to your account to continue
							</p>
							-->
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
									
									<div class="text-center">
										<img src="assets/img/logo.png" alt="Charles Hall" class="img-fluid rounded-circle" width="132" height="132" />
									</div>
									
										<div class="row mb-3" id="alert_div">
											<?php
											if(isset($_SESSION['success']) && $_SESSION['success'] != ''){
												echo '<div class="alert alert-success" role="alert"><div class="alert-message">'.$_SESSION['success'].'</div></div>';
												$_SESSION['success'] = '';
											}
											if(isset($_SESSION['error']) && $_SESSION['error'] != ''){
												echo '<div class="alert alert-danger" role="alert"><div class="alert-message">'.$_SESSION['error'].'</div></div>';
												$_SESSION['error'] = '';
											}
											?>
										</div>	
										<script>
											setTimeout(function(){
											  document.getElementById('alert_div').innerHTML = '';
											}, 3000);
										</script>
									<form method="post" action="login_submit.php" >
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" />
											<!--
											<small>
												<a href="forgotpass.php" style="color:#eb5d1e">Forgot password?</a>
											</small>
											-->
										</div>
										<div>
											
										</div>
										<div class="text-center mt-3">
											<!-- <a href="index.html" class="btn btn-lg btn-primary">Sign in</a> -->
											<button type="submit" class="btn btn-lg" style="background-color:#eb5d1e; color:white">Login</button>
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

</body>

</html>
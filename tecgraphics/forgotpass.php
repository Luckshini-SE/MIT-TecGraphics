<!DOCTYPE html>
<html lang="en">

<head>
	<?php 
	include('header.php'); 
	?>

</head>

<body>
	<main class="d-flex w-100" style="background-color:#fae8de">
		<div class="container d-flex flex-column" >
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
						<h3>Enter email address to reset password</h3>
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
									<form method="post" action="forgotpass_submit.php" >
										<div class="row mb-3">
											<?php
											if(isset($_SESSION['error']) && $_SESSION['error'] != ''){
												echo '<div class="alert alert-danger" role="alert"><div class="alert-message">'.$_SESSION['error'].'</div></div>';
												$_SESSION['error'] = '';
											}
											if(isset($_SESSION['success']) && $_SESSION['success'] != ''){
												echo '<div class="alert alert-success" role="alert"><div class="alert-message">'.$_SESSION['success'].'</div></div>';
												$_SESSION['success'] = '';
											}
											?>
										</div>
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
										</div>
										<div>
											
										</div>
										<div class="text-center mt-3">
											<!-- <a href="index.html" class="btn btn-lg btn-primary">Sign in</a> -->
											<button type="submit" class="btn btn-lg" style="background-color:#eb5d1e; color:white">Send</button>
											<a href="index.php" class="btn btn-lg" style="background-color:white; border: 1px solid #eb5d1e; color:#eb5d1e; margin:10px;">Back</a>
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
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('header.php'); ?>
	<?php include('db_connection.php'); ?>
	
	<style>
	
	.error_msg {
		color: rgba(255,0,0,.80);
	}

	.error {
		box-shadow:0 0 0 .2rem rgba(255,0,0,.45);
	}

	</style>
</head>

<body>
	<div class="wrapper">

	<?php include('sidebar.php'); ?>

		<div class="main">
			
		<?php include('topbar.php'); ?>

			<main class="content">
				<div class="container-fluid p-0">

					<div class="row">
					<h1 class="h3 mb-3 col-10">Change Password</h1>
					</div>


<?php
//Set time zone
$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$cur_date = $createToday->format('Y-m-d');

?>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form name="password_form" method="post" action="change_sys_password_submit.php" onsubmit="return validateForm()" >
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
										<div class="row mb-3">
											<div class="col-lg-4 col-xs-4 mb-3">
												<label class="form-label">Current Password <span style="color:red">*</span></label>
												<input type="password" class="form-control" name="opass" id="opass" placeholder="Current Password" />
												<span class="error_msg" id="opass_error" ></span>
											</div>
											<div class="col-lg-4 col-xs-4 mb-3">
												<label class="form-label">New Password <span style="color:red">*</span></label>
												<input type="password" class="form-control" name="npass" id="npass" placeholder="New Password" />
												<span class="error_msg" id="npass_error" ></span>
											</div>
											<div class="col-lg-4 col-xs-4 mb-3">
												<label class="form-label">Confirm Password <span style="color:red">*</span></label>
												<input type="password" class="form-control" name="cpass" id="cpass" placeholder="Confirm Password" />
												<span class="error_msg" id="cpass_error" ></span>
											</div>
										</div>

										<div class="row mb-3">
											<div class="col-lg-6 mb-3">
												<div class="alert alert-primary alert-dismissible" role="alert" >
													<div class="alert-message">
														Please note that the password should contain :<br/>
														<ul>
															<li>atleast a lowercase letter</li>
															<li>atleast a uppercase letter</li>
															<li>atleast a numeric</li>
															<li>atleast a special character</li>
															<li>minimum 8 characters</li>
														</ul>
													</div>
												</div>
											</div>
										</div>


										<div class="row">
											<div class="col-lg-2 mb-3">
												<input type="submit" class="btn btn-success" name="submit" id="submit" value="Save" />
											</div>
										</div>

									</form>
								</div>

							</div>
						</div>
					</div>

				</div>
			</main>

			<?php include('footer.php'); ?>
		</div>
	</div>

	<script src="js/app.js"></script>

	<script>
		function validateForm() {
		  var prevent = '';
		  
		  let opass = document.forms["password_form"]["opass"].value;
		  if (opass == "") {
			document.getElementById("opass_error").innerHTML = "Current password must be filled";
			document.getElementById("opass").className  = "form-control error";
			prevent = 'yes';
		  } else {
			document.getElementById("opass_error").innerHTML = "";
			document.getElementById("opass").className  = "form-control";
		  }

		  let npass = document.forms["password_form"]["npass"].value;
		  var exp_pw1 = /^(?=.*[0-9])/;
		  var exp_pw2 = /^(?=.*[a-z])/;
		  var exp_pw3 = /^(?=.*[A-Z])/;
		  var exp_pw4 = /^(?=.*[!@#$%^&*()\-+.])/;
		  if (npass == "") {
			document.getElementById("npass_error").innerHTML = "New password must be filled";
			document.getElementById("npass").className  = "form-control error";
			prevent = 'yes';
		  } else if(npass.length < 8) {
			document.getElementById("npass_error").innerHTML = "Must contain atleast 8 characters";
			document.getElementById("npass").className  = "form-control error";	
			prevent = 'yes';
		  } else if (!exp_pw1.test(npass)) {
			document.getElementById("npass_error").innerHTML = "Must contain atleast one numeric";
			document.getElementById("npass").className  = "form-control error";
			prevent = 'yes';
		  } else if (!exp_pw2.test(npass)) {
			document.getElementById("npass_error").innerHTML = "Must contain lower case letter";
			document.getElementById("npass").className  = "form-control error";
			prevent = 'yes';
		  } else if (!exp_pw3.test(npass)) {
			document.getElementById("npass_error").innerHTML = "Must contain upper case letter";
			document.getElementById("npass").className  = "form-control error";
			prevent = 'yes';
		  } else if (!exp_pw4.test(npass)) {
			document.getElementById("npass_error").innerHTML = "Must contain special characters";
			document.getElementById("npass").className  = "form-control error";
			prevent = 'yes';
		  } else {
			document.getElementById("npass_error").innerHTML = "";
			document.getElementById("npass").className  = "form-control";
		  }

		  let cpass = document.forms["password_form"]["cpass"].value;
		  if (cpass == "") {
			document.getElementById("cpass_error").innerHTML = "Confirm password";
			document.getElementById("cpass").className  = "form-control error";
			prevent = 'yes';
		  } else if (cpass != npass) {
			document.getElementById("cpass_error").innerHTML = "Doesn't match with new password";
			document.getElementById("cpass").className  = "form-control error";
			prevent = 'yes';
		  } else {
			document.getElementById("cpass_error").innerHTML = "";
			document.getElementById("cpass").className  = "form-control";
		  }
  
		  if(prevent == 'yes'){
			  return false;
		  }
		}
  
	</script>
	
</body>

</html>
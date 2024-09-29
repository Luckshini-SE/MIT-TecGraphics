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
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h3>Sign up as member</h3>
							<!--
							<p class="lead">
								Start creating the best possible user experience for your customers.
							</p>
							-->
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
									<form name="customer_form" method="post" action="signup_submit.php" onsubmit="return validateForm()" >
										<div class="row mb-3">
											<?php
											if(isset($_SESSION['error']) && $_SESSION['error'] != ''){
												echo '<div class="alert alert-danger" role="alert"><div class="alert-message">'.$_SESSION['error'].'</div></div>';
												$_SESSION['error'] = '';
											}
											?>
										</div>
										<div class="row mb-3">
											<div class="col-3"><input type="radio" style="accent-color: #eb5d1e;" name="ctype" id="r1" value="ind" onchange="enable_div()" checked /> &nbsp; <label class="form-label">Individual</label></div>
											<div class="col-3"><input type="radio" style="accent-color: #eb5d1e;" name="ctype" id="r2" value="com" onchange="enable_div()" /> &nbsp; <label class="form-label">Company</label></div>
										</div>
										<div class="row mb-3">
											<div class="col-6">
												<label class="form-label">First Name<span id="fname_label" > *</span></label>
												<input class="form-control form-control-lg" type="text" name="fname" id="fname" placeholder="Enter your first name" />
												<span id="fname_error" ></span>
											</div>
											<div class="col-6">
												<label class="form-label">Last Name<span id="lname_label" > *</span></label>
												<input class="form-control form-control-lg" type="text" name="lname" id="lname" placeholder="Enter your last name" />
												<span id="lname_error" ></span>
											</div>
										</div>
										<div class="mb-3">
											<label class="form-label">Company<span id="comp_label" ></span></label>
											<input class="form-control form-control-lg" type="text" name="company" id="company" placeholder="Enter your company name" readonly />
											<span id="company_error" ></span>
											</div>
										<div class="mb-3">
											<label class="form-label">Telephone<span> *</span></label>
											<input class="form-control form-control-lg" type="text" name="telephone" id="telephone" placeholder="Enter your telephone number" />
											<span id="telephone_error" ></span>
											</div>
										<div class="mb-3">
											<label class="form-label">Email<span> *</span></label>
											<input class="form-control form-control-lg" type="email" name="email" id="email" placeholder="Enter your email" />
											<span id="email_error" ></span>
											</div>
										<div class="mb-3">
											<label class="form-label">Password<span> *</span></label>
											<input class="form-control form-control-lg" type="password" name="password" id="password" placeholder="Enter password" />
											<span id="password_error" ></span>
											</div>
										<div class="text-center mt-3">
											<input type="hidden" name="quot" id="quot" value="<?php echo $qid; ?>" />
											<!-- <a href="index.html" class="btn btn-lg btn-primary">Sign up</a> -->
											<button type="submit" class="btn btn-lg" style="background-color:#eb5d1e; color:white">Sign up</button>
											<a href="index.php" class="btn btn-lg" style="background-color:white; border: 1px solid #eb5d1e; color:#eb5d1e; margin:10px;">Back</a>
										</div>
										<div class="text-center mt-3">
											<?php if(isset($_GET['ref'])){ ?>
											<p>Already a member? <a href="signin.php?ref=<?php echo $qid; ?>" style="color:#eb5d1e">Click here</a> to sign in!</p>
											<?php } else { ?>
											<p>Already a member? <a href="signin.php" style="color:#eb5d1e">Click here</a> to sign in!</p>
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

	function enable_div(){
		if(document.querySelector("input[name=ctype]:checked").value == 'ind'){
			document.getElementById("fname").readOnly = false;
			document.getElementById("lname").readOnly = false;
			document.getElementById("company").readOnly = true;
			document.getElementById("fname_label").innerHTML = " *";
			document.getElementById("lname_label").innerHTML = " *";
			document.getElementById("comp_label").innerHTML = "";
		} else {
			document.getElementById("fname").readOnly = true;
			document.getElementById("lname").readOnly = true;
			document.getElementById("company").readOnly = false;
			document.getElementById("fname_label").innerHTML = "";
			document.getElementById("lname_label").innerHTML = "";
			document.getElementById("comp_label").innerHTML = " *";
		}
	}

	function validateForm() {
		
		if(document.querySelector("input[name=ctype]:checked").value == 'ind'){
		
		let fname = document.forms["customer_form"]["fname"].value;
		if (fname == "") {
			document.getElementById("fname_error").innerHTML = "Fill first name";
			return false;
		} else {
			document.getElementById("fname_error").innerHTML = "";
		}
		
		let lname = document.forms["customer_form"]["lname"].value;
		if (lname == "") {
			document.getElementById("lname_error").innerHTML = "Fill last name";
			return false;
		} else {
			document.getElementById("lname_error").innerHTML = "";
		}
		} else {

		let company = document.forms["customer_form"]["company"].value;
		if (company == "") {
			document.getElementById("company_error").innerHTML = "Fill company name";
			return false;
		} else {
			document.getElementById("company_error").innerHTML = "";
		}
		}

		let phone = document.forms["customer_form"]["telephone"].value;
		var regPhone=/^\d{10}$/;
		if (phone == "") {
			document.getElementById("telephone_error").innerHTML = "Fill telephone no.";
			return false;
		} else if (!regPhone.test(phone)) {
			document.getElementById("telephone_error").innerHTML = "Telephone must have 10 digits";
			return false;
		} else {
			document.getElementById("telephone_error").innerHTML = "";
		}

		let email = document.forms["customer_form"]["email"].value;
		var regEmail=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/g;
		if (email == "") {
			document.getElementById("email_error").innerHTML = "Fill email address";
			return false;
		} else if (!regEmail.test(email)) {
			document.getElementById("email_error").innerHTML = "Invalid email format";
			return false;
		} else {
			document.getElementById("email_error").innerHTML = "";
		}

		let password = document.forms["customer_form"]["password"].value;
		if (password == "") {
			document.getElementById("password_error").innerHTML = "Fill password";
			return false;
		} else {
			document.getElementById("password_error").innerHTML = "";
		}
	}

	</script>

</body>

</html>
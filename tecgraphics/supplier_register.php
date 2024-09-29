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

<?php
if(isset($_GET['id'])){
	$pid = $_GET['id'];

	$select_pro = mysqli_query($con, "SELECT * FROM supplier WHERE id = '$pid'");
	$result_pro = mysqli_fetch_array($select_pro);
		$sname = $result_pro['sname'];
		$contactp = $result_pro['contactp'];
		$contact = $result_pro['contact'];
		$address = $result_pro['address'];
		$email = $result_pro['email'];
} else {
	$pid = $sname = $contactp = $contact =  $address = $email = '';
}
?>

<body>
	<div class="wrapper">

	<?php include('sidebar.php'); ?>

		<div class="main">
			
		<?php include('topbar.php'); ?>

			<main class="content">
				<div class="container-fluid p-0">

					<div class="row">
					<h1 class="h3 mb-3 col-10">Register Supplier</h1>
					<div class="col-2" align="right"><a href="supplier_list.php"><button class="btn btn-warning">View List</button></a></div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form method="post" name="supp_form" action="supplier_register_submit.php" onsubmit="return validateForm()" >
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
										<div class="row form-group mb-3">
											<div class="col-4  mb-3">
												<label class="form-label">Supplier Name <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="sname" id="sname" placeholder="Supplier Name" value="<?php echo $sname; ?>" >
												<input type="hidden" name="cid" id="cid" value="<?php echo $pid; ?>" >
												<span class="error_msg" id="sname_error" ></span>
											</div>
											<div class="col-4  mb-3">
												<label class="form-label">Contact Person </label>
												<input type="text" class="form-control" name="contactp" id="contactp" placeholder="Contact Person" value="<?php echo $contactp; ?>" >
											</div>
											<div class="col-4  mb-3">
												<label class="form-label">Contact No. <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="contact" id="contact" placeholder="Contact No." value="<?php echo $contact; ?>" >
												<span class="error_msg" id="contact_error" ></span>
											</div>
										</div>

										<div class="row form-group mb-3">
											<div class="col-5 mb-3">
												<label class="form-label">Address <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="address" id="address" placeholder="Address" value="<?php echo $address; ?>" >
												<span class="error_msg" id="address_error" ></span>
											</div>
											<div class="col-4 mb-3">
												<label class="form-label">Email</label>
												<input type="text" class="form-control" name="semail" id="semail" placeholder="Email" value="<?php echo $email; ?>" >
												<span class="error_msg" id="semail_error" ></span>
											</div>
										</div>

										<div class="mb-3">
											<input type="submit" class="btn btn-success" name="submit" id="submit" value="Submit" >
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

  let sname = document.forms["supp_form"]["sname"].value;
  if (sname == "") {
	document.getElementById("sname_error").innerHTML = "Supplier name must be filled";
	document.getElementById("sname").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("sname_error").innerHTML = "";
	document.getElementById("sname").className  = "form-control";
  }
  
  let address = document.forms["supp_form"]["address"].value;
  if (address == "") {
	document.getElementById("address_error").innerHTML = "Address must be filled";
	document.getElementById("address").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("address_error").innerHTML = "";
	document.getElementById("address").className  = "form-control";
  }
  
  let contact = document.forms["supp_form"]["contact"].value;
  var regPhone=/^\d{10}$/;
  if (contact == "") {
	document.getElementById("contact_error").innerHTML = "Contact no. must be filled";
	document.getElementById("contact").className  = "form-control error";
	prevent = 'yes';
  } else if (!regPhone.test(contact)) {
    document.getElementById("contact_error").innerHTML = "Contact no. must have 10 digits";
	document.getElementById("contact").className  = "form-control error";
	prevent = 'yes';
  }else {
	document.getElementById("contact_error").innerHTML = "";
	document.getElementById("contact").className  = "form-control";
  }
  
  let semail = document.forms["supp_form"]["semail"].value;
  var regEmail=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/g;
  if ((semail != "") && (!regEmail.test(semail))) {
    document.getElementById("semail_error").innerHTML = "Invalid email format";
	document.getElementById("semail").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("semail_error").innerHTML = "";
	document.getElementById("semail").className  = "form-control";
  }
  
  if(prevent == 'yes'){
	  return false;
  }
}

	</script>

</body>

</html>
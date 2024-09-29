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

	.title {
		font-size:12px; 
		color:red;
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
					<h1 class="h3 mb-3 col-10">Price Management</h1>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form method="post" name="supp_form" action="price_management_submit.php" onsubmit="return validateForm()" >
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
											
											<table class="table-bordered" cellpadding="7px" >
												<thead>
												<tr>
													<th>Product</th>
													<th>Unit Price</th>
													<th>Finishing</th>
													<th>Spec 1</th>
													<th>Spec 2</th>
												</tr>
												</thead>
												<tbody>
												<?php
												$i=1;
												$select_pro = mysqli_query($con, "SELECT * FROM products");
												while($result_pro = mysqli_fetch_array($select_pro)){
														$select_unit = mysqli_query($con, "SELECT name FROM pricing WHERE id = '{$result_pro['pricing']}'");
														$result_unit = mysqli_fetch_array($select_unit);
												?>
												<tr valign="top">
													<td><?php echo $result_pro['name']; ?><input type="hidden" name="proid_<?php echo $i; ?>" id="proid_<?php echo $i; ?>" value="<?php echo $result_pro['id']; ?>" /></td>
													<td>
														<span class="title"><?php echo $result_unit['name']; ?></span>
														<input type="text" class="form-control mb-3" style="text-align:right;" name="uprice_<?php echo $i; ?>" id="uprice_<?php echo $i; ?>" value="<?php echo number_format($result_pro['uprice'],2,'.',''); ?>" onkeypress="return isNumberKeyn(event);" />
													</td>
													<td>
														<?php
														$j=1;
														$select_fin = mysqli_query($con, "SELECT * FROM pro_finishing WHERE prod_id = '{$result_pro['id']}'");
														while($result_fin = mysqli_fetch_array($select_fin)){
														?>
														<span class="title"><?php echo $result_fin['name']; ?></span>
														<input type="text" class="form-control mb-3" style="text-align:right;" name="finish_<?php echo $i; ?>_<?php echo $j; ?>" id="finish_<?php echo $i; ?>_<?php echo $j; ?>" value="<?php echo number_format($result_fin['uprice'],2,'.',''); ?>" onkeypress="return isNumberKeyn(event);" />
														<input type="hidden" name="finishid_<?php echo $i; ?>_<?php echo $j; ?>" id="finishid_<?php echo $i; ?>_<?php echo $j; ?>" value="<?php echo $result_fin['id']; ?>" />
														<?php $j++;	} ?>
														<input type="hidden" name="num_finish_<?php echo $i; ?>" id="num_finish_<?php echo $i; ?>" value="<?php echo $j-1; ?>" />
													</td>
													<td>
														<?php
														$k=1;
														$select_spo = mysqli_query($con, "SELECT * FROM pro_spec1 WHERE prod_id = '{$result_pro['id']}'");
														while($result_spo = mysqli_fetch_array($select_spo)){
														?>
														<span class="title"><?php echo $result_spo['name']; ?></span>
														<input type="text" class="form-control mb-3" style="text-align:right;" name="speco_<?php echo $i; ?>_<?php echo $k; ?>" id="speco_<?php echo $i; ?>_<?php echo $k; ?>" value="<?php echo number_format($result_spo['uprice'],2,'.',''); ?>" onkeypress="return isNumberKeyn(event);" />
														<input type="hidden" name="specoid_<?php echo $i; ?>_<?php echo $k; ?>" id="specoid_<?php echo $i; ?>_<?php echo $k; ?>" value="<?php echo $result_spo['id']; ?>" />
														<?php $k++;	} ?>
														<input type="hidden" name="num_speco_<?php echo $i; ?>" id="num_speco_<?php echo $i; ?>" value="<?php echo $k-1; ?>" />
													</td>
													<td>
														<?php
														$m=1;
														$select_spt = mysqli_query($con, "SELECT * FROM pro_spec2 WHERE prod_id = '{$result_pro['id']}'");
														while($result_spt = mysqli_fetch_array($select_spt)){
														?>
														<span class="title"><?php echo $result_spt['name']; ?></span>
														<input type="text" class="form-control mb-3" style="text-align:right;" name="spect_<?php echo $i; ?>_<?php echo $m; ?>" id="spect_<?php echo $i; ?>_<?php echo $m; ?>" value="<?php echo number_format($result_spt['uprice'],2,'.',''); ?>" onkeypress="return isNumberKeyn(event);" />
														<input type="hidden" name="spectid_<?php echo $i; ?>_<?php echo $m; ?>" id="spectid_<?php echo $i; ?>_<?php echo $m; ?>" value="<?php echo $result_spt['id']; ?>" />
														<?php $m++;	} ?>
														<input type="hidden" name="num_spect_<?php echo $i; ?>" id="num_spect_<?php echo $i; ?>" value="<?php echo $m-1; ?>" />
													</td>
												</tr>
												<?php $i++;	} ?>
												<input type="hidden" name="num_pro" id="num_pro" value="<?php echo $i-1; ?>" />
												</tbody>
											</table>
											
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

function isNumberKeyn(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if ((charCode > 47 && charCode < 58) || charCode == 46) {	// Allow Numbers, Full Stop, Delete & Back Space
		return true;
	} else {
		return false;
	}
}

function validateForm() {
  /*var prevent = '';

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
  */
}

	</script>

</body>

</html>
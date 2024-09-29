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
$iid = $_GET['iid'];
$select_inv = mysqli_query($con, "SELECT * FROM invoice WHERE inv_type = 'direct' AND id = '$iid'");
$result_inv = mysqli_fetch_array($select_inv);
?>

<body>
	<div class="wrapper">

	<?php include('sidebar.php'); ?>

		<div class="main">
			
		<?php include('topbar.php'); ?>

			<main class="content">
				<div class="container-fluid p-0">

					<div class="row">
					<h1 class="h3 mb-3 col-10">Cancel Direct Invoice</h1>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form method="post" name="invoice_form" action="cancel_direct_invoice_submit.php" onsubmit="return validateForm()" >
										<div class="row">
											<div class="col-lg-2 col-xs-6 mb-3">
												<label class="form-label">Invoice Date</label>
												<input type="text" class="form-control" name="inv_date" id="inv_date" value="<?php echo $result_inv['invoice_date']; ?>" readonly />
											</div>
											<div class="col-lg-3 col-sm-12 mb-5">
												<label class="form-label">Invoice No.</label>
												<input type="text" class="form-control" name="inv_no" id="inv_no" value="<?php echo $result_inv['invoice_no']; ?>" readonly />
												<input type="hidden" name="inv_id" id="inv_id" value="<?php echo $result_inv['id']; ?>" />
												<span class="error_msg" id="inv_error" ></span>
											</div>
											<div class="col-lg-4 col-sm-12 mb-3">
												<label class="form-label">Customer</label>
													<?php
													$select_cus = mysqli_query($con, "SELECT name, last_name FROM customer WHERE id = '{$result_inv['cus_id']}'");
													$result_cus = mysqli_fetch_array($select_cus);
													?>
												<input type="text" class="form-control" name="customer" id="customer" value="<?php echo $result_cus['name'].' '.$result_cus['last_name']; ?>" readonly />
											</div>
										</div>
										
										<div class="row" style="border-bottom: 1px solid #939ba2;">
											<div class="col-lg-5">
												<label class="form-label">Product</label>
											</div>
											<div class="col-lg-2">
												<label class="form-label">Unit Price (Rs.)</label>
											</div>
											<div class="col-lg-2">
												<label class="form-label">Quantity</label>
											</div>
											<div class="col-lg-2">
												<label class="form-label">Amount (Rs.)</label>
											</div>
											<div class="col-lg-1">
												<label class="form-label">&nbsp;</label>
											</div>
										</div>

										<?php
										$select_details = mysqli_query($con, "SELECT * FROM invoice_details WHERE invoice_id = '{$result_inv['id']}'");
										while($result_details = mysqli_fetch_array($select_details)){
										?>
										<div class="row" style="margin-top: 10px;">
												<div class="col-lg-5 mb-3">
												<input type="text" class="form-control" name="product1" id="product1" value="<?php echo $result_details['description'] ?>" readonly />
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="uprice1" id="uprice1" style="text-align:right" value="<?php echo $result_details['uprice'] ?>" readonly />
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="qty1" id="qty1" value="<?php echo $result_details['qty'] ?>" readonly />
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="amount1" id="amount1" style="text-align:right" value="<?php echo $result_details['amount'] ?>" readonly />
											</div>
											<div class="col-lg-1 mb-3">
												&nbsp;
											</div>
										</div>
										<?php } ?>

										<div class="row" style="margin-top: 10px;">
											<div class="col-7 mb-3">
												&nbsp;
											</div>
											<div class="col-lg-2 mb-3">
												<label class="form-label">Subtotal (Rs.)</label>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="subtotal" id="subtotal" style="text-align: right;" value="<?php echo $result_inv['subtotal'] ?>" readonly />
											</div>
											<div class="col-1 mb-3">
												&nbsp;
											</div>
										</div>
										
										<div class="row">
											<div class="col-7 mb-3">
												&nbsp;
											</div>
											<div class="col-lg-2 mb-3">
												<label class="form-label">Discount (Rs.)</label>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="discount" id="discount" style="text-align: right;" value="<?php echo $result_inv['discount'] ?>" readonly />
											</div>
											<div class="col-1 mb-3">
												&nbsp;
											</div>
										</div>

										<div class="row">
											<div class="col-7 mb-3">
												&nbsp;
											</div>
											<div class="col-lg-2 mb-3">
												<label class="form-label">Total (Rs.)</label>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="total" id="total" style="text-align: right;" value="<?php echo $result_inv['total'] ?>" readonly />
											</div>
											<div class="col-1 mb-3">
												&nbsp;
											</div>
										</div>
										
										<div class="row">
											<div class="col-lg-9 mb-3">
												<label class="form-label">Reason for cancellation</label>
												<textarea class="form-control" name="reason" id="reason" ></textarea>
												<span class="error_msg" id="reason_error" ></span>
											</div>
											<div class="col-3 mb-3">
												&nbsp;
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
		  
		  let inv_no = document.forms["invoice_form"]["inv_no"].value;
		  if (inv_no == "") {
			document.getElementById("inv_error").innerHTML = "Invoice number cannot be empty";
			document.getElementById("inv_no").className  = "form-control error";
			prevent = 'yes';
		  } else {
			document.getElementById("inv_error").innerHTML = "";
			document.getElementById("inv_no").className  = "form-control";
		  }

		  let reason = document.forms["invoice_form"]["reason"].value;
		  if (reason == "") {
			document.getElementById("reason_error").innerHTML = "Reason must be filled";
			document.getElementById("reason").className  = "form-control error";
			prevent = 'yes';
		  } else {
			document.getElementById("reason_error").innerHTML = "";
			document.getElementById("reason").className  = "form-control";
		  }
  
		  if(prevent == 'yes'){
			  return false;
		  }
		}
	</script>

</body>

</html>
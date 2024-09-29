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
					<h1 class="h3 mb-3 col-10">Advance Payment</h1>
					<div class="col-2" align="right"><a href="advance_pay_list.php"><button class="btn btn-warning">View List</button></a></div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form method="post" name="receipt_form" action="advance_pay_submit.php" onsubmit="return validateForm()" >
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
											<?php
											//Set time zone
											$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
											$cur_date = $createToday->format('Y-m-d');

											$select_max = mysqli_query($con, "SELECT rec_no FROM `advance_payment` ORDER BY id DESC");
											if(mysqli_num_rows($select_max) > 0){
												$result_max = mysqli_fetch_array($select_max);
													$temp = substr($result_max['rec_no'], 2);
													$max = $temp+1;
													$receipt_no = 'AD'.$max;
											} else {
												$receipt_no = 'AD10001';
											}
											?>
											<div class="col-2 mb-3">
												<label class="form-label">Receipt No. </label>
												<input type="text" class="form-control" name="receipt_no" id="receipt_no" value="<?php echo $receipt_no; ?>" readonly >
											</div>
											<div class="col-3 mb-3">
												<label class="form-label">Receipt Date <span style="color:red">*</span></label>
												<input type="text" class="form-control flatpickr-minimum flatpickr-input" name="receipt_date" id="receipt_date" value="<?php echo $cur_date; ?>" readonly >
											</div>
											<div class="col-4 mb-3">
												<label class="form-label">Customer <span style="color:red">*</span></label>
												<select class="form-select" name="customer" id="customer" >
													<option value="">-Please Select-</option>
													<?php
													$select_cus = mysqli_query($con, "SELECT id, name, last_name FROM customer WHERE name != ''");
													while($result_cus = mysqli_fetch_array($select_cus)){
													?>
													<option value="<?php echo $result_cus['id']; ?>"><?php echo $result_cus['name'].' '.$result_cus['last_name']; ?></option>
													<?php } ?>
												</select>
												<span class="error_msg" id="cus_error" ></span>
											</div>
											<div class="col-3 mb-3">
												&nbsp;
											</div>
										</div>

										<div class="row form-group mb-3">
											<div class="col-9 mb-3">
												<label class="form-label">Description <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="description" id="description" />
												<span class="error_msg" id="des_error" ></span>
											</div>
											<div class="col-3 mb-3">
												<label class="form-label">Amount (Rs.) <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="amount" id="amount" onkeypress="return isNumberKeyn(event);" />
												<span class="error_msg" id="amt_error" ></span>
											</div>
										</div>
										
										<div class="row form-group mb-3">
											<div class="col-3 mb-3">
												<label class="form-label">Payment Type <span style="color:red">*</span></label>
												<select class="form-select" name="paytype" id="paytype" onchange="enablediv()" >
													<option value="">-Please Select-</option>
													<option value="Cash">Cash</option>
													<option value="Cheque">Cheque</option>
													<option value="Card">Card</option>
													<option value="Bank Deposit">Bank Deposit</option>
												</select>
												<span class="error_msg" id="pty_error" ></span>
											</div>

											<div class="col-3 mb-3" id="cheq_div1" style="display:none">
												<label class="form-label">Cheque No.</label>
												<input type="text" class="form-control" name="cheqno" id="cheqno" />
												<span class="error_msg" id="cno_error" ></span>
											</div>
											<div class="col-3 mb-3" id="cheq_div2" style="display:none">
												<label class="form-label">Cheque Date</label>
												<input type="text" class="form-control flatpickr-minimum flatpickr-input" name="cheqdate" id="cheqdate" />
												<span class="error_msg" id="cda_error" ></span>
											</div>

											<div class="col-3 mb-3" id="depo_div" style="display:none">
												<label class="form-label">Reference</label>
												<input type="text" class="form-control" name="depref" id="depref" />
												<span class="error_msg" id="ref_error" ></span>
											</div>
										</div>

										<div class="row form-group mb-3">
											<div class="col-9 mb-3">
												<input type="submit" class="btn btn-success" name="submit" id="submit" value="Submit" >
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
		document.addEventListener("DOMContentLoaded", function() {
			// Flatpickr
			flatpickr(".flatpickr-minimum", {
				maxDate: "today"
			});
		});
	</script>

	<script>

	function enablediv(){
		var paytype = document.getElementById('paytype').value;
		
		if(paytype == 'Cheque'){
			document.getElementById('cheq_div1').style.display = 'block';
			document.getElementById('cheq_div2').style.display = 'block';
			document.getElementById('depo_div').style.display = 'none';
		} else if(paytype == 'Bank Deposit'){
			document.getElementById('cheq_div1').style.display = 'none';
			document.getElementById('cheq_div2').style.display = 'none';
			document.getElementById('depo_div').style.display = 'block';
		} else {
			document.getElementById('cheq_div1').style.display = 'none';
			document.getElementById('cheq_div2').style.display = 'none';
			document.getElementById('depo_div').style.display = 'none';
		}
	}

	function isNumberKey(evt){

		var charCode = (evt.which) ? evt.which : event.keyCode;
		if (charCode == 8 || (charCode > 47 && charCode < 58)) { // Allow Numbers, Delete & Back Space
			return true;
		} else {
			return false;
		}
	}

	function isNumberKeyn(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode;
		if ((charCode > 47 && charCode < 58) || charCode == 46) {	// Allow Numbers, Full Stop, Delete & Back Space
			return true;
		} else {
			return false;
		}
	}

	function format_number(pnumber, decimals) {
		if (isNaN(pnumber)) {
			return 0
		};
		if (pnumber == '') {
			return 0
		};

		var snum = new String(pnumber);
		var sec = snum.split('.');
		var whole = parseFloat(sec[0]);
		var result = '';

		if (sec.length > 1) {
			var dec = new String(sec[1]);
			dec = String(parseFloat(sec[1]) / Math.pow(10, (dec.length - decimals)));
			dec = String(whole + Math.round(parseFloat(dec)) / Math.pow(10, decimals));
			var dot = dec.indexOf('.');
			if (dot == -1) {
				dec += '.';
				dot = dec.indexOf('.');
			}
			while (dec.length <= dot + decimals) {
				dec += '0';
			}
			result = dec;
		} else {
			var dot;
			var dec = new String(whole);
			dec += '.';
			dot = dec.indexOf('.');
			while (dec.length <= dot + decimals) {
				dec += '0';
			}
			result = dec;
		}
		return result;
	}

function validateForm() {
  var prevent = '';

  let customer = document.forms["receipt_form"]["customer"].value;
  if (customer == "") {
	document.getElementById("cus_error").innerHTML = "Customer must be selected";
	document.getElementById("customer").className  = "form-select error";
	prevent = 'yes';
  } else {
	document.getElementById("cus_error").innerHTML = "";
	document.getElementById("customer").className  = "form-select";
  }
  
  let description = document.forms["receipt_form"]["description"].value;
  if (description == "") {
	document.getElementById("des_error").innerHTML = "Description must be filled";
	document.getElementById("description").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("des_error").innerHTML = "";
	document.getElementById("description").className  = "form-control";
  }
  
  let amount = document.forms["receipt_form"]["amount"].value;
  if (amount == "") {
	document.getElementById("amt_error").innerHTML = "Amount must be filled";
	document.getElementById("amount").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("amt_error").innerHTML = "";
	document.getElementById("amount").className  = "form-control";
  }
  
  let paytype = document.forms["receipt_form"]["paytype"].value;
  if (paytype == "") {
	document.getElementById("pty_error").innerHTML = "Payment type must be selected";
	document.getElementById("paytype").className  = "form-select error";
	prevent = 'yes';
  } else {
	document.getElementById("pty_error").innerHTML = "";
	document.getElementById("paytype").className  = "form-select";
  }

  if(paytype == 'Cheque'){

  let cheqno = document.forms["receipt_form"]["cheqno"].value;
  if (cheqno == "") {
	document.getElementById("cno_error").innerHTML = "Cheque no. must be filled";
	document.getElementById("cheqno").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("cno_error").innerHTML = "";
	document.getElementById("cheqno").className  = "form-control";
  }

  let cheqdate = document.forms["receipt_form"]["cheqdate"].value;
  if (cheqdate == "") {
	document.getElementById("cda_error").innerHTML = "Cheque date must be filled";
	document.getElementById("cheqdate").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("cda_error").innerHTML = "";
	document.getElementById("cheqdate").className  = "form-control";
  }

  } else if(paytype == 'Bank Deposit'){

  let depref = document.forms["receipt_form"]["depref"].value;
  if (depref == "") {
	document.getElementById("ref_error").innerHTML = "Reference must be filled";
	document.getElementById("depref").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("ref_error").innerHTML = "";
	document.getElementById("depref").className  = "form-control";
  }

  }
  
  
  
  if(prevent == 'yes'){
	  return false;
  }
}

	</script>

</body>

</html>
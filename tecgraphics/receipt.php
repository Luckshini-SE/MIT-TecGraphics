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
					<h1 class="h3 mb-3 col-10">Receipt</h1>
					<div class="col-2" align="right"><a href="receipt_list.php"><button class="btn btn-warning">View List</button></a></div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form method="post" name="receipt_form" action="receipt_submit.php" onsubmit="return validateForm()" >
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

											$select_max = mysqli_query($con, "SELECT rec_no FROM `receipt` ORDER BY id DESC");
											if(mysqli_num_rows($select_max) > 0){
												$result_max = mysqli_fetch_array($select_max);
													$temp = substr($result_max['rec_no'], 2);
													$max = $temp+1;
													$receipt_no = 'RN'.$max;
											} else {
												$receipt_no = 'RN10001';
											}
											?>
											<div class="col-2 mb-3">
												<label class="form-label">Receipt No. </label>
												<input type="text" class="form-control" name="receipt_num" id="receipt_num" value="<?php echo $receipt_no; ?>" readonly >
											</div>
											<div class="col-3 mb-3">
												<label class="form-label">Receipt Date <span style="color:red">*</span></label>
												<input type="text" class="form-control flatpickr-minimum flatpickr-input" name="receipt_date" id="receipt_date" value="<?php echo $cur_date; ?>" readonly >
											</div>
											<div class="col-3 mb-3">
												<label class="form-label">Customer <span style="color:red">*</span></label>
												<select class="form-select" name="customer" id="customer" onchange="get_details()" >
													<option value="">-Please Select-</option>
													<?php
													$select_cus = mysqli_query($con, "SELECT c.id, c.name, c.last_name FROM customer c, invoice i WHERE i.cus_id = c.id AND i.pay_balance > 0 AND c.name != '' GROUP BY i.cus_id ORDER BY c.name");
													while($result_cus = mysqli_fetch_array($select_cus)){
													?>
													<option value="<?php echo $result_cus['id']; ?>"><?php echo $result_cus['name'].' '.$result_cus['last_name']; ?></option>
													<?php } ?>
												</select>
												<span class="error_msg" id="cust_error" ></span>
											</div>
											<div class="col-4 mb-3">
												&nbsp;
											</div>
										</div>

										<div id="invoice_div"></div>

										
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

	function get_details(){
		var customer = document.getElementById('customer').value;
		
		const xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("invoice_div").innerHTML = this.responseText;
				flatpickr(".flatpickr-minimum");
			}
		};
		xhttp.open("GET", "get_invoice_details.php?cust="+customer);
		xhttp.send();
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

function chkamt(i){
	var inv_amt = parseFloat(document.getElementById("inv_amt"+i).value);
	var pay_amt = parseFloat(document.getElementById("pay_amt"+i).value);

	if(inv_amt < pay_amt){
		alert('Paid amount cannot be more than outstanding!');
		document.getElementById("pay_amt"+i).value = inv_amt;
	}
	calculateTotal();
}

function chk_advamt(i){
	var adv_amt = parseFloat(document.getElementById("adv_amt"+i).value);
	var adv_pay = parseFloat(document.getElementById("adv_pay"+i).value);

	if(adv_amt < adv_pay){
		alert('Settled amount cannot be more than balance!');
		document.getElementById("adv_pay"+i).value = adv_amt;
	}
	calculateAdvTotal();
}

function enable_amt(i){
	if(document.getElementById("select"+i).checked == true){
		document.getElementById("pay_amt"+i).readOnly = false;
	} else {
		document.getElementById("pay_amt"+i).readOnly = true;
	}
	calculateTotal();
}

function enable_adv_amt(i){
	if(document.getElementById("select_adv"+i).checked == true){
		document.getElementById("adv_pay"+i).readOnly = false;
	} else {
		document.getElementById("adv_pay"+i).readOnly = true;
	}
	calculateAdvTotal();
}

	function calculateTotal(){

		var num_rows = document.getElementById("num_rows").value;

		var subtotal = 0;
		for(i=1; i<=num_rows; i++){
			if(document.getElementById("select"+i).checked == true){
				var amount = parseFloat(document.getElementById("pay_amt"+i).value);

				subtotal += amount;
			}
		}

		document.getElementById("total_pay").value = format_number(subtotal, 2);
		chkEqual();
	}

	function calculateAdvTotal(){

		var num_adv_rows = document.getElementById("num_adv_rows").value;

		var subtotal = 0;
		for(i=1; i<=num_adv_rows; i++){
			if(document.getElementById("select_adv"+i).checked == true){
				var amount = parseFloat(document.getElementById("adv_pay"+i).value);

				subtotal += amount;
			}
		}

		document.getElementById("total_adv_pay").value = format_number(subtotal, 2);
		chkEqual();
	}

	function chkEqual(){
		var paytype = document.getElementById('paytype').value;
		
		if(paytype == 'Settlement'){
			var total_pay = document.getElementById('total_pay').value;
			var total_adv_pay = document.getElementById('total_adv_pay').value;

			if(total_pay == total_adv_pay){
				document.getElementById("submit").disabled = false;
			} else {
				document.getElementById("submit").disabled = true;
			}
		}
	}

	function enablediv(){
		var paytype = document.getElementById('paytype').value;
		
		if(paytype == 'Cheque'){
			document.getElementById('cheq_div1').style.display = 'block';
			document.getElementById('cheq_div2').style.display = 'block';
			document.getElementById('depo_div').style.display = 'none';
			document.getElementById('adv_div').style.display = 'none';
		} else if(paytype == 'Bank Deposit'){
			document.getElementById('cheq_div1').style.display = 'none';
			document.getElementById('cheq_div2').style.display = 'none';
			document.getElementById('depo_div').style.display = 'block';
			document.getElementById('adv_div').style.display = 'none';
		} else if(paytype == 'Settlement'){
			document.getElementById('cheq_div1').style.display = 'none';
			document.getElementById('cheq_div2').style.display = 'none';
			document.getElementById('depo_div').style.display = 'none';
			document.getElementById('adv_div').style.display = 'block';
		} else {
			document.getElementById('cheq_div1').style.display = 'none';
			document.getElementById('cheq_div2').style.display = 'none';
			document.getElementById('depo_div').style.display = 'none';
			document.getElementById('adv_div').style.display = 'none';
		}
	}

function validateForm() {	
  var prevent = '';

  let customer = document.forms["receipt_form"]["customer"].value;
  if (customer == "") {
	document.getElementById("cust_error").innerHTML = "Customer must be selected";
	document.getElementById("customer").className  = "form-select error";
	prevent = 'yes';
  } else {
	document.getElementById("cust_error").innerHTML = "";
	document.getElementById("customer").className  = "form-select";
  }
  
  var num_rows = document.getElementById("num_rows").value;

  for(i=1; i<=num_rows; i++){
	if(document.getElementById("select"+i).checked == true){
	  let pay_amt = document.forms["receipt_form"]["pay_amt"+i].value;
	  if (pay_amt == "") {
		document.getElementById("pay_amt"+i).className  = "form-control error";
		prevent = 'yes';
	  } else if (pay_amt <= 0) {
		document.getElementById("pay_amt"+i).className  = "form-control error";
		prevent = 'yes';
	  } else {
		document.getElementById("pay_amt"+i).className  = "form-control";
	  }
	}
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

  } else if(paytype == 'Settlement'){

  let totpay = document.forms["receipt_form"]["total_adv_pay"].value;
  if (totpay == "") {
	document.getElementById("adv_error").innerHTML = "Amount must be filled";
	document.getElementById("total_adv_pay").className  = "form-control error";
	prevent = 'yes';
  } else if (totpay <= 0) {
	document.getElementById("adv_error").innerHTML = "Amount must be filled";
	document.getElementById("total_adv_pay").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("adv_error").innerHTML = "";
	document.getElementById("total_adv_pay").className  = "form-control";
  }

  }
  
  if(prevent == 'yes'){
	  return false;
  }
}

	</script>

</body>

</html>
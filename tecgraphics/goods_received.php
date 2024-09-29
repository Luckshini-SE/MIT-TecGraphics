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
					<h1 class="h3 mb-3 col-10">Goods Received Note</h1>
					<div class="col-2" align="right"><a href="goods_received_list.php"><button class="btn btn-warning">View List</button></a></div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form method="post" name="grn_form" action="goods_received_submit.php" onsubmit="return validateForm()" >
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

											$select_max = mysqli_query($con, "SELECT grn_no FROM `grn_summary` ORDER BY id DESC");
											if(mysqli_num_rows($select_max) > 0){
												$result_max = mysqli_fetch_array($select_max);
													$temp = substr($result_max['grn_no'], 3);
													$max = $temp+1;
													$grn_no = 'GRN'.$max;
											} else {
												$grn_no = 'GRN10001';
											}
											?>
											<div class="col-2  mb-3">
												<label class="form-label">GRN No. </label>
												<input type="text" class="form-control" name="grn_num" id="grn_num" value="<?php echo $grn_no; ?>" readonly >
											</div>
											<div class="col-3  mb-3">
												<label class="form-label">GRN Date <span style="color:red">*</span></label>
												<input type="text" class="form-control flatpickr-minimum flatpickr-input" name="grn_date" id="grn_date" value="<?php echo $cur_date; ?>" readonly >
											</div>
											<div class="col-4  mb-3">
												<label class="form-label">PO No. <span style="color:red">*</span></label>
												<select class="form-select" name="po_no" id="po_no" onchange="get_details()" >
													<option value="">-Please Select-</option>
													<?php
													$select_po = mysqli_query($con, "SELECT id, po_no, supplier FROM purchase_order_summary WHERE approval = 'yes' AND grn = 'no'");
													while($result_po = mysqli_fetch_array($select_po)){

														$select_supp = mysqli_query($con, "SELECT sname FROM supplier WHERE id = '{$result_po['supplier']}'");
														$result_supp = mysqli_fetch_array($select_supp);
													?>
													<option value="<?php echo $result_po['id']; ?>"><?php echo $result_po['po_no'].' - '.$result_supp['sname']; ?></option>
													<?php } ?>
												</select>
												<span class="error_msg" id="pono_error" ></span>
											</div>
										</div>

										<div id="item_div"></div>

										
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
		var po_no = document.getElementById('po_no').value;
		
		const xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("item_div").innerHTML = this.responseText;
			}
		};
		xhttp.open("GET", "get_po_details.php?pono="+po_no);
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

	function calculateAmount(i){
		var uprice = parseFloat(document.getElementById("rate"+i).value);
		var qty = parseFloat(document.getElementById("qty"+i).value);

		var amount = uprice*qty;

		document.getElementById("amount"+i).value = format_number(amount, 2);
		calculateTotal();
	}

	function calculateTotal(){
		var numrow = parseInt(document.getElementById("num_rows").value);
		var total = 0;
		for(var i=1; i <= numrow; i++){
			if(document.getElementById("select"+i).checked == true){
				var amount = parseFloat(document.getElementById("amount"+i).value);

				total += amount;
			}
		}
		
		document.getElementById("total").value = format_number(total, 2);
	}

	function enablerow(a){
		if(document.getElementById("select"+a).checked == true){ 
			document.getElementById("rate"+a).removeAttribute('readonly');
			document.getElementById("qty"+a).removeAttribute('readonly');
			calculateTotal();
		} else { 
			document.getElementById("rate"+a).setAttribute('readonly', true);
			document.getElementById("qty"+a).setAttribute('readonly', true);
			calculateTotal();
		}
	}

function validateForm() {
  var prevent = '';

  let po_no = document.forms["grn_form"]["po_no"].value;
  if (po_no == "") {
	document.getElementById("pono_error").innerHTML = "PO no. must be selected";
	document.getElementById("po_no").className  = "form-select error";
	prevent = 'yes';
  } else {
	document.getElementById("pono_error").innerHTML = "";
	document.getElementById("po_no").className  = "form-select";
  }

  var num_rows = document.getElementById("num_rows").value;

  for(i=1; i<=num_rows; i++){

  let item = document.forms["grn_form"]["item"+i].value;
  if (item == "") {
	document.getElementById("item"+i).className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("item"+i).className  = "form-control";
  }
  
  let rate = document.forms["grn_form"]["rate"+i].value;
  if (rate == "") {
	document.getElementById("rate"+i).className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("rate"+i).className  = "form-control";
  }

  let qty = document.forms["grn_form"]["qty"+i].value;
  if (qty == "") {
	document.getElementById("qty"+i).className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("qty"+i).className  = "form-control";
  }

  }

  let total = document.forms["grn_form"]["total"].value;
  if (total == "" || total == 0) {
	document.getElementById("total").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("total").className  = "form-control";
  }
  
  if(prevent == 'yes'){
	  return false;
  }
}

	</script>

</body>

</html>
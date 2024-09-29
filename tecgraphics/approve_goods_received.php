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
					<h1 class="h3 mb-3 col-10">Goods Received Note Approval</h1>
					<!--<div class="col-2" align="right"><a href="goods_received_list.php"><button class="btn btn-warning">View List</button></a></div>-->
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form method="post" name="grn_form" action="approve_goods_received_submit.php" >
										<div class="row form-group mb-3">
											<?php
											$pid = $_GET['qid'];
											//Set time zone
											$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
											$cur_date = $createToday->format('Y-m-d');

											$select_grn = mysqli_query($con, "SELECT * FROM grn_summary WHERE id = '$pid'");
										    $result_grn = mysqli_fetch_array($select_grn);

											?>
											<div class="col-2  mb-3">
												<label class="form-label">GRN No. </label>
												<input type="text" class="form-control" name="grn_num" id="grn_num" value="<?php echo $result_grn['grn_no']; ?>" readonly >
											</div>
											<div class="col-3  mb-3">
												<label class="form-label">GRN Date <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="grn_date" id="grn_date" value="<?php echo $result_grn['grn_date']; ?>" readonly >
											</div>
											
										</div>
											<?php
												$select_po = mysqli_query($con, "SELECT id, po_no, supplier, po_date FROM purchase_order_summary WHERE po_no = '{$result_grn['po_no']}'");
												$result_po = mysqli_fetch_array($select_po);

												$select_supp  = mysqli_query($con, "SELECT id, sname FROM supplier WHERE id = '{$result_po['supplier']}'");
												$result_supp = mysqli_fetch_array($select_supp);
											?>										
										<div class="row form-group mb-3">
											<div class="col-2 ">
												<label class="form-label">PO No.</label>
												<input type="text" class="form-control" name="pono" id="pono" value="<?php echo $result_po['po_no']; ?>" readonly >
											</div>
											<div class="col-3  mb-3">
												<label class="form-label">PO Date</label>
												<input type="text" class="form-control" name="podate" id="podate" value="<?php echo $result_po['po_date']; ?>" readonly >
											</div>
											<div class="col-4  mb-3">
												<label class="form-label">Supplier</label>
												<input type="text" class="form-control" name="suppname" id="suppname" value="<?php echo $result_supp['sname']; ?>" readonly >
												<input type="hidden" class="form-control" name="supplier" id="supplier" value="<?php echo $result_po['supplier']; ?>" >
											</div>
											<div class="col-3  mb-3">
												<label class="form-label">Invoice No.</label>
												<input type="text" class="form-control" name="invno" id="invno" value="<?php echo $result_grn['invoice_no']; ?>" readonly >
											</div>
										</div>

										<div class="row form-group mb-3">
											<div class="col-5">
												<label class="form-label">Raw Material</label>
											</div>
											<div class="col-2">
												<label class="form-label">Rate (Rs.)</label>
											</div>
											<div class="col-2">
												<label class="form-label">Received Qty</label>
											</div>
											<div class="col-2">
												<label class="form-label">Amount (Rs.)</label>
											</div>
										</div>
										
										<?php
										$i = 1;
										$select_det = mysqli_query($con, "SELECT * FROM grn_stock WHERE grn_no = '{$result_grn['grn_no']}'");
										while($result_det = mysqli_fetch_array($select_det)){
	
											$select_item = mysqli_query($con, "SELECT name FROM rawmaterial WHERE id = '{$result_det['item_id']}'");
											$result_item = mysqli_fetch_array($select_item);
										?>
										<div class="row form-group mb-3">
											<div class="col-5 mb-3">
												<input type="text" class="form-control" name="item<?php echo $i; ?>" id="item<?php echo $i; ?>" value="<?php echo $result_item['name']; ?>" readonly >
												<input type="hidden" class="form-control" name="itemid<?php echo $i; ?>" id="itemid<?php echo $i; ?>" value="<?php echo $result_det['item_id']; ?>" >
											</div>
											<div class="col-2 mb-3">
												<input type="text" class="form-control" name="rate<?php echo $i; ?>" id="rate<?php echo $i; ?>" placeholder="Rate" value="<?php echo $result_det['uprice']; ?>" onkeypress="return isNumberKeyn(event);" onchange="calculateAmount(1)" style="text-align: right;" readonly >
											</div>
											<div class="col-2 mb-3">
												<input type="text" class="form-control" name="qty<?php echo $i; ?>" id="qty<?php echo $i; ?>" placeholder="Qty" value="<?php echo $result_det['grn_qty']; ?>" onkeypress="return isNumberKeyn(event);" onchange="calculateAmount(1)" style="text-align: right;" readonly >
											</div>
											<div class="col-2 mb-3">
												<input type="text" class="form-control" name="amount<?php echo $i; ?>" id="amount<?php echo $i; ?>" placeholder="Amount" value="<?php echo $result_det['amount']; ?>" style="text-align: right;" readonly >
											</div>
										</div>
										<?php $i++; } ?>
										
										<input type="hidden" name="num_rows" id="num_rows" value="<?php echo $i-1; ?>" >

										<div class="row">
											<div class="col-7 mb-3">
												&nbsp;
											</div>
											<div class="col-lg-2 mb-3">
												<label class="form-label">Total (Rs.)</label>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="total" id="total" style="text-align: right;" value="<?php echo $result_grn['total']; ?>" readonly />
											</div>
										</div>

										<div class="mb-3">
											<input type="submit" class="btn btn-success" name="approve" id="approve" value="Approve" >
											<input type="submit" class="btn btn-danger" name="reject" id="reject" value="Reject" >
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
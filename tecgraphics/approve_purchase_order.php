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
					<h1 class="h3 mb-3 col-10">Purchase Order Approval</h1>
					<!--<div class="col-2" align="right"><a href="purchase_order_list.php"><button class="btn btn-warning">View List</button></a></div>-->
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form method="post" name="porder_form" action="approve_purchase_order_submit.php" >
										<div class="row form-group mb-3">
											<?php
											$pid = $_GET['qid'];
											//Set time zone
											$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
											$cur_date = $createToday->format('Y-m-d');

											$select_po = mysqli_query($con, "SELECT * FROM purchase_order_summary WHERE id = '$pid'");
										    $result_po = mysqli_fetch_array($select_po);

											?>
											<div class="col-2  mb-3">
												<label class="form-label">PO No. </label>
												<input type="text" class="form-control" name="po_num" id="po_num" value="<?php echo $result_po['po_no']; ?>" readonly >
											</div>
											<div class="col-3  mb-3">
												<label class="form-label">PO Date <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="po_date" id="po_date" value="<?php echo $result_po['po_date']; ?>" readonly >
											</div>
											<div class="col-4  mb-3">
												<label class="form-label">Supplier <span style="color:red">*</span></label>
												<select class="form-select" name="supplier" id="supplier" >
													<?php
													$select_supp  = mysqli_query($con, "SELECT id, sname FROM supplier WHERE id = '{$result_po['supplier']}'");
													while($result_supp = mysqli_fetch_array($select_supp)){
													?>
													<option value="<?php echo $result_supp['id']; ?>"><?php echo $result_supp['sname']; ?></option>
													<?php } ?>
												</select>
												<span class="error_msg" id="supp_error" ></span>
											</div>
										</div>

										<div class="row form-group mb-3">
											<div class="col-5 mb-3">
												<label class="form-label">Raw Material <span style="color:red">*</span></label>
											</div>
											<div class="col-2 mb-3">
												<label class="form-label">Rate (Rs.)</label>
											</div>
											<div class="col-2 mb-3">
												<label class="form-label">Qty</label>
											</div>
											<div class="col-2 mb-3">
												<label class="form-label">Amount (Rs.)</label>
											</div>
										</div>

										<?php
										$i=1;
										$select_details = mysqli_query($con, "SELECT * FROM purchase_order_detail WHERE po_no = '{$result_po['po_no']}'");
										while($result_details = mysqli_fetch_array($select_details)){
											
											$select_item = mysqli_query($con, "SELECT name FROM rawmaterial WHERE id = '{$result_details['item_id']}'");
											$result_item = mysqli_fetch_array($select_item);
										?>
										
										<div class="row form-group mb-3">
											<div class="col-5 mb-3">
												<input type="text" class="form-control" name="item<?php echo $i; ?>" id="item<?php echo $i; ?>" value="<?php echo $result_item['name']; ?>" readonly >
												<input type="hidden" class="form-control" name="itemid<?php echo $i; ?>" id="itemid<?php echo $i; ?>" value="<?php echo $result_details['item_id']; ?>" >
											</div>
											<div class="col-2 mb-3">
												<input type="text" class="form-control" name="rate<?php echo $i; ?>" id="rate<?php echo $i; ?>" style="text-align: right;" value="<?php echo $result_details['uprice']; ?>" readonly >
											</div>
											<div class="col-2 mb-3">
												<input type="text" class="form-control" name="qty<?php echo $i; ?>" id="qty<?php echo $i; ?>" style="text-align: right;" value="<?php echo $result_details['po_qty']; ?>" readonly >
											</div>
											<div class="col-2 mb-3">
												<input type="text" class="form-control" name="amount<?php echo $i; ?>" id="amount<?php echo $i; ?>" style="text-align: right;" value="<?php echo $result_details['amount']; ?>" readonly >
											</div>
										</div>

										<?php $i++; } ?>
										
										<input type="hidden" name="num_rows" id="num_rows" value="1" >

										<div class="row">
											<div class="col-7 mb-3">
												&nbsp;
											</div>
											<div class="col-lg-2 mb-3">
												<label class="form-label">Total (Rs.)</label>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="total" id="total" style="text-align: right;" value="<?php echo $result_po['total']; ?>" readonly />
											</div>
										</div>

										<div class="row">
											<div class="col-lg-12 mb-3">
												<label class="form-label">Special Note</label>
												<textarea class="form-control" name="notes" id="notes" rows="3" readonly><?php echo $result_po['snote']; ?></textarea>
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
	
	function browseList(i){
		window.open("select_rawmaterial.php?row="+i,"_blank","width=500,height=400");
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
			var amount = parseFloat(document.getElementById("amount"+i).value);

			total += amount;
		}
		
		document.getElementById("total").value = format_number(total, 2);
	}

	function add_more(){

	var item = new Array();
	var itemid = new Array();
	var rate = new Array();
	var qty = new Array();
	var amount = new Array();
	
	int_num_rows = parseInt(document.getElementById("num_rows").value);
	total_rows = int_num_rows+1;
	
	for(i=2; i<total_rows; i++){
		item[i]	= document.getElementById("item"+i).value;
		itemid[i]	= document.getElementById("itemid"+i).value;
		rate[i]	= document.getElementById("rate"+i).value;
		qty[i]	= document.getElementById("qty"+i).value;
		amount[i]= document.getElementById("amount"+i).value;
	}
	
	document.getElementById("item_div").innerHTML = "";
	main_tab = '';
	
		
	for (i=2; i<=total_rows; i++) {
		if (i == total_rows) {
			
			
			main_tab += '<div class="row form-group mb-3">';
			main_tab += '<div class="col-5">';
			main_tab += '<input class="form-control" id="item'+i+'" name="item'+i+'" type="text" placeholder="Raw Material" onclick="browseList('+i+')" readonly /><input class="form-control" id="itemid'+i+'" name="itemid'+i+'" type="hidden" /></div>';
			main_tab += '<div class="col-2">';
			main_tab += '<input class="form-control " id="rate'+i+'" name="rate'+i+'" type="text" placeholder="Rate" onkeypress="return isNumberKeyn(event);" onchange="calculateAmount('+i+')" style="text-align: right;" /></div>';
			main_tab += '<div class="col-2">';
			main_tab += '<input class="form-control " id="qty'+i+'" name="qty'+i+'" type="text" placeholder="Qty" onkeypress="return isNumberKeyn(event);" onchange="calculateAmount('+i+')" style="text-align: right;" /></div>';
			main_tab += '<div class="col-2 mb-3">';
			main_tab += '<input class="form-control " id="amount'+i+'" name="amount'+i+'" type="text" placeholder="Amount" style="text-align: right;" readonly /></div>';
			main_tab += '<div class="col-1 mb-3">';
			main_tab += '<button type="button" name="button'+i+'" id="button'+i+'" class="btn btn-danger" onclick="deleteRow('+i+')" ><b>&times;</b></button</div>';
			main_tab += '</div>';
		    
		}
		
		else {
			
			main_tab += '<div class="row form-group mb-3">';
			main_tab += '<div class="col-5">';
			main_tab += '<input type="text" name="item'+i+'" id="item'+i+'" class="form-control" value=\"'+item[i]+'\" placeholder="Raw Material" onclick="browseList('+i+')" readonly /><input class="form-control" id="itemid'+i+'" name="itemid'+i+'" value=\"'+itemid[i]+'\" type="hidden" /></div>';
			main_tab += '<div class="col-2">';
			main_tab += '<input type="text" name="rate'+i+'" id="rate'+i+'" class="form-control" value=\"'+rate[i]+'\" placeholder="Rate" onkeypress="return isNumberKeyn(event);" onchange="calculateAmount('+i+')" style="text-align: right;" /></div>';
			main_tab += '<div class="col-2">';
			main_tab += '<input type="text" name="qty'+i+'" id="qty'+i+'" class="form-control"  value=\"'+qty[i]+'\" placeholder="Qty" onkeypress="return isNumberKeyn(event);" onchange="calculateAmount('+i+')" style="text-align: right;" /></div>';
			main_tab += '<div class="col-2 mb-3">';
			main_tab += '<input type="text" name="amount'+i+'" id="amount'+i+'" class="form-control" value=\"'+amount[i]+'\" placeholder="Amount" style="text-align: right;" readonly /></div>';
			main_tab += '<div class="col-1 mb-3">';
			main_tab += '<button type="button" name="button'+i+'" id="button'+i+'" class="btn btn-danger" onclick="deleteRow('+i+')" ><b>&times;</b></button></div>';
			main_tab += '</div>';

		}
	}
	
	main_tab += "";
	
	document.getElementById("item_div").innerHTML = main_tab;
	document.getElementById("num_rows").value = total_rows;
}
// End of Ad Row


// Delete Row
function deleteRow(row) {

	var item = new Array();
	var itemid = new Array();
	var rate = new Array();
	var qty = new Array();
	var amount = new Array();
	
	
	int_num_rows = parseInt(document.getElementById("num_rows").value);
	row = parseInt(row);
	k = 2;
	m = k;
	
	for (; k<=int_num_rows; k++) {
		if (k == row) {			
		}
		else {		
			item[m]	= document.getElementById("item"+k).value;
			itemid[m]	= document.getElementById("itemid"+k).value;
			rate[m]	= document.getElementById("rate"+k).value;
			qty[m]= document.getElementById("qty"+k).value;
			amount[m]	= document.getElementById("amount"+k).value;
			m++;
		}
	}
	
	document.getElementById("item_div").innerHTML = "";
	main_tab = '';
	
	i = 2;
	j = i;
	for (; i<=int_num_rows; i++) {
		if (i == row) { 
		}
		else {
			
			main_tab += '<div class="row form-group mb-3">';
			main_tab += '<div class="col-5">';
			main_tab += '<input type="text" name="item'+j+'" id="item'+j+'" class="form-control" value=\"'+item[j]+'\" placeholder="Raw Material" onclick="browseList('+j+')" readonly /><input class="form-control" id="itemid'+j+'" name="itemid'+j+'" value=\"'+itemid[j]+'\" type="hidden" /></div>';
			main_tab += '<div class="col-2">';
			main_tab += '<input type="text" name="rate'+j+'" id="rate'+j+'" class="form-control" value=\"'+rate[j]+'\" placeholder="Rate" onkeypress="return isNumberKeyn(event);" onchange="calculateAmount('+j+')" style="text-align: right;" /></div>';
			main_tab += '<div class="col-2 mb-3">';
			main_tab += '<input type="text" name="qty'+j+'" id="qty'+j+'" class="form-control" value=\"'+qty[j]+'\"  placeholder="Qty" onkeypress="return isNumberKeyn(event);" onchange="calculateAmount('+j+')" style="text-align: right;" /></div>';
			main_tab += '<div class="col-2 mb-3">';
			main_tab += '<input type="text" name="amount'+j+'" id="amount'+j+'" class="form-control" value=\"'+amount[j]+'\" placeholder="Amount" style="text-align: right;" readonly /></div>';
			main_tab += '<div class="col-1 mb-3">';
			main_tab += '<button type="button" name="button'+j+'" id="button'+j+'" class="btn btn-danger" onclick="deleteRow('+j+')" ><b>&times;</b></button></div>';
			main_tab += '</div>'; 
			
			j++;
		}
	}
	
	main_tab += '';
	document.getElementById("item_div").innerHTML = main_tab;
	document.getElementById("num_rows").value = int_num_rows-1;

	calculateTotal();
	
}
// End of Delete Row

function validateForm() {
  var prevent = '';

  let supplier = document.forms["porder_form"]["supplier"].value;
  if (supplier == "") {
	document.getElementById("supp_error").innerHTML = "Supplier name must be selected";
	document.getElementById("supplier").className  = "form-select error";
	prevent = 'yes';
  } else {
	document.getElementById("supp_error").innerHTML = "";
	document.getElementById("supplier").className  = "form-select";
  }

  var num_rows = document.getElementById("num_rows").value;

  for(i=1; i<=num_rows; i++){

  let item = document.forms["porder_form"]["item"+i].value;
  if (item == "") {
	document.getElementById("item"+i).className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("item"+i).className  = "form-control";
  }
  
  let rate = document.forms["porder_form"]["rate"+i].value;
  if (rate == "") {
	document.getElementById("rate"+i).className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("rate"+i).className  = "form-control";
  }

  let qty = document.forms["porder_form"]["qty"+i].value;
  if (qty == "") {
	document.getElementById("qty"+i).className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("qty"+i).className  = "form-control";
  }

  }
  
  if(prevent == 'yes'){
	  return false;
  }
}

	</script>

</body>

</html>
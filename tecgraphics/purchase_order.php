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
					<h1 class="h3 mb-3 col-10">Purchase Order</h1>
					<div class="col-2" align="right"><a href="purchase_order_list.php"><button class="btn btn-warning">View List</button></a></div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form method="post" name="porder_form" action="purchase_order_submit.php" onsubmit="return validateForm()" >
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

											$select_max = mysqli_query($con, "SELECT po_no FROM `purchase_order_summary` ORDER BY id DESC");
											if(mysqli_num_rows($select_max) > 0){
												$result_max = mysqli_fetch_array($select_max);
													$temp = substr($result_max['po_no'], 2);
													$max = $temp+1;
													$po_no = 'PO'.$max;
											} else {
												$po_no = 'PO10001';
											}
											?>
											<div class="col-2  mb-3">
												<label class="form-label">PO No. </label>
												<input type="text" class="form-control" name="po_num" id="po_num" value="<?php echo $po_no; ?>" readonly >
											</div>
											<div class="col-3  mb-3">
												<label class="form-label">PO Date <span style="color:red">*</span></label>
												<input type="text" class="form-control flatpickr-minimum flatpickr-input" name="po_date" id="po_date" value="<?php echo $cur_date; ?>" readonly >
												<span class="error_msg" id="date_error" ></span>
											</div>
											<div class="col-4  mb-3">
												<label class="form-label">Supplier <span style="color:red">*</span></label>
												<select class="form-select" name="supplier" id="supplier" >
													<option value="">-Please Select-</option>
													<?php
													$select_supp  = mysqli_query($con, "SELECT id, sname FROM supplier");
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
												<input type="text" class="form-control" name="item1" id="item1" placeholder="Raw Material" onclick="browseList(1)" readonly >
												<input type="hidden" class="form-control" name="itemid1" id="itemid1" >
											</div>
											<div class="col-2 mb-3">
												<label class="form-label">Rate (Rs.)</label>
												<input type="text" class="form-control" name="rate1" id="rate1" placeholder="Rate" onkeypress="return isNumberKeyn(event);" onchange="calculateAmount(1)" style="text-align: right;" >
											</div>
											<div class="col-2 mb-3">
												<label class="form-label">Qty</label>
												<input type="text" class="form-control" name="qty1" id="qty1" placeholder="Qty" onkeypress="return isNumberKeyn(event);" onchange="calculateAmount(1)" style="text-align: right;" >
												<span id="uom1" style="color:blue"></span>
											</div>
											<div class="col-2 mb-3">
												<label class="form-label">Amount (Rs.)</label>
												<input type="text" class="form-control" name="amount1" id="amount1" placeholder="Amount" style="text-align: right;" readonly >
											</div>
										</div>
										
										<div id="item_div"></div>

										<input type="hidden" name="num_rows" id="num_rows" value="1" >

										<div class="mb-3">
											<input type="button" class="btn btn-primary" value="Add More" onclick="add_more()" >
										</div>
										
										<div class="row">
											<div class="col-7 mb-3">
												&nbsp;
											</div>
											<div class="col-lg-2 mb-3">
												<label class="form-label">Total (Rs.)</label>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="total" id="total" style="text-align: right;" readonly />
											</div>
										</div>

										<div class="row">
											<div class="col-lg-12 mb-3">
												<label class="form-label">Special Note</label>
												<textarea class="form-control" name="notes" id="notes" rows="3"></textarea>
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
			if (isNaN(parseFloat(document.getElementById("amount"+i).value))) {
				total += 0;
			} else {
				var amount = parseFloat(document.getElementById("amount"+i).value);
				total += amount;
			}
			
		}
		
		document.getElementById("total").value = format_number(total, 2);
	}

	function add_more(){

	var item = new Array();
	var itemid = new Array();
	var rate = new Array();
	var qty = new Array();
	var uom = new Array();
	var amount = new Array();
	
	int_num_rows = parseInt(document.getElementById("num_rows").value);
	total_rows = int_num_rows+1;
	
	for(i=2; i<total_rows; i++){
		item[i]	= document.getElementById("item"+i).value;
		itemid[i]	= document.getElementById("itemid"+i).value;
		rate[i]	= document.getElementById("rate"+i).value;
		qty[i]	= document.getElementById("qty"+i).value;
		uom[i]	= document.getElementById("uom"+i).innerHTML;
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
			main_tab += '<input class="form-control " id="qty'+i+'" name="qty'+i+'" type="text" placeholder="Qty" onkeypress="return isNumberKeyn(event);" onchange="calculateAmount('+i+')" style="text-align: right;" /><span id="uom'+i+'" style="color:blue"></span></div>';
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
			main_tab += '<input type="text" name="qty'+i+'" id="qty'+i+'" class="form-control"  value=\"'+qty[i]+'\" placeholder="Qty" onkeypress="return isNumberKeyn(event);" onchange="calculateAmount('+i+')" style="text-align: right;" /><span id="uom'+i+'" style="color:blue">'+uom[i]+'</span></div>';
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
	var uom = new Array();
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
			uom[m]= document.getElementById("uom"+k).innerHTML;
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
			main_tab += '<input type="text" name="qty'+j+'" id="qty'+j+'" class="form-control" value=\"'+qty[j]+'\"  placeholder="Qty" onkeypress="return isNumberKeyn(event);" onchange="calculateAmount('+j+')" style="text-align: right;" /><span id="uom'+j+'" style="color:blue">'+uom[j]+'</span></div>';
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

  let po_date = document.forms["porder_form"]["po_date"].value;
  if (po_date == "") {
	document.getElementById("date_error").innerHTML = "Date must be selected";
	document.getElementById("po_date").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("date_error").innerHTML = "";
	document.getElementById("po_date").className  = "form-control";
  }
  
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
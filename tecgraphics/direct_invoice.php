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
					<h1 class="h3 mb-3 col-10">Direct Invoice</h1>
					<div class="col-2" align="right"><a href="direct_invoice_list.php"><button class="btn btn-warning">View List</button></a></div>
					</div>


<?php
//Set time zone
$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$cur_date = $createToday->format('Y-m-d');

$select_max = mysqli_query($con, "SELECT invoice_no FROM `invoice` ORDER BY id DESC");

if(mysqli_num_rows($select_max) > 0){
	$result_max = mysqli_fetch_array($select_max);
		$temp = substr($result_max['invoice_no'], 3);
		$max = $temp+1;
		$inv_no = 'INV'.$max;

} else {
	$inv_no = 'INV10001';
}

?>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form name="invoice_form" method="post" action="direct_invoice_submit.php" onsubmit="return validateForm()" >
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
										<div class="row">
											<div class="col-lg-2 col-xs-6 mb-3">
												<label class="form-label">Invoice Date</label>
												<input type="text" class="form-control flatpickr-minimum flatpickr-input" name="inv_date" id="inv_date" value="<?php echo $cur_date; ?>" readonly />
												<span class="error_msg" id="date_error" ></span>
											</div>
											<div class="col-lg-3 col-sm-12 mb-5">
												<label class="form-label">Invoice No.</label>
												<input type="text" class="form-control" name="inv_no" id="inv_no" value="<?php echo $inv_no; ?>" readonly />
											</div>
											<div class="col-lg-4 col-sm-12 mb-3">
												<label class="form-label">Customer</label>
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
										
										<div class="row" style="margin-top: 10px;">
												<div class="col-lg-5 mb-3">
												<input type="text" class="form-control" name="product1" id="product1" />
												<span class="error_msg" id="product_error1" ></span>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="uprice1" id="uprice1" style="text-align:right" onkeypress="return isNumberKeyn(event);" onchange="calculateAmount(1)" />
												<span class="error_msg" id="uprice_error1" ></span>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="qty1" id="qty1" onkeypress="return isNumberKey(event);" onchange="calculateAmount(1)" />
												<span class="error_msg" id="qty_error1" ></span>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="amount1" id="amount1" style="text-align:right" readonly />
											</div>
											<div class="col-lg-1 mb-3">
												&nbsp;
											</div>
										</div>

										<div id="item_div"></div>
										
										<input type="hidden" name="num_rows" id="num_rows" value="1" />
										
										<div class="mb-3">
											<input type="button" class="btn btn-primary" value="Add More" onclick="add_more()" >
										</div>
										
										<div class="row" style="margin-top: 10px;">
											<div class="col-7 mb-3">
												&nbsp;
											</div>
											<div class="col-lg-2 mb-3">
												<label class="form-label">Subtotal (Rs.)</label>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="subtotal" id="subtotal" style="text-align: right;" readonly />
											</div>
											<div class="col-1 mb-3">
												&nbsp;
											</div>
										</div>
										
										<div class="row">
											<div class="col-5 mb-3">
												&nbsp;
											</div>
											<div class="col-lg-2 mb-3">
											<div style="display:flex">
												<input type="text" class="form-control" name="disc_per" id="disc_per" style="text-align: right; width: 50%" onchange="calculateTotal()" />&nbsp;%
											</div>
												<span class="error_msg" id="disc_error" ></span>
											</div>
											<div class="col-lg-2 mb-3">
												<label class="form-label">Discount (Rs.)</label>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="discount" id="discount" style="text-align: right;" readonly />
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
												<input type="text" class="form-control" name="total" id="total" style="text-align: right;" readonly />
											</div>
											<div class="col-1 mb-3">
												&nbsp;
											</div>
										</div>

										<div class="row">
											<div class="col-lg-2 mb-3">
												<input type="submit" class="btn btn-success" name="submit" id="submit" value="Save" />
											</div>
											<span class="error_msg" id="tot_error" ></span>
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
		var qty = parseFloat(document.getElementById("qty"+i).value);
		var uprice = parseFloat(document.getElementById("uprice"+i).value);
		
		var amount = uprice*qty;

		document.getElementById("amount"+i).value = format_number(amount, 2);
		calculateSubTotal();
		
	}

	function calculateSubTotal(){

		var num_rows = document.getElementById("num_rows").value;

		var subtotal = 0;
		for(i=1; i<=num_rows; i++){
			if (isNaN(parseFloat(document.getElementById("amount"+i).value))) {
				subtotal += 0;
			} else {
				var amount = parseFloat(document.getElementById("amount"+i).value); 
				subtotal += amount;
			}
		}

		document.getElementById("subtotal").value = format_number(subtotal, 2);
		calculateTotal();
	}

	function calculateTotal(){
		var subtotal = parseFloat(document.getElementById("subtotal").value);

		if (isNaN(parseFloat(document.getElementById("disc_per").value))) {
				var disc_per =  0;
		} else {
				var disc_per = parseFloat(document.getElementById("disc_per").value);
		}
		
		var discount = parseFloat(subtotal*disc_per/100);
		document.getElementById("discount").value = format_number(discount, 2);

		var total = parseFloat(subtotal-discount);
		document.getElementById("total").value = format_number(total, 2);
	}
	
	function add_more(){

	var product = new Array();
	var uprice = new Array();
	var qty = new Array();
	var amount = new Array();
	
	int_num_rows = parseInt(document.getElementById("num_rows").value);
	total_rows = int_num_rows+1;
	
	for(i=2; i<total_rows; i++){
		product[i]	= document.getElementById("product"+i).value;
		uprice[i]	= document.getElementById("uprice"+i).value;
		qty[i]	= document.getElementById("qty"+i).value;
		amount[i]= document.getElementById("amount"+i).value;
	}
	
	document.getElementById("item_div").innerHTML = "";
	main_tab = '';
	
		
	for (i=2; i<=total_rows; i++) {
		if (i == total_rows) {
			
			
			main_tab += '<div class="row form-group">';
			main_tab += '<div class="col-5">';
			main_tab += '<input class="form-control" name="product'+i+'" id="product'+i+'" type="text" placeholder="Product" /><span class="error_msg" id="product_error'+i+'" ></span></div>';
			main_tab += '<div class="col-2">';
			main_tab += '<input class="form-control" id="uprice'+i+'" name="uprice'+i+'" type="text" style="text-align:right;" placeholder="Unit Price" onkeypress="return isNumberKeyn(event);" onchange="calculateAmount('+i+')" /><span class="error_msg" id="uprice_error'+i+'" ></span></div>';
			main_tab += '<div class="col-2">';
			main_tab += '<input class="form-control" id="qty'+i+'" name="qty'+i+'" type="text" placeholder="Qty" onkeypress="return isNumberKey(event);" onchange="calculateAmount('+i+')" /><span class="error_msg" id="qty_error'+i+'" ></span></div>';
			main_tab += '<div class="col-2 mb-3">';
			main_tab += '<input class="form-control" id="amount'+i+'" name="amount'+i+'" type="text" style="text-align:right;" placeholder="Amount" readonly /></div>';
			main_tab += '<div class="col-1 mb-3">';
			main_tab += '<input type="button" name="button'+i+'" id="button'+i+'" value="Delete" class="btn btn-danger" onclick="deleteProduct('+i+')" /></div>';
			main_tab += '</div>';
		    
		}
		
		else {
			
			main_tab += '<div class="row form-group">';
			main_tab += '<div class="col-5">';
			main_tab += '<input type="text" name="product'+i+'" id="product'+i+'" class="form-control" value=\"'+product[i]+'\" placeholder="Product" /><span class="error_msg" id="product_error'+i+'" ></span></div>';
			main_tab += '<div class="col-2">';
			main_tab += '<input type="text" name="uprice'+i+'" id="uprice'+i+'" class="form-control" value=\"'+uprice[i]+'\" style="text-align:right;" placeholder="Unit Price" onkeypress="return isNumberKeyn(event);" onchange="calculateAmount('+i+')" /><span class="error_msg" id="uprice_error'+i+'" ></span></div>';
			main_tab += '<div class="col-2 mb-3">';
			main_tab += '<input type="text" name="qty'+i+'" id="qty'+i+'" class="form-control"  value=\"'+qty[i]+'\" placeholder="Qty" onkeypress="return isNumberKey(event);" onchange="calculateAmount('+i+')" /><span class="error_msg" id="qty_error'+i+'" ></span></div>';
			main_tab += '<div class="col-2 mb-3">';
			main_tab += '<input type="text" name="amount'+i+'" id="amount'+i+'" class="form-control" value=\"'+amount[i]+'\" style="text-align:right;" placeholder="Amount" readonly /></div>';
			main_tab += '<div class="col-1 mb-3">';
			main_tab += '<input type="button" name="button'+i+'" id="button'+i+'" value="Delete" class="btn btn-danger" onclick="deleteProduct('+i+')" /></div>';
			main_tab += '</div>';

		}
	}
	
	main_tab += "";
	
	document.getElementById("item_div").innerHTML = main_tab;
	document.getElementById("num_rows").value = total_rows;
}
// End of Ad Row

// Delete Row
function deleteProduct(row) {

	var product = new Array();
	var uprice	= new Array();
	var qty		= new Array();
	var amount	= new Array();
	
	
	int_num_rows = parseInt(document.getElementById("num_rows").value);
	row = parseInt(row);
	k = 2;
	m = k;
	
	for (; k<=int_num_rows; k++) {
		if (k == row) {			
		}
		else {		
			product[m]	= document.getElementById("product"+k).value;
			uprice[m]	= document.getElementById("uprice"+k).value;
			qty[m]		= document.getElementById("qty"+k).value;
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
			
			main_tab += '<div class="row form-group">';
			main_tab += '<div class="col-5">';
			main_tab += '<input type="text" name="product'+j+'" id="product'+j+'" class="form-control" style="width:100%" value=\"'+product[j]+'\" placeholder="Product" /><span class="error_msg" id="product_error'+j+'" ></span></div>';
			main_tab += '<div class="col-2">';
			main_tab += '<input type="text" name="uprice'+j+'" id="uprice'+j+'" class="form-control" style="width:100%; text-align:right;" value=\"'+uprice[j]+'\" placeholder="Unit Price" onkeypress="return isNumberKeyn(event);" onchange="calculateAmount('+j+')" /><span class="error_msg" id="uprice_error'+j+'" ></span></div>';
			main_tab += '<div class="col-2 mb-3">';
			main_tab += '<input type="text" name="qty'+j+'" id="qty'+j+'" class="form-control" style="width:100%" value=\"'+qty[j]+'\"  placeholder="Qty" onkeypress="return isNumberKey(event);" onchange="calculateAmount('+j+')" /><span class="error_msg" id="qty_error'+j+'" ></span></div>';
			main_tab += '<div class="col-2 mb-3">';
			main_tab += '<input type="text" name="amount'+j+'" id="amount'+j+'" class="form-control" style="width:100%; text-align:right;" value=\"'+amount[j]+'\" placeholder="Amount" readonly /></div>';
			main_tab += '<div class="col-1 mb-3">';
			main_tab += '<input type="button" name="button'+j+'" id="button'+j+'" value="Delete" class="btn btn-danger" onclick="deleteProduct('+j+')" /></div>';
			main_tab += '</div>'; 
			
			j++;
		}
	}
	
	main_tab += '';
	document.getElementById("item_div").innerHTML = main_tab;
	document.getElementById("num_rows").value = int_num_rows-1;
	calculateSubTotal();
}
// End of Delete Row

	</script>

	<script>
		function validateForm() {
		  var prevent = '';
		  
		  let inv_date = document.forms["invoice_form"]["inv_date"].value;
		  if (inv_date == "") {
			document.getElementById("date_error").innerHTML = "Date must be selected";
			document.getElementById("inv_date").className  = "form-control error";
			prevent = 'yes';
		  } else {
			document.getElementById("date_error").innerHTML = "";
			document.getElementById("inv_date").className  = "form-control";
		  }

		  let customer = document.forms["invoice_form"]["customer"].value;
		  if (customer == "") {
			document.getElementById("cus_error").innerHTML = "Customer must be selected";
			document.getElementById("customer").className  = "form-select error";
			prevent = 'yes';
		  } else {
			document.getElementById("cus_error").innerHTML = "";
			document.getElementById("customer").className  = "form-select";
		  }
  
		  num_rows = document.getElementById("num_rows").value;

		  for(i=1; i<=num_rows; i++){
		  
		  let product = document.forms["invoice_form"]["product"+i].value;
		  if (product == "") {
			document.getElementById("product_error"+i).innerHTML = "Product should be filled";
			document.getElementById("product"+i).className  = "form-control error";
			prevent = 'yes';
		  } else {
			document.getElementById("product_error"+i).innerHTML = "";
			document.getElementById("product"+i).className  = "form-control";
		  }

		  let uprice = document.forms["invoice_form"]["uprice"+i].value;
		  if (uprice == "") {
			document.getElementById("uprice_error"+i).innerHTML = "Price should be filled";
			document.getElementById("uprice"+i).className  = "form-control error";
			prevent = 'yes';
		  } else {
			document.getElementById("uprice_error"+i).innerHTML = "";
			document.getElementById("uprice"+i).className  = "form-control";
		  }

		  let qty = document.forms["invoice_form"]["qty"+i].value;
		  if (qty == "" || qty == 0) {
			document.getElementById("qty_error"+i).innerHTML = "Qty should be filled";
			document.getElementById("qty"+i).className  = "form-control error";
			prevent = 'yes';
		  } else {
			document.getElementById("qty_error"+i).innerHTML = "";
			document.getElementById("qty"+i).className  = "form-control";
		  }

		  }
		  
		  let subtotal = document.forms["invoice_form"]["subtotal"].value;
		  if (subtotal == "" || subtotal == 0 ) {
			document.getElementById("tot_error").innerHTML = "There should be atleast one item selected for invoice.";
			prevent = 'yes';
		  } else {
			document.getElementById("tot_error").innerHTML = "";
		  }

		  if(prevent == 'yes'){
			  return false;
		  }
		}
  
	</script>

</body>

</html>
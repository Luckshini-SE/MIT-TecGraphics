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

<body onload="calculateSubTotal()">
	<div class="wrapper">

	<?php include('sidebar.php'); ?>

		<div class="main">
			
		<?php include('topbar.php'); ?>

			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Invoice</h1>
				

<?php
//Set time zone
$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$cur_date = $createToday->format('Y-m-d');

$jid = $_GET['jid'];
$select_job = mysqli_query($con, "SELECT * FROM jobcard WHERE id = '$jid'");
$result_job = mysqli_fetch_array($select_job);

$select_cust = mysqli_query($con, "SELECT title, name, last_name FROM customer WHERE id = '{$result_job['cus_id']}'");
$result_cust = mysqli_fetch_array($select_cust);
	if($result_cust['title']!='6'){
		$select_title = mysqli_query($con, "SELECT title FROM title WHERE id = '{$result_cust['title']}'");
		$result_title = mysqli_fetch_array($select_title);
		$cusname = $result_title['title'].'. '.$result_cust['name'].' '.$result_cust['last_name'];
	} else {
		$cusname = $result_cust['name'].' '.$result_cust['last_name'];
	}

$select_quo = mysqli_query($con, "SELECT * FROM quotation WHERE id = '{$result_job['quotation_id']}'");
$result_quo = mysqli_fetch_array($select_quo);
	if($result_quo['dis_per'] != '' && $result_quo['dis_per'] != 0){
		$dis_per = $result_quo['dis_per'];
		$discount = $result_quo['discount'];
	} else {
		$dis_per = "0";
		$discount = "0.00";
	}
?>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form name="invoice_form" method="post" action="create_invoice_submit.php" onsubmit="return validateForm()" >
										<div class="row">
											<div class="col-lg-2 col-xs-6 mb-3">
												<label class="form-label">Invoice Date</label>
												<input type="text" class="form-control flatpickr-minimum flatpickr-input" name="inv_date" id="inv_date" value="<?php echo $cur_date; ?>" readonly />
												<span class="error_msg" id="date_error" ></span>
											</div>
											<div class="col-lg-3 col-sm-12 mb-5">
												<label class="form-label">Job No.</label>
												<input type="text" class="form-control" name="job_no" id="job_no" value="<?php echo $result_job['jobno']; ?>" readonly />
												<input type="hidden" class="form-control" name="job_id" id="job_id" value="<?php echo $result_job['id']; ?>" />
											</div>
											<div class="col-lg-4 col-sm-12 mb-3">
												<label class="form-label">Customer</label>
												<input type="text" class="form-control" name="customer" id="customer" value="<?php echo $cusname; ?>" readonly />
												<input type="hidden" class="form-control" name="cust_id" id="cust_id" value="<?php echo $result_job['cus_id']; ?>" />
											</div>
										</div>

										<div class="row" style="border-bottom: 1px solid #939ba2;">
											<div class="col-lg-1">
												<label class="form-label">&nbsp;</label>
											</div>
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
										</div>
										
										<?php
										$i=1;
										$select_jobitm = mysqli_query($con, "SELECT * FROM jobcard_details WHERE jobcard_id = '$jid' AND CAST(completed_qty AS UNSIGNED) >  CAST(invoiced_qty AS UNSIGNED)");
										while($result_jobitm = mysqli_fetch_array($select_jobitm)){

										$select_quotitm = mysqli_query($con, "SELECT * FROM quotation_details WHERE id = '{$result_jobitm['qitm_id']}'");
										$result_quotitm = mysqli_fetch_array($select_quotitm);

										$select_reqitm = mysqli_query($con, "SELECT * FROM requests WHERE id = '{$result_quotitm['req_item_id']}'");
										$result_reqitm = mysqli_fetch_array($select_reqitm);
										
										$select_product = mysqli_query($con, "SELECT name, pricing, uprice FROM products WHERE id = '{$result_reqitm['prod_id']}'");
										$result_product = mysqli_fetch_array($select_product);
										
										if($result_product['pricing'] == 1){
											$measure = '';
										} else {
											$select_meas = mysqli_query($con, "SELECT measure FROM pricing WHERE id = '{$result_product['pricing']}'");
											$result_meas = mysqli_fetch_array($select_meas);	
											$measure = $result_meas['measure'];
										}

										$description = '';

                        if($result_reqitm['material'] != ''){
                            $select_mat = mysqli_query($con, "SELECT name FROM pro_material WHERE id = '{$result_reqitm['material']}'");
                            $result_mat = mysqli_fetch_array($select_mat);

                            $description .= $result_mat['name'];
                        }
                        
                        if($result_reqitm['size'] != ''){
                            $select_siz = mysqli_query($con, "SELECT name FROM pro_size WHERE id = '{$result_reqitm['size']}'");
                            $result_siz = mysqli_fetch_array($select_siz);

                            $description .= ' | '.$result_siz['name'];
                        }
                        
                        if($result_reqitm['width'] != ''){
                            $description .= ' | '.$result_reqitm['width'].' x '.$result_reqitm['height'].' '.$measure;
                        }
                        
                        if($result_reqitm['color'] != ''){
                            $select_col = mysqli_query($con, "SELECT name FROM pro_color WHERE id = '{$result_reqitm['color']}'");
                            $result_col = mysqli_fetch_array($select_col);

                            $description .= ' | '.$result_col['name'];
                        }
                        
						if($result_reqitm['spe_note'] != ''){
                            $description .= ' | '.$result_reqitm['spe_note'];
                        }
                        
										if($result_quotitm['artwork_status'] == 'yes' && $result_jobitm['artwork_inv'] == 'no'){
											$aw_price = $result_quotitm['artwork'];
										} else {
											$aw_price = "0.00";
										}
										
										if($result_quotitm['service_status'] == 'yes' && $result_jobitm['service_inv'] == 'no'){		//One day
											$sv_price = $result_quotitm['service'];
										} else {											//Standard
											$sv_price = "0.00";
										}
										
										?>

										<div class="row" style="margin-top: 10px;">
											<div class="col-lg-1 mb-3">
												<input type="checkbox" name="select<?php echo $i; ?>" id="select<?php echo $i; ?>" checked onchange="select_itm(<?php echo $i; ?>)" />
											</div>
											<div class="col-lg-5 mb-3">
												<b><?php echo htmlspecialchars($result_product['name']); ?></b><br/>
												<?php echo $description; ?>
												<input type="hidden" name="prod_id<?php echo $i; ?>" id="prod_id<?php echo $i; ?>" value="<?php echo $result_jobitm['prod_id']; ?>" />
												<input type="hidden" name="row_id<?php echo $i; ?>" id="row_id<?php echo $i; ?>" value="<?php echo $result_jobitm['id']; ?>" />
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="uprice<?php echo $i; ?>" id="uprice<?php echo $i; ?>" style="text-align:right" value="<?php echo $result_quotitm['uprice']; ?>" readonly />
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="qty<?php echo $i; ?>" id="qty<?php echo $i; ?>" onkeypress="return isNumberKey(event);" value="<?php echo $result_jobitm['completed_qty']-$result_jobitm['invoiced_qty']; ?>" onchange="calculateAmount(<?php echo $i; ?>)" />
												<input type="hidden" class="form-control" name="maxqty<?php echo $i; ?>" id="maxqty<?php echo $i; ?>" value="<?php echo $result_jobitm['completed_qty']-$result_jobitm['invoiced_qty']; ?>" />
												<span class="error_msg" id="qty_error<?php echo $i; ?>" ></span>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="amount<?php echo $i; ?>" id="amount<?php echo $i; ?>" style="text-align:right" value="<?php echo number_format($result_quotitm['uprice']*($result_jobitm['completed_qty']-$result_jobitm['invoiced_qty']),2,'.',''); ?>" readonly />
											</div>
										</div>
										
										<div class="row">
											<div class="col-8 mb-3">
												&nbsp;
											</div>
											<div class="col-lg-2 mb-3">
												<label class="form-label">Artwork</label>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="aw_price<?php echo $i; ?>" id="aw_price<?php echo $i; ?>" style="text-align: right;" value="<?php echo $aw_price; ?>" readonly />
												<span class="error_msg" id="awp_error<?php echo $i; ?>" ></span>
											</div>
										</div>
										
										<div class="row" style="border-bottom: 1px solid #939ba2; margin-top: 5px;">
											<div class="col-8 mb-3">
												&nbsp;
											</div>
											<div class="col-lg-2 mb-3">
												<label class="form-label">One day Service</label>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="sv_price<?php echo $i; ?>" id="sv_price<?php echo $i; ?>" style="text-align: right;" value="<?php echo $sv_price; ?>" readonly />
												<span class="error_msg" id="svc_error<?php echo $i; ?>" ></span>
											</div>
										</div>

										<?php $i++; } ?>
										<input type="hidden" name="num_rows" id="num_rows" value="<?php echo $i-1; ?>" />
										
										
										<div class="row" style="margin-top: 10px;">
											<div class="col-8 mb-3">
												&nbsp;
											</div>
											<div class="col-lg-2 mb-3">
												<label class="form-label">Subtotal (Rs.)</label>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="subtotal" id="subtotal" style="text-align: right;" readonly />
											</div>
										</div>
										
										<div class="row">
											<div class="col-6 mb-3">
												&nbsp;
											</div>
											<div class="col-lg-2 mb-3">
											<div style="display:flex">
												<input type="text" class="form-control" name="disc_per" id="disc_per" style="text-align: right; width: 50%" value="<?php echo $dis_per; ?>" readonly />&nbsp;%
											</div>
												<span class="error_msg" id="disc_error" ></span>
											</div>
											<div class="col-lg-2 mb-3">
												<label class="form-label">Discount (Rs.)</label>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="discount" id="discount" style="text-align: right;" value="<?php echo $discount; ?>" readonly />
											</div>
										</div>

										<div class="row">
											<div class="col-8 mb-3">
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

	function select_itm(i){
		if(document.getElementById("select"+i).checked == true){
			document.getElementById("qty"+i).readOnly = false;
		} else {
			document.getElementById("qty"+i).readOnly = true;
		}
		calculateSubTotal();
	}

	function calculateAmount(i){
		var qty = parseFloat(document.getElementById("qty"+i).value);
		var maxqty = parseFloat(document.getElementById("maxqty"+i).value);

		if(qty > maxqty){
			alert("Invalid quantity");
			document.getElementById("qty"+i).value = maxqty;
			qty = maxqty;
		}
		var uprice = parseFloat(document.getElementById("uprice"+i).value);
		
		var amount = uprice*qty;

		document.getElementById("amount"+i).value = format_number(amount, 2);
		calculateSubTotal();
		
	}

	function calculateSubTotal(){

		var num_rows = document.getElementById("num_rows").value;

		var subtotal = 0;
		for(i=1; i<=num_rows; i++){
			if(document.getElementById("select"+i).checked == true){
				var amount = parseFloat(document.getElementById("amount"+i).value);

				if(isNaN(parseFloat(document.getElementById("aw_price"+i).value))){
						var aw_price = 0;
					} else {
						var aw_price = parseFloat(document.getElementById("aw_price"+i).value);
					}
			
				if(isNaN(parseFloat(document.getElementById("sv_price"+i).value))){
						var sv_price = 0;
					} else {
						var sv_price = parseFloat(document.getElementById("sv_price"+i).value);
					}
			
				var tot = amount + aw_price + sv_price;
				subtotal += tot;
			}
		}

		document.getElementById("subtotal").value = format_number(subtotal, 2);
		calculateTotal();
	}

	function calculateTotal(){
		var subtotal = parseFloat(document.getElementById("subtotal").value);

		var disc_per = parseFloat(document.getElementById("disc_per").value);

		var discount = parseFloat(subtotal*disc_per/100);
		document.getElementById("discount").value = format_number(discount, 2);

		var total = parseFloat(subtotal-discount);
		document.getElementById("total").value = format_number(total, 2);
	}

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
  
		  num_rows = document.getElementById("num_rows").value;

		  for(i=1; i<=num_rows; i++){
		  if(document.getElementById("select"+i).checked == true){
		  let qty = document.forms["invoice_form"]["qty"+i].value;
		  if (qty == "" || qty == 0) {
			document.getElementById("qty_error"+i).innerHTML = "Qty should be filled";
			document.getElementById("qty"+i).className  = "form-control error";
			prevent = 'yes';
		  } else {
			document.getElementById("qty_error"+i).innerHTML = "";
			document.getElementById("qty"+i).className  = "form-control";
		  }
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
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

					<h1 class="h3 mb-3">Quotation</h1>
				

<?php
//Set time zone
$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$cur_date = $createToday->format('Y-m-d');

$req = $_GET['req'];
$select_req = mysqli_query($con, "SELECT * FROM quotation_requests WHERE id = '$req'");
$result_req = mysqli_fetch_array($select_req);

$select_cust = mysqli_query($con, "SELECT title, name, last_name FROM customer WHERE id = '{$result_req['cus_id']}'");
$result_cust = mysqli_fetch_array($select_cust);
	if($result_cust['title']!='6'){
		$select_title = mysqli_query($con, "SELECT title FROM title WHERE id = '{$result_cust['title']}'");
		$result_title = mysqli_fetch_array($select_title);
		$cusname = $result_title['title'].'. '.$result_cust['name'].' '.$result_cust['last_name'];
	} else {
		$cusname = $result_cust['name'].' '.$result_cust['last_name'];
	}

?>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form name="quotation_form" method="post" action="create_quotation_submit.php" onsubmit="return validateForm()" >
										<div class="row">
											<div class="col-lg-3 col-sm-12 mb-5">
												<label class="form-label">Request No.</label>
												<input type="text" class="form-control" name="req_no" id="req_no" value="<?php echo $result_req['req_no']; ?>" readonly />
												<input type="hidden" class="form-control" name="req_id" id="req_id" value="<?php echo $result_req['id']; ?>" />
											</div>
											<div class="col-lg-2 col-xs-6 mb-3">
												<label class="form-label">Quotation Date</label>
												<input type="text" class="form-control flatpickr-minimum flatpickr-input" name="quot_date" id="quot_date" value="<?php echo $cur_date; ?>" readonly />
											</div>
											<div class="col-lg-4 col-sm-12 mb-3">
												<label class="form-label">Customer</label>
												<input type="text" class="form-control" name="customer" id="customer" value="<?php echo $cusname; ?>" readonly />
												<input type="hidden" class="form-control" name="cust_id" id="cust_id" value="<?php echo $result_req['cus_id']; ?>" />
											</div>
											<div class="col-lg-3 col-sm-6 mb-3">
												<label class="form-label">Sales Executive</label>
												<select class="form-select" name="sales_ex" id="sales_ex" >
													<?php
													if($_SESSION["logUserType"] == '6'){		//if logged in user is a sales executive
													$select_se = mysqli_query($con, "SELECT id, first_name, last_name FROM users WHERE user_type = '6' AND id = '{$_SESSION["logUserId"]}'");		//user type is sales executives
													while($result_se = mysqli_fetch_array($select_se)){
													?>
													<option value="<?php echo $result_se['id']; ?>"><?php echo $result_se['first_name'].' '.$result_se['last_name']; ?></option>
													<?php
													}	
													} else {									//if logged in user is not a sales executive
													?>
													<option value="">- Please Select -</option>
													<?php
													$select_se = mysqli_query($con, "SELECT id, first_name, last_name FROM users WHERE user_type = '6' AND active = 'yes'");		//user type is sales executives
													while($result_se = mysqli_fetch_array($select_se)){
													?>
													<option value="<?php echo $result_se['id']; ?>"><?php echo $result_se['first_name'].' '.$result_se['last_name']; ?></option>
													<?php
													}
													}
													?>
												</select>
												<span class="error_msg" id="sales_error" ></span>
											</div>
										</div>

										<div class="row" style="border-bottom: 1px solid #939ba2;">
											<div class="col-lg-4">
												<label class="form-label">Product</label>
											</div>
											<div class="col-lg-2">
												<label class="form-label">&nbsp;</label>
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
										$select_reqitm = mysqli_query($con, "SELECT * FROM requests WHERE req_id = '{$result_req['id']}'");
										while($result_reqitm = mysqli_fetch_array($select_reqitm)){
										
										$select_product = mysqli_query($con, "SELECT name, pricing, uprice FROM products WHERE id = '{$result_reqitm['prod_id']}'");
										$result_product = mysqli_fetch_array($select_product);

										if($result_product['pricing'] == 1){
											$item_uprice = $result_product['uprice'];
											$measure = '';
										} else {
											$item_uprice = $result_product['uprice']*$result_reqitm['width']*$result_reqitm['height'];
											
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
                        
										if($result_reqitm['artwork'] == 'need'){
											$artwork = 'Needed';
											$aw_check = "checked";
											$aw_read = "";
										} else {
											$artwork = 'Not needed';
											$aw_check = "";
											$aw_read = "readonly";
										}
										
										if($result_reqitm['service'] == 'oneday'){
											$service = 'Oneday';
											$sv_check = "checked";
											$sv_read = "";
										} else {
											$service = 'Standard';
											$sv_check = "";
											$sv_read = "readonly";
										}
										?>

										<div class="row" style="margin-top: 10px;">
											<div class="col-lg-6 mb-3">
												<b><?php echo htmlspecialchars($result_product['name']); ?></b><br/>
												<?php echo $description; ?>
												<input type="hidden" name="prod_id<?php echo $i; ?>" id="prod_id<?php echo $i; ?>" value="<?php echo $result_reqitm['prod_id']; ?>" />
												<input type="hidden" name="row_id<?php echo $i; ?>" id="row_id<?php echo $i; ?>" value="<?php echo $result_reqitm['id']; ?>" />
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="pro_price<?php echo $i; ?>" id="pro_price<?php echo $i; ?>" value="<?php echo number_format($item_uprice,2,'.',''); ?>" style="text-align: right;" readonly />
											</div>
											<div class="col-lg-2 mb-3">
												&nbsp;
											</div>
											<div class="col-lg-2 mb-3">
												&nbsp;
											</div>
										</div>

										<?php
										if($result_reqitm['finishing'] != ''){
										$select_fin = mysqli_query($con, "SELECT name, uprice FROM pro_finishing WHERE id = '{$result_reqitm['finishing']}'");
										$result_fin = mysqli_fetch_array($select_fin);
											$finish_up = $result_fin['uprice'];
										?>

										<div class="row">
											<div class="col-lg-6 mb-3" style="padding-left:235px; margin-top:5px;">
												Finishing: <?php echo $result_fin['name']; ?>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="finish<?php echo $i; ?>" id="finish<?php echo $i; ?>" value="<?php echo number_format($finish_up,2,'.',''); ?>" style="text-align: right;" readonly />
											</div>
											<div class="col-lg-2 mb-3">
												&nbsp;
											</div>
											<div class="col-lg-2 mb-3">
												&nbsp;
											</div>
										</div>

										<?php 
										} else {
											$finish_up = '0.00';
										}

										if($result_reqitm['spec1'] != ''){
										$select_spo = mysqli_query($con, "SELECT name, uprice FROM pro_spec1 WHERE id = '{$result_reqitm['spec1']}'");
										$result_spo = mysqli_fetch_array($select_spo);
											$spec1_up = $result_spo['uprice'];
										?>

										<div class="row">
											<div class="col-lg-6 mb-3" style="padding-left:235px; margin-top:5px;">
												Specification 1: <?php echo $result_spo['name']; ?>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="specone<?php echo $i; ?>" id="specone<?php echo $i; ?>" value="<?php echo number_format($spec1_up,2,'.',''); ?>" style="text-align: right;" readonly />
											</div>
											<div class="col-lg-2 mb-3">
												&nbsp;
											</div>
											<div class="col-lg-2 mb-3">
												&nbsp;
											</div>
										</div>

										<?php 
										} else {
											$spec1_up = '0.00';
										}

										if($result_reqitm['spec2'] != ''){
										$select_spt = mysqli_query($con, "SELECT name, uprice FROM pro_spec2 WHERE id = '{$result_reqitm['spec2']}'");
										$result_spt = mysqli_fetch_array($select_spt);
											$spec2_up = $result_spt['uprice'];
										?>

										<div class="row">
											<div class="col-lg-6 mb-3" style="padding-left:235px; margin-top:5px;">
												Specification 2: <?php echo $result_spt['name']; ?>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="spectwo<?php echo $i; ?>" id="spectwo<?php echo $i; ?>" value="<?php echo number_format($spec2_up,2,'.',''); ?>" style="text-align: right;" readonly />
											</div>
											<div class="col-lg-2 mb-3">
												&nbsp;
											</div>
											<div class="col-lg-2 mb-3">
												&nbsp;
											</div>
										</div>

										<?php 
										} else {
											$spec2_up = '0.00';
										}

										$net_uprice = $item_uprice + $finish_up + $spec1_up + $spec2_up;
										?>
										
										<div class="row">
											<div class="col-lg-4 mb-3">
												&nbsp;
											</div>
											<div class="col-lg-2 mb-3">
												&nbsp;
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="uprice<?php echo $i; ?>" id="uprice<?php echo $i; ?>" value="<?php echo number_format($net_uprice,2,'.',''); ?>" style="text-align: right;" readonly />
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="qty<?php echo $i; ?>" id="qty<?php echo $i; ?>" value="<?php echo $result_reqitm['qty']; ?>" readonly />
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="amount<?php echo $i; ?>" id="amount<?php echo $i; ?>" value="<?php echo number_format($net_uprice*$result_reqitm['qty'],2,'.',''); ?>" style="text-align: right;" readonly />
											</div>
										</div>

										<div class="row">
											<div class="col-8 mb-3">
												Image 1 : <?php if($result_reqitm['image1'] != ''){ ?><a href="img/quot_uploads/<?php echo $result_reqitm['image1']; ?>" target="_blank" >View</a><?php } else { echo 'No image'; } ?>
											</div>
											<div class="col-lg-2 mb-3">
												<label class="form-label">Artwork</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="artwork<?php echo $i; ?>" id="artwork<?php echo $i; ?>" onchange="enableArtwork(<?php echo $i; ?>)" <?php echo $aw_check; ?> />
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="aw_price<?php echo $i; ?>" id="aw_price<?php echo $i; ?>" onkeypress="return isNumberKeyn(event);" onchange="calculateSubTotal()" style="text-align: right;" <?php echo $aw_read; ?> />
												<span class="error_msg" id="awp_error<?php echo $i; ?>" ></span>
											</div>
										</div>
										
										<div class="row" style="border-bottom: 1px solid #939ba2; margin-top: 5px;">
											<div class="col-8 mb-3">
												Image 2 : <?php if($result_reqitm['image2'] != ''){ ?><a href="img/quot_uploads/<?php echo $result_reqitm['image2']; ?>" target="_blank" >View</a><?php } else { echo 'No image'; } ?>
											</div>
											<div class="col-lg-2 mb-3">
												<label class="form-label">One day Service</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="service<?php echo $i; ?>" id="service<?php echo $i; ?>" onchange="enableService(<?php echo $i; ?>)" <?php echo $sv_check; ?> />
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="sv_price<?php echo $i; ?>" id="sv_price<?php echo $i; ?>" onkeypress="return isNumberKeyn(event);" onchange="calculateSubTotal()" style="text-align: right;" <?php echo $sv_read; ?> />
												<span class="error_msg" id="svc_error<?php echo $i; ?>" ></span>
											</div>
										</div>

										<?php $i++; } ?>
										<input type="hidden" name="num_rows" id="num_rows" value="<?php echo $i-1; ?>" />
										
										<div class="row">
											<div class="col-12">
												&nbsp;
											</div>
										</div>

										<div class="row">
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
												<input type="checkbox" name="disc_st" id="disc_st" onchange="enableDiscount()" />&nbsp;&nbsp;&nbsp;
												<input type="text" class="form-control" name="disc_per" id="disc_per" onkeypress="return isNumberKeyn(event);" onchange="calculateTotal()" style="text-align: right; width: 50%" readonly />&nbsp;%
											</div>
												<span class="error_msg" id="disc_error" ></span>
											</div>
											<div class="col-lg-2 mb-3">
												<label class="form-label">Discount (Rs.)</label>
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="discount" id="discount" style="text-align: right;" readonly />
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

	function calculateAmount(){
		var uprice = parseFloat(document.getElementById("uprice").value);
		var qty = parseFloat(document.getElementById("qty").value);

		var amount = uprice*qty;

		document.getElementById("amount").value = format_number(amount, 2);
		calculateTotal();
	}

	function enableArtwork(i){
		if(document.getElementById("artwork"+i).checked == true){
			document.getElementById("aw_price"+i).readOnly = false;
		} else {
			document.getElementById("aw_price"+i).readOnly = true;
			document.getElementById("aw_price"+i).value = '0.00';
			calculateSubTotal();
		}
	}
	
	function enableService(i){
		if(document.getElementById("service"+i).checked == true){
			document.getElementById("sv_price"+i).readOnly = false;
		} else {
			document.getElementById("sv_price"+i).readOnly = true;
			document.getElementById("sv_price"+i).value = '0.00';
			calculateSubTotal();
		}
	}
	
	function enableDiscount(){
		if(document.getElementById("disc_st").checked == true){
			document.getElementById("disc_per").readOnly = false;
		} else {
			document.getElementById("disc_per").readOnly = true;
			document.getElementById("disc_per").value = '0';
			calculateTotal()
		}
	}

	function calculateSubTotal(){

		var num_rows = document.getElementById("num_rows").value;

		var subtotal = 0;
		for(i=1; i<=num_rows; i++){
			var amount = parseFloat(document.getElementById("amount"+i).value);

			if(document.getElementById("artwork"+i).checked == true){
				if(isNaN(parseFloat(document.getElementById("aw_price"+i).value))){
					var aw_price = 0;
				} else {
					var aw_price = parseFloat(document.getElementById("aw_price"+i).value);
				}
			} else {
				var aw_price = 0;
			}
			
			if(document.getElementById("service"+i).checked == true){
				if(isNaN(parseFloat(document.getElementById("sv_price"+i).value))){
					var sv_price = 0;
				} else {
					var sv_price = parseFloat(document.getElementById("sv_price"+i).value);
				}
			} else {
				var sv_price = 0;
			}
			
			var tot = amount + aw_price + sv_price;
			subtotal += tot;
		}

		document.getElementById("subtotal").value = format_number(subtotal, 2);
		calculateTotal();
	}

	function calculateTotal(){
		var subtotal = parseFloat(document.getElementById("subtotal").value);

		if(document.getElementById("disc_st").checked == true){
			var disc_per = parseFloat(document.getElementById("disc_per").value);
		} else {
			var disc_per = 0;
		}

		var discount = parseFloat(subtotal*disc_per/100);
		document.getElementById("discount").value = format_number(discount, 2);

		var total = parseFloat(subtotal-discount);
		document.getElementById("total").value = format_number(total, 2);
	}

	</script>

	<script>
		function validateForm() {
		  var prevent = '';
		
		  let sales_ex = document.forms["quotation_form"]["sales_ex"].value;
		  if (sales_ex == "") {
			document.getElementById("sales_error").innerHTML = "Sales executive should be selected";
			document.getElementById("sales_ex").className  = "form-select error";
			prevent = 'yes';
		  } else {
			document.getElementById("sales_error").innerHTML = "";
			document.getElementById("sales_ex").className  = "form-select";
		  }

		  num_rows = document.getElementById("num_rows").value;

		  for(i=1; i<=num_rows; i++){
		  if(document.getElementById("artwork"+i).checked == true){
		  let aw_price = document.forms["quotation_form"]["aw_price"+i].value;
		  if (aw_price == "") {
			document.getElementById("awp_error"+i).innerHTML = "Artwork price should be filled out";
			document.getElementById("aw_price"+i).className  = "form-control error";
			prevent = 'yes';
		  } else {
			document.getElementById("awp_error"+i).innerHTML = "";
			document.getElementById("aw_price"+i).className  = "form-control";
		  }
		  } else {
			document.getElementById("awp_error"+i).innerHTML = "";
			document.getElementById("aw_price"+i).className  = "form-control";
		  }

		  if(document.getElementById("service"+i).checked == true){
		  let sv_price = document.forms["quotation_form"]["sv_price"+i].value;
		  if (sv_price == "") {
			document.getElementById("svc_error"+i).innerHTML = "Oneday service price should be filled out";
			document.getElementById("sv_price"+i).className  = "form-control error";
			prevent = 'yes';
		  } else {
			document.getElementById("svc_error"+i).innerHTML = "";
			document.getElementById("sv_price"+i).className  = "form-control";
		  }
		  } else {
			document.getElementById("svc_error"+i).innerHTML = "";
			document.getElementById("sv_price"+i).className  = "form-control";
		  }
		  }

		  if(document.getElementById("disc_st").checked == true){
		  let disc_per = document.forms["quotation_form"]["disc_per"].value;
		  if (disc_per == "") {
			document.getElementById("disc_error").innerHTML = "Required";
			document.getElementById("disc_per").className  = "form-control error";
			prevent = 'yes';
		  } else if (disc_per > 100) {
			document.getElementById("disc_error").innerHTML = "Invalid %";
			document.getElementById("disc_per").className  = "form-control error";
			prevent = 'yes';
		  } else {
			document.getElementById("disc_error").innerHTML = "";
			document.getElementById("disc_per").className  = "form-control";
		  }
		  } else {
			document.getElementById("disc_error").innerHTML = "";
			document.getElementById("disc_per").className  = "form-control";
		  }
		  
		  if(prevent == 'yes'){
			  return false;
		  }
		}
  
	</script>

</body>

</html>
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

					<h1 class="h3 mb-3">Delivery Note</h1>
				

<?php
//Set time zone
$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$cur_date = $createToday->format('Y-m-d');

$iid = $_GET['iid'];
$select_inv = mysqli_query($con, "SELECT * FROM invoice WHERE id = '$iid'");
$result_inv = mysqli_fetch_array($select_inv);

$select_cust = mysqli_query($con, "SELECT title, name, last_name FROM customer WHERE id = '{$result_inv['cus_id']}'");
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

									<form name="delivery_form" method="post" action="create_delivery_submit.php" onsubmit="return validateForm()" >
										<div class="row">
											<div class="col-lg-2 col-xs-6 mb-3">
												<label class="form-label">Delivery Date</label>
												<input type="text" class="form-control flatpickr-minimum flatpickr-input" name="del_date" id="del_date" value="<?php echo $cur_date; ?>" readonly />
												<span class="error_msg" id="date_error" ></span>
											</div>
											<div class="col-lg-3 col-sm-12 mb-5">
												<label class="form-label">Invoice No.</label>
												<input type="text" class="form-control" name="inv_no" id="inv_no" value="<?php echo $result_inv['invoice_no']; ?>" readonly />
												<input type="hidden" class="form-control" name="inv_id" id="inv_id" value="<?php echo $result_inv['id']; ?>" />
											</div>
											<div class="col-lg-4 col-sm-12 mb-3">
												<label class="form-label">Customer</label>
												<input type="text" class="form-control" name="customer" id="customer" value="<?php echo $cusname; ?>" readonly />
												<input type="hidden" class="form-control" name="cust_id" id="cust_id" value="<?php echo $result_inv['cus_id']; ?>" />
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
												<label class="form-label">Quantity</label>
											</div>
											<div class="col-lg-4">
												<label class="form-label">Packing</label>
											</div>
										</div>
										
										<?php
										$i=1;
										$select_invitm = mysqli_query($con, "SELECT * FROM invoice_details WHERE invoice_id = '$iid'");
										while($result_invitm = mysqli_fetch_array($select_invitm)){

										$select_jobitm = mysqli_query($con, "SELECT * FROM jobcard_details WHERE id = '{$result_invitm['jitm_id']}'");
										$result_jobitm = mysqli_fetch_array($select_jobitm);
										
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
                        
										if($result_quotitm['service_status'] == 'yes' && $result_jobitm['service_inv'] == 'no'){		//One day
											$sv_price = $result_quotitm['service'];
										} else {											//Standard
											$sv_price = "0.00";
										}
										
										?>

										<div class="row" style="margin-top: 10px;">
											<div class="col-lg-1 mb-3">
												<?php echo $i; ?>
											</div>
											<div class="col-lg-5 mb-3">
												<b><?php echo htmlspecialchars($result_product['name']); ?></b><br/>
												<?php echo $description; ?>
												<input type="hidden" name="prod_id<?php echo $i; ?>" id="prod_id<?php echo $i; ?>" value="<?php echo $result_invitm['prod_id']; ?>" />
												<input type="hidden" name="row_id<?php echo $i; ?>" id="row_id<?php echo $i; ?>" value="<?php echo $result_invitm['id']; ?>" />
											</div>
											<div class="col-lg-2 mb-3">
												<input type="text" class="form-control" name="qty<?php echo $i; ?>" id="qty<?php echo $i; ?>" value="<?php echo $result_invitm['qty']; ?>" readonly />
											</div>
											<div class="col-lg-4 mb-3">
												<input type="text" class="form-control" name="packing<?php echo $i; ?>" id="packing<?php echo $i; ?>" />
												<span class="error_msg" id="pack_error<?php echo $i; ?>" ></span>
											</div>
										</div>
										
										<?php $i++; } ?>
										<input type="hidden" name="num_rows" id="num_rows" value="<?php echo $i-1; ?>" />
										
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

	</script>

	<script>
		function validateForm() {
		  var prevent = '';
		  
		  let del_date = document.forms["delivery_form"]["del_date"].value;
		  if (del_date == "") {
			document.getElementById("date_error").innerHTML = "Date must be selected";
			document.getElementById("del_date").className  = "form-control error";
			prevent = 'yes';
		  } else {
			document.getElementById("date_error").innerHTML = "";
			document.getElementById("del_date").className  = "form-control";
		  }
  
		  num_rows = document.getElementById("num_rows").value;

		  for(i=1; i<=num_rows; i++){
		  let packing = document.forms["delivery_form"]["packing"+i].value;
		  if (packing == "") {
			document.getElementById("pack_error"+i).innerHTML = "Packing should be filled";
			document.getElementById("packing"+i).className  = "form-control error";
			prevent = 'yes';
		  } else {
			document.getElementById("pack_error"+i).innerHTML = "";
			document.getElementById("packing"+i).className  = "form-control";
		  }
		  }
		  
		  if(prevent == 'yes'){
			  return false;
		  }
		}
  
	</script>

</body>

</html>
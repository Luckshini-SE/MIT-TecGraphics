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
					<h1 class="h3 mb-3 col-10">Request for Quotation</h1>
					<div class="col-2" align="right"><a href="customer_request_list.php"><button class="btn btn-warning">View List</button></a></div>
					</div>


<?php
//Set time zone
$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$cur_date = $createToday->format('Y-m-d');

?>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form name="request_form" method="post" action="customer_request_submit.php" onsubmit="return validateForm()" >
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
										<div class="row mb-3">
											<div class="col-lg-2 col-xs-6 mb-3">
												<label class="form-label">Request Date</label>
												<input type="text" class="form-control" name="req_date" id="req_date" value="<?php echo $cur_date; ?>" readonly />
												<span class="error_msg" id="date_error" ></span>
											</div>
											<div class="col-lg-4 col-sm-12 mb-3">
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
										</div>

										<div class="row mb-3">
											<div class="col-lg-3 col-xs-6 mb-3">
												<input type="button" class="btn btn-primary" name="addmore" id="addmore" value="Add product" onclick="open_modal()" />
											</div>
										</div>
										
										<div id="ex_products"></div>

										<div class="row">
											<div class="col-lg-2 mb-3">
												<input type="submit" class="btn btn-success" name="submit" id="submit" value="Save" />
											</div>
											<span class="error_msg" id="tot_error" ></span>
										</div>

									</form>
								</div>

								<!-- Modal -->
									<div class="modal fade" id="productDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">Add Product</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<form name="modal_form" id="modal_form" onsubmit="validateModalForm(); return false;">
												<div class="modal-body m-3">
													
													<div class="row mb-3">
														<input type="hidden" name="cus_id" id="cus_id" />
														<div class="col-lg-6 col-sm-12 mb-3">
															<label class="form-label">Product <span style="color:red">*</span></label>
															<select class="form-select" name="product" id="product" onchange="get_details()" >
																<option value="">-Please Select-</option>
																<?php
																$select_pro = mysqli_query($con, "SELECT id, name FROM products ORDER BY name");
																while($result_pro = mysqli_fetch_array($select_pro)){
																?>
																<option value="<?php echo $result_pro['id']; ?>"><?php echo $result_pro['name']; ?></option>
																<?php } ?>
															</select>
															<span class="error_msg" id="product_error" ></span>
														</div>
													</div>

													<div id="detail_div"></div>

													<div id="query_div"></div>
													
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
													<button type="submit" class="btn btn-primary">Save changes</button>
												</div>
												</form>
											</div>
										</div>
									</div>
									<!-- Modal -->
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

	function open_modal(){
		var customer = document.getElementById('customer').value;

		if(customer != ''){
			document.getElementById("cus_error").innerHTML = '';
			document.getElementById("cus_id").value = customer;
			$('#productDetailModal').modal('show');
		} else {
			document.getElementById("cus_error").innerHTML = 'Select customer';
		}
		
	}

	function get_details(){
		var product = document.getElementById('product').value;
		
		const xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("detail_div").innerHTML = this.responseText;
			}
		};
		xhttp.open("GET", "get_product_form.php?product="+product);
		xhttp.send();
	}

	function validateModalForm(){
		var prevent2 = '';

  let product = document.forms["modal_form"]["product"].value;
  if (product == "") {
	document.getElementById("product_error").innerHTML = "Product must be selected";
	document.getElementById("product").className  = "form-select error";
	prevent2 = 'yes';
  } else {
	document.getElementById("product_error").innerHTML = "";
	document.getElementById("product").className  = "form-select";
  }
  
  if (document.forms["modal_form"]["quantity"] != undefined) {			//check whether fields are present

  let quantity = document.forms["modal_form"]["quantity"].value;
  if (quantity == "") {
	document.getElementById("quantity_error").innerHTML = "Quantity must be filled";
	document.getElementById("quantity").className  = "form-control error";
	prevent2 = 'yes';
  } else {
	document.getElementById("quantity_error").innerHTML = "";
	document.getElementById("quantity").className  = "form-control";
  }

  let price_para = document.forms["modal_form"]["price_para"].value;
  if (price_para != 1) {
  let width = document.forms["modal_form"]["width"].value;
  if (width == "") {
	document.getElementById("wd_error").innerHTML = "Width must be filled";
	document.getElementById("width").className  = "form-control error";
	prevent2 = 'yes';
  } else {
	document.getElementById("wd_error").innerHTML = "";
	document.getElementById("width").className  = "form-control";
  }

  let height = document.forms["modal_form"]["height"].value;
  if (height == "") {
	document.getElementById("ht_error").innerHTML = "Height must be filled";
	document.getElementById("height").className  = "form-control error";
	prevent2 = 'yes';
  } else {
	document.getElementById("ht_error").innerHTML = "";
	document.getElementById("height").className  = "form-control";
  }
  }

  }
  
  if(prevent2 == 'yes'){
	  return false;
  } else {
      submitAlForm();
  }
	}

	function submitAlForm(){
		var formData = $('#modal_form').serialize();

		$.ajax({
		  type: "POST",
		  url: "product_form_submit.php",
		  data: formData,
		  dataType: "json",
		  encode: true,
		}).done(function (data) {
			//location.reload();
			//console.log("AJAX request successful");
			$('#productDetailModal').modal('hide');
			$('#modal_form')[0].reset();
			document.getElementById("detail_div").innerHTML = '';
			load_added_products();
		}).error(function(xhr, status, error) {
			console.error("AJAX request failed:", error);
		});
		
	}

	function load_added_products(){
		var cust = document.getElementById("customer").value;
		document.getElementById("ex_products").innerHTML = '';

		const xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("ex_products").innerHTML = this.responseText;
			}
		};
		xhttp.open("GET", "get_added_products.php?cus_id="+cust);
		xhttp.send();
	}

	function deleteRow(a){
		var rowid = document.getElementById("rowid"+a).value;
		
		const xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("query_div").innerHTML = this.responseText;
				load_added_products();
			}
		};
		xhttp.open("GET", "remove_req_product.php?rowid="+rowid);
		xhttp.send();
	}

	</script>

	<script>
		function validateForm() {
		  var prevent = '';
		  
		  let req_date = document.forms["request_form"]["req_date"].value;
		  if (req_date == "") {
			document.getElementById("date_error").innerHTML = "Date must be selected";
			document.getElementById("req_date").className  = "form-control error";
			prevent = 'yes';
		  } else {
			document.getElementById("date_error").innerHTML = "";
			document.getElementById("req_date").className  = "form-control";
		  }

		  let customer = document.forms["request_form"]["customer"].value;
		  if (customer == "") {
			document.getElementById("cus_error").innerHTML = "Customer must be selected";
			document.getElementById("customer").className  = "form-select error";
			prevent = 'yes';
		  } else {
			document.getElementById("cus_error").innerHTML = "";
			document.getElementById("customer").className  = "form-select";
		  }
			
		  if (document.getElementById("ex_products").innerHTML == "") {				//check whether products are selected
			document.getElementById("tot_error").innerHTML = "There should be atleast one item selected.";
			prevent = 'yes';
		  } else {
			document.getElementById("tot_error").innerHTML = "";
		  }

		  if(prevent == 'yes'){
			  return false;
		  }
		}
  
	</script>
	
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/jquery.min.js"></script>
  
</body>

</html>
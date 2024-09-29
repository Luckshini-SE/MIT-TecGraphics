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

					<h1 class="h3 mb-3">Jobcard</h1>
				

<?php
//Set time zone
$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$cur_date = $createToday->format('Y-m-d');

$qid = $_GET['qid'];
$select_req = mysqli_query($con, "SELECT * FROM quotation WHERE id = '$qid'");
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

									<form name="jobcard_form" method="post" action="create_jobcard_submit.php" onsubmit="return validateForm()" >
										<div class="row form-group">
											<div class="col-lg-2 col-xs-6 mb-3">
												<label class="form-label">Job Date</label>
												<input type="text" class="form-control flatpickr-minimum flatpickr-input" name="job_date" id="job_date" value="<?php echo $cur_date; ?>" readonly />
											</div>
											<div class="col-lg-3 col-sm-12 mb-5">
												<label class="form-label">Quotation No.</label>
												<input type="text" class="form-control" name="quot_no" id="quot_no" value="<?php echo $result_req['q_no']; ?>" readonly />
												<input type="hidden" class="form-control" name="quot_id" id="quot_id" value="<?php echo $result_req['id']; ?>" />
											</div>
											<div class="col-lg-4 col-sm-12 mb-3">
												<label class="form-label">Customer</label>
												<input type="text" class="form-control" name="customer" id="customer" value="<?php echo $cusname; ?>" readonly />
												<input type="hidden" class="form-control" name="cust_id" id="cust_id" value="<?php echo $result_req['cus_id']; ?>" />
											</div>
										</div>

										<div class="row form-group  mb-5">
											<table class="table table-bordered">
												<thead>
													<tr>
														<th>Product</th>
														<th>Description</th>
														<th>Quantity</th>
													</tr>
												</thead>
												<tbody>
										<?php
										$i=1;
										$select_quotitm = mysqli_query($con, "SELECT * FROM quotation_details WHERE quot_id = '{$result_req['id']}'");
										while($result_quotitm = mysqli_fetch_array($select_quotitm)){

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
                        
										if($result_quotitm['artwork_status'] == 'yes'){
											$aw_check = "checked";
											$aw_read = "";
											$aw_price = $result_quotitm['artwork'];
										} else {
											$aw_check = "";
											$aw_read = "readonly";
											$aw_price = "";
										}
										
										if($result_quotitm['service_status'] == 'yes'){		//One day
											$sv_check = "checked";
											$sv_read = "";
											$sv_price = $result_quotitm['service'];
										} else {											//Standard
											$sv_check = "";
											$sv_read = "readonly";
											$sv_price = "";
										}

										if($result_req['dis_per'] != '' && $result_req['dis_per'] != 0){
											$dis_check = "checked";
											$dis_read = "";
											$dis_per = $result_req['dis_per'];
											$discount = $result_req['discount'];
										} else {
											$dis_check = "";
											$dis_read = "readonly";
											$dis_per = "";
											$discount = "";
										}
										
										?>

													<tr>
														<td><?php echo htmlspecialchars($result_product['name']); ?><input type="hidden" name="prod_id<?php echo $i; ?>" id="prod_id<?php echo $i; ?>" value="<?php echo $result_quotitm['prod_id']; ?>" /></td>
														<td><?php echo $description; ?><input type="hidden" name="row_id<?php echo $i; ?>" id="row_id<?php echo $i; ?>" value="<?php echo $result_quotitm['id']; ?>" /></td>
														<td align="center"><?php echo $result_quotitm['qty']; ?><input type="hidden" class="form-control" name="qty<?php echo $i; ?>" id="qty<?php echo $i; ?>" value="<?php echo $result_quotitm['qty']; ?>" readonly /></td>
													</tr>

										<?php $i++; } ?>
										<input type="hidden" name="num_rows" id="num_rows" value="<?php echo $i-1; ?>" />
												</tbody>
											</table>
										</div>
										
										<div class="row form-group">
											<h4>Required Material</h4>
											
												<div class="col-lg-4 mb-3">
													<label class="form-label">Material <span style="color:red">*</span></label>
													<input type="text" class="form-control" name="item1" id="item1" onclick="browseList('1')" readonly />
													<input type="hidden" class="form-control" name="itemid1" id="itemid1" />
												</div>
												<div class="col-lg-2 mb-3">
													<label class="form-label">Qty <span style="color:red">*</span></label>
													<input type="text" class="form-control" name="iqty1" id="iqty1" onkeypress="return isNumberKeyn(event);" />
													<span style="color:blue;" id="uom1"></span>
												</div>
												<div class="col-lg-2 mb-3">&nbsp;</div>
												<div class="col-lg-4 mb-3">
													<label class="form-label">Machine <span style="color:red">*</span></label>
													<select class="form-select" name="machine" id="machine" >
														<option value="">-Please Select-</option>
														<?php
														$select_mach = mysqli_query($con, "SELECT id, name FROM machine ORDER BY name");
														while($result_mach = mysqli_fetch_array($select_mach)){
														?>
														<option value="<?php echo $result_mach['id']; ?>"><?php echo $result_mach['name']; ?></option>
														<?php } ?>
													</select>
													<span class="error_msg" id="mach_error" ></span>
												</div>
											
											
											<div id="add_div"></div>

											<input type="hidden" name="mat_num_rows" id="mat_num_rows" value="1" >

											<div class="mb-3">
												<input type="button" class="btn btn-primary" value="Add More" onclick="add_more()" >
											</div>

										</div>

										<div class="row form-group">
											<div class="col-lg-12 mb-3">
												<label class="form-label">Special Instructions</label>
												<textarea class="form-control" name="instr" id="instr"></textarea>
											</div>
										</div>
										
										<div class="row form-group">
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

	function browseList(i){
		window.open("select_rawmaterial.php?row="+i,"_blank","width=500,height=400");
	}
	
	function add_more(){

		var item = new Array();
		var itemid = new Array();
		var iqty = new Array();
		var uom = new Array();
	
		int_num_rows = parseInt(document.getElementById("mat_num_rows").value);
		total_rows = int_num_rows+1;
	
		for(i=2; i<total_rows; i++){
			item[i]	= document.getElementById("item"+i).value;
			itemid[i]	= document.getElementById("itemid"+i).value;
			iqty[i]	= document.getElementById("iqty"+i).value;
			uom[i]	= document.getElementById("uom"+i).innerHTML;
		}
	
		document.getElementById("add_div").innerHTML = "";
		main_tab = '';
	
		for (i=2; i<=total_rows; i++) {
			if (i == total_rows) {
			
				main_tab += '<div class="row form-group">';
				main_tab += '<div class="col-lg-4 mb-3">';
				main_tab += '<input class="form-control" id="item'+i+'" name="item'+i+'" type="text" readonly onclick="browseList('+i+')" /><input class="form-control" id="itemid'+i+'" name="itemid'+i+'" type="hidden" /></div>';
				main_tab += '<div class="col-lg-2 mb-3">';
				main_tab += '<input class="form-control" type="text" name="iqty'+i+'" id="iqty'+i+'" onkeypress="return isNumberKeyn(event);" /><span style="color:blue;" id="uom'+i+'"></span></div>';
				main_tab += '<div class="col-lg-1 mb-3">';
				main_tab += '<input type="button" name="button'+i+'" id="button'+i+'" value="Delete" class="btn btn-danger" onclick="deleteContactPerson('+i+')" /></div>';
				main_tab += '</div>';
		    
			} else {
			
				main_tab += '<div class="row form-group">';
				main_tab += '<div class="col-lg-4 mb-3">';
				main_tab += '<input class="form-control" id="item'+i+'" name="item'+i+'" type="text" readonly onclick="browseList('+i+')" value=\"'+item[i]+'\" /><input class="form-control" id="itemid'+i+'" name="itemid'+i+'" type="hidden" value=\"'+itemid[i]+'\" /></div>';
				main_tab += '<div class="col-lg-2 mb-3">';
				main_tab += '<input class="form-control" type="text" name="iqty'+i+'" id="iqty'+i+'" value=\"'+iqty[i]+'\" onkeypress="return isNumberKeyn(event);" /><span style="color:blue;" id="uom'+i+'">'+uom[i]+'</span></div>';
				main_tab += '<div class="col-lg-1 mb-3">';
				main_tab += '<input type="button" name="button'+i+'" id="button'+i+'" value="Delete" class="btn btn-danger" onclick="deleteContactPerson('+i+')" /></div>';
				main_tab += '</div>';

			}
		}
	
		document.getElementById("add_div").innerHTML = main_tab;
		document.getElementById("mat_num_rows").value = total_rows;
	}
	// End of Ad Row


	// Delete Row
	function deleteContactPerson(row) { 
	
		var item = new Array();
		var itemid = new Array();
		var iqty = new Array();
		var uom = new Array();
	
		int_num_rows = parseInt(document.getElementById("mat_num_rows").value);
		row = parseInt(row);
		k = 2;
		m = k;
	
		for (; k<=int_num_rows; k++) {
			if (k == row) {			
			}
			else {		
				item[m]	= document.getElementById("item"+k).value
				itemid[m]	= document.getElementById("itemid"+k).value;
				iqty[m]	= document.getElementById("iqty"+k).value;
				uom[m]	= document.getElementById("uom"+k).innerHTML;
				m++;
			}
		}
	
		document.getElementById("add_div").innerHTML = "";
		main_tab = '';
	
		i = 2;
		j = i;
		for (; i<=int_num_rows; i++) {
			if (i == row) { 
			}
			else {
			
				main_tab += '<div class="row form-group">';
				main_tab += '<div class="col-lg-4 mb-3">';
				main_tab += '<input type="text" name="item'+j+'" id="item'+j+'" class="form-control" readonly value=\"'+item[j]+'\" onclick="browseList('+j+')" /><input type="hidden" name="itemid'+j+'" id="itemid'+j+'" class="form-control" style="width:100%" value=\"'+itemid[j]+'\" /></div>';
				main_tab += '<div class="col-lg-2 mb-3">';
				main_tab += '<input type="text" name="iqty'+j+'" id="iqty'+j+'" class="form-control" value=\"'+iqty[j]+'\" onkeypress="return isNumberKeyn(event);" /><span style="color:blue;" id="uom'+j+'">'+uom[j]+'</span></div>';
				main_tab += '<div class="col-lg-1 mb-3">';
				main_tab += '<input type="button" name="button'+j+'" id="button'+j+'" value="Delete" class="btn btn-danger" onclick="deleteContactPerson('+j+')" /></div>';
				main_tab += '</div>'; 
			
				j++;
			}
		}
	
		document.getElementById("add_div").innerHTML = main_tab;
		document.getElementById("mat_num_rows").value = int_num_rows-1;
	
	}
	// End of Delete Row


	</script>

	<script>
		function validateForm() {
		  var prevent = '';
		  
  let machine = document.forms["jobcard_form"]["machine"].value;
  if (machine == "") {
	document.getElementById("mach_error").innerHTML = "Machine must be selected";
	document.getElementById("machine").className  = "form-select error";
	prevent = 'yes';
  } else {
	document.getElementById("mach_error").innerHTML = "";
	document.getElementById("machine").className  = "form-select";
  }

  let mat_rows = document.getElementById("mat_num_rows").value;

	for(i=1; i<=mat_rows; i++){
		let item = document.forms["jobcard_form"]["item"+i].value;
		if (item == "") {
			document.getElementById("item"+i).className  = "form-control error";
			prevent = 'yes';
		} else {
			document.getElementById("item"+i).className  = "form-control";
		}

		let iqty = document.forms["jobcard_form"]["iqty"+i].value;
		if (iqty == "") {
			document.getElementById("iqty"+i).className  = "form-control error";
			prevent = 'yes';
		} else {
			document.getElementById("iqty"+i).className  = "form-control";
		}
	}
  
		  if(prevent == 'yes'){
			  return false;
		  }
		}
  
	</script>

</body>

</html>
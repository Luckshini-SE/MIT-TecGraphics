<?php
include('db_connection.php');

$jobno = $_GET['jobno'];

$select_job = mysqli_query($con, "SELECT * FROM jobcard WHERE jobno = '$jobno'");
$result_job = mysqli_fetch_array($select_job);

	$select_cust = mysqli_query($con, "SELECT title, name, last_name FROM customer WHERE id = '{$result_job['cus_id']}'");
	$result_cust = mysqli_fetch_array($select_cust);

	$select_tit = mysqli_query($con, "SELECT title FROM title WHERE id = '{$result_cust['title']}'");
	$result_tit = mysqli_fetch_array($select_tit);

	if($result_tit['title'] == 'Other'){
		$cusname = $result_cust['name'].' '.$result_cust['last_name'];
	} else {
		$cusname = $result_tit['title'].'. '.$result_cust['name'].' '.$result_cust['last_name'];
	}
?>

<div class="row form-group mb-3">
	<div class="col-2 ">
		<label class="form-label">Job No.</label>
		<input type="text" class="form-control" name="jobno" id="jobno" value="<?php echo $result_job['jobno']; ?>" readonly >
	</div>
	<div class="col-3  mb-3">
		<label class="form-label">Job Date</label>
		<input type="text" class="form-control" name="jobdate" id="jobdate" value="<?php echo $result_job['job_date']; ?>" readonly >
	</div>
	<div class="col-4  mb-3">
		<label class="form-label">Customer</label>
		<input type="text" class="form-control" name="custname" id="custname" value="<?php echo $cusname; ?>" readonly >
		<input type="hidden" class="form-control" name="customer" id="customer" value="<?php echo $result_job['cus_id']; ?>" >
	</div>
</div>

<div class="row form-group mb-3">
	<div class="col-3">
		<label class="form-label">Product</label>
	</div>
	<div class="col-5">
		<label class="form-label">Descripton</label>
	</div>
	<div class="col-2">
		<label class="form-label">Order Qty</label>
	</div>
	<div class="col-2">
		<label class="form-label">&nbsp;</label>
	</div>
</div>

<?php
$i = 1;
$select_det = mysqli_query($con, "SELECT * FROM jobcard_details WHERE jobcard_id = '{$result_job['id']}'");
while($result_det = mysqli_fetch_array($select_det)){
	
	$select_item = mysqli_query($con, "SELECT name, pricing FROM products WHERE id = '{$result_det['prod_id']}'");
	$result_item = mysqli_fetch_array($select_item);
	
	if($result_item['pricing'] == 1){
		$measure = '';
	} else {
		$select_meas = mysqli_query($con, "SELECT measure FROM pricing WHERE id = '{$result_item['pricing']}'");
		$result_meas = mysqli_fetch_array($select_meas);	
		$measure = $result_meas['measure'];
	}

	$select_quotitm = mysqli_query($con, "SELECT * FROM quotation_details WHERE id = '{$result_det['qitm_id']}'");
	$result_quotitm = mysqli_fetch_array($select_quotitm);

	$select_reqitm = mysqli_query($con, "SELECT * FROM requests WHERE id = '{$result_quotitm['req_item_id']}'");
	$result_reqitm = mysqli_fetch_array($select_reqitm);

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
?>
<div class="row form-group mb-3">
	<div class="col-3 mb-3">
		<input type="text" class="form-control" value="<?php echo $result_item['name']; ?>" readonly >
	</div>
	<div class="col-5 mb-3">
		<input type="text" class="form-control" value="<?php echo $description; ?>" readonly >
	</div>
	<div class="col-2 mb-3">
		<input type="text" class="form-control" value="<?php echo $result_det['qty']; ?>" readonly >
	</div>
	<div class="col-1 mb-3">
		&nbsp;
	</div>
</div>
<?php $i++; } ?>
<hr/>

										<div class="row form-group mb-3">
											<div class="col-5 mb-3">
												<label class="form-label">Raw Material <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="item1" id="item1" placeholder="Raw Material" onclick="browseList(1)" readonly >
												<input type="hidden" class="form-control" name="itemid1" id="itemid1" >
											</div>
											<div class="col-2 mb-3">
												<label class="form-label">Available</label>
												<input type="text" class="form-control" name="ava1" id="ava1" placeholder="Available" readonly >
											</div>
											<div class="col-2 mb-3">
												<label class="form-label">Qty</label>
												<input type="text" class="form-control" name="qty1" id="qty1" placeholder="Qty" onkeypress="return isNumberKeyn(event);" onchange="chkava(1)" >
											</div>
										</div>
										
										<div id="item_div2"></div>

										<input type="hidden" name="num_rows" id="num_rows" value="1" >

										<div class="mb-3">
											<input type="button" class="btn btn-primary" value="Add More" onclick="add_more()" >
										</div>
										

<div class="row form-group mb-3">
	<div class="col-9 mb-3">
		<input type="submit" class="btn btn-success" name="submit" id="submit" value="Submit" >
	</div>
</div>
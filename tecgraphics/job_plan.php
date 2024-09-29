<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('header.php'); ?>
	<?php include('db_connection.php'); ?>
</head>

<body>
	<div class="wrapper">

	<?php include('sidebar.php'); ?>

		<div class="main">
			
		<?php include('topbar.php'); ?>

			<main class="content">
				<div class="container-fluid p-0">

					<div class="row">
					<h1 class="h3 mb-3 col-10">Job Plan</h1>
					<div class="col-2" align="right"><a href="jobcard_list.php"><button class="btn btn-warning">View List</button></a></div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
								
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

									<?php
									if($_SESSION["logUserType"] == 1 || $_SESSION["logUserType"] == 5){		//display all for admin and manager user types
										$select_quot = mysqli_query($con, "SELECT * FROM quotation WHERE confirm = 'yes' AND jobcard = 'no'");
									} else {
										$select_quot = mysqli_query($con, "SELECT * FROM quotation WHERE confirm = 'yes' AND jobcard = 'no' AND job_user = '{$_SESSION["logUserId"]}'");
									}
									
									if(mysqli_num_rows($select_quot) > 0){
									?>

									<table class="table table-bordered" >
										<thead>
										<tr>
											<th>No</th>
											<th>Customer</th>
											<th>Product</th>
											<th>Unallocated</th>
											<th>Allocated</th>
										</tr>
										</thead>
										<tbody>
										<?php
										$i=1;
										while($result_quot = mysqli_fetch_array($select_quot)){

											$select_cus = mysqli_query($con, "SELECT * FROM customer WHERE id = '{$result_quot['cus_id']}'");
											$result_cus = mysqli_fetch_array($select_cus);

											if($result_cus['ctype'] == 'c'){
												$customer = $result_cus['name'];
											} else {

												$select_tit = mysqli_query($con, "SELECT title FROM title WHERE id = '{$result_cus['title']}'");
												$result_tit = mysqli_fetch_array($select_tit);
												$title = $result_tit['title'];

												$customer = $title.'.'.$result_cus['name'].' '.$result_cus['last_name'];
											}

											$item_details = '';
											$select_items = mysqli_query($con, "SELECT * FROM quotation_details WHERE quot_id = '{$result_quot['id']}'");
											while($result_items = mysqli_fetch_array($select_items)){
												$select_prod = mysqli_query($con, "SELECT name FROM products WHERE id = '{$result_items['prod_id']}'");
												$result_prod = mysqli_fetch_array($select_prod);

												if($result_items['service_status']!='yes'){
													$servicest = '';
												} else {
													$servicest = '<span style="height: 7px;width: 7px;background-color: red;border-radius: 50%;display: inline-block;margin-top:5px;"></span>';
												}

												$item_details .= '<div style="display:flex"><div style="width:70%">'.$result_prod['name'].'</div><div style="width:25%">'.$result_items['qty'].' Nos.</div><div style="width:5%">'.$servicest.'</div></div>';
											}

											$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
											$curr_date = $createToday->format('Y-m-d');
											$date1 = strtotime($curr_date);
											$date2 = strtotime(substr($result_quot['conf_datetime'],0,10));
											
											if($result_quot['job_alloc'] == 'no'){			//if job is not allocated to coordinator
												$diff = $date1 - $date2;
												$days = floor($diff / (60 * 60 * 24));

												if($_SESSION["logUserType"] == '1' || $_SESSION["logUserType"] == '5'){		//only admin and manager can allocate job to coordinator
													$job_unall = '<span class="badge bg-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#centeredModalPrimary" onclick="send_row('.$i.')" >'.$days.'</span>';
												} else {
													$job_unall = '<span class="badge bg-primary rounded-pill" >'.$days.'</span>';
												}
													$job_all = '';
											} else {										//if job is allocated
												$job_unall = '';
												$date3 = strtotime(substr($result_quot['joball_datetime'],0,10));
												$diff = $date1 - $date3;
												$days = floor($diff / (60 * 60 * 24));

												$sel_co = mysqli_query($con, "SELECT first_name, last_name FROM users WHERE id = '{$result_quot['job_user']}'");
												$res_co = mysqli_fetch_array($sel_co);

												if($_SESSION["logUserId"] == $result_quot['job_user']){			//only allocated user can create jobcard
													$job_all = '<span class="badge bg-success" onclick="open_job('.$i.')">'.$res_co['first_name'].' '.$res_co['last_name'].' ['.$days.']</span><?php } ?>';
												} else {
													$job_all = '<span class="badge bg-success" >'.$res_co['first_name'].' '.$res_co['last_name'].' ['.$days.']</span><?php } ?>';
												}
												
											}

										?>
										<tr>
											<td><?php echo $result_quot['q_no']; ?><input type="hidden" name="tableid<?php echo $i; ?>" id="tableid<?php echo $i; ?>" value="<?php echo $result_quot['id']; ?>" /></td>
											<td><?php echo $customer; ?></td>
											<td><?php echo $item_details; ?></td>
											<td align="center"><?php echo $job_unall; ?></td>
											<td align="center"><?php echo $job_all; ?></td>
										</tr>
										<?php $i++; } ?>
										</tbody>
									</table>

									<?php
									} else {
										echo 'No records.';
									}
									?>

								</div>
									
									<!-- Modal -->
									<div class="modal fade" id="centeredModalPrimary" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">Allocate to coordinator</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<form id="allocate_form" onsubmit="submitAlForm(); return false;">
												<div class="modal-body m-3">
													
														<div class="col-lg-6 col-sm-12 mb-3">
															<label class="form-label">Coordinator</label>
															<input type="hidden" name="row_id" id="row_id" />
															<select class="form-select" name="coordi" id="coordi" required>
															<?php
															$sel_co = mysqli_query($con, "SELECT id, first_name, last_name FROM users WHERE user_type = '3'");
															while($res_co = mysqli_fetch_array($sel_co)){
															?>
															<option value="<?php echo $res_co['id']; ?>"><?php echo $res_co['first_name']; ?></option>
															<?php
															}
															?>
															</select>
														</div>
													
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

	function send_row(i){
		document.getElementById("row_id").value = document.getElementById("tableid"+i).value;
	}

	function submitAlForm(){
		var formData = {
          row_id: $("#row_id").val(),
          coordi: $("#coordi").val(),
        };

		$.ajax({
		  type: "POST",
		  url: "job_allocate_submit.php",
		  data: formData,
		  dataType: "json",
		  encode: true,
		}).done(function (data) {
			location. reload();
		});
	}

	function open_job(i){
		var tableid = document.getElementById("tableid"+i).value;
		window.location = "create_jobcard.php?qid="+tableid;
	}

	</script>
	
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/jquery.min.js"></script>
  
	
</body>

</html>
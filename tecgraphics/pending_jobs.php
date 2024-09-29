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
					<h1 class="h3 mb-3 col-10">Invoice</h1>
					<div class="col-2" align="right"><a href="invoice_list.php"><button class="btn btn-warning">View List</button></a></div>
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

									<form name="complete_form" method="post" action="complete_job_submit.php" onsubmit="return validateForm()" >

									<?php
									$select_job = mysqli_query($con, "SELECT * FROM jobcard_details GROUP BY jobcard_id HAVING CAST(completed_qty AS UNSIGNED) > CAST(invoiced_qty AS UNSIGNED)");
									if(mysqli_num_rows($select_job) > 0){
									?>
									
									<table class="table table-bordered" >
										<thead>
										<tr>
											<th>Job No</th>
											<th>Customer</th>
											<th>Details</th>
											<th>Status</th>
											<th>&nbsp;</th>
										</tr>
										</thead>
										<tbody>
										<?php
										$i=1;
										while($result_job = mysqli_fetch_array($select_job)){

											$select_jobno = mysqli_query($con, "SELECT * FROM jobcard WHERE id = '{$result_job['jobcard_id']}'");
											$result_jobno = mysqli_fetch_array($select_jobno);
										
											$select_cus = mysqli_query($con, "SELECT * FROM customer WHERE id = '{$result_jobno['cus_id']}'");
											$result_cus = mysqli_fetch_array($select_cus);

											if($result_cus['ctype'] == 'c'){
												$customer = $result_cus['name'];
											} else {

												$select_tit = mysqli_query($con, "SELECT title FROM title WHERE id = '{$result_cus['title']}'");
												$result_tit = mysqli_fetch_array($select_tit);
												$title = $result_tit['title'];

												$customer = $title.'.'.$result_cus['name'].' '.$result_cus['last_name'];
											}

											$details = '';
											$jstatus = 'Complete';
											$select_job_all = mysqli_query($con, "SELECT * FROM jobcard_details WHERE jobcard_id = '{$result_job['jobcard_id']}'");
											while($result_job_all = mysqli_fetch_array($select_job_all)){
											
											if($result_job_all['completed_qty'] > $result_job_all['invoiced_qty']){
												$select_prod = mysqli_query($con, "SELECT name FROM products WHERE id = '{$result_job_all['prod_id']}'");
												$result_prod = mysqli_fetch_array($select_prod);
												$rem_qty = $result_job_all['completed_qty']-$result_job_all['invoiced_qty'];

												$select_items = mysqli_query($con, "SELECT service_status FROM quotation_details WHERE id = '{$result_job_all['qitm_id']}'");
												$result_items = mysqli_fetch_array($select_items);

												if($result_items['service_status']!='yes'){
													$servicest = '';
												} else {
													$servicest = '<span style="height: 7px;width: 7px;background-color: red;border-radius: 50%;display: inline-block;margin-top:5px;"></span>';
												}

												$details .= '<div style="display:flex"><div style="width:70%">'.$result_prod['name'].'</div><div style="width:25%">'.$rem_qty.' Nos.</div><div style="width:5%">'.$servicest.'</div></div>';
											}

											if($result_job_all['qty'] > $result_job_all['completed_qty']){
												$jstatus = 'Partial';
											}

											}

										?>
										<tr>
											<td><?php echo $result_jobno['jobno']; ?><input type="hidden" name="job_id<?php echo $i; ?>" id="job_id<?php echo $i; ?>" value="<?php echo $result_job['jobcard_id']; ?>" /></td>
											<td><?php echo $customer; ?></td>
											<td><?php echo $details; ?></td>
											<td><?php echo $jstatus; ?></td>
											<td width="12%"><input type="button" class="btn btn-success" name="invoice<?php echo $i; ?>" id="invoice<?php echo $i; ?>" value="Invoice" onclick="create_inv(<?php echo $i; ?>)" /></td>
										</tr>
										<?php $i++; } ?>
										<input type="hidden" name="num_rows" id="num_rows" value="<?php echo $i-1; ?>" />
										</tbody>
									</table>
									
									</form>

									<?php
									} else {
										echo 'No records.';
									}
									?>

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
	function create_inv(i){
		var jobid = document.getElementById("job_id"+i).value;
		window.location = "create_invoice.php?jid="+jobid;
	}
	</script>

</body>

</html>
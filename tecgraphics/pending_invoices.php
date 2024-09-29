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
					<h1 class="h3 mb-3 col-10">Delivery</h1>
					<div class="col-2" align="right"><a href="delivery_list.php"><button class="btn btn-warning">View List</button></a></div>
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

									<form name="complete_form" method="post" action="" onsubmit="return validateForm()" >

									<?php
									//$select_inv = mysqli_query($con, "SELECT * FROM invoice WHERE inv_type = 'jobcard' AND delivery = 'no'");
									$select_inv = mysqli_query($con, "SELECT i.* FROM invoice i, jobcard j WHERE i.jobcard_id = j.id AND i.inv_type = 'jobcard' AND i.delivery = 'no' AND j.log_user = '{$_SESSION["logUserId"]}'");
									if(mysqli_num_rows($select_inv) > 0){
									?>
									
									<table class="table table-bordered" >
										<thead>
										<tr>
											<th>Invoice No</th>
											<th>Invoice Date</th>
											<th>Customer</th>
											<th>Details</th>
											<th>&nbsp;</th>
										</tr>
										</thead>
										<tbody>
										<?php
										$i=1;
										while($result_inv = mysqli_fetch_array($select_inv)){

											$select_cus = mysqli_query($con, "SELECT * FROM customer WHERE id = '{$result_inv['cus_id']}'");
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
											$sel_details = mysqli_query($con, "SELECT * FROM invoice_details WHERE invoice_id = '{$result_inv['id']}'");
											while($res_details = mysqli_fetch_array($sel_details)){
												
												$select_prod = mysqli_query($con, "SELECT name FROM products WHERE id = '{$res_details['prod_id']}'");
												$result_prod = mysqli_fetch_array($select_prod);
												
												$select_items = mysqli_query($con, "SELECT q.service_status FROM quotation_details q, jobcard_details j WHERE q.id = j.qitm_id AND j.id = '{$res_details['jitm_id']}'");
												$result_items = mysqli_fetch_array($select_items);

												if($result_items['service_status']!='yes'){
													$servicest = '';
												} else {
													$servicest = '<span style="height: 7px;width: 7px;background-color: red;border-radius: 50%;display: inline-block;margin-top:5px;"></span>';
												}

												$details .= '<div style="display:flex"><div style="width:70%">'.$result_prod['name'].'</div><div style="width:25%">'.$res_details['qty'].' Nos.</div><div style="width:5%">'.$servicest.'</div></div>';
											}


										?>
										<tr>
											<td><?php echo $result_inv['invoice_no']; ?><input type="hidden" name="inv_id<?php echo $i; ?>" id="inv_id<?php echo $i; ?>" value="<?php echo $result_inv['id']; ?>" /></td>
											<td><?php echo $result_inv['invoice_date']; ?></td>
											<td><?php echo $customer; ?></td>
											<td><?php echo $details; ?></td>
											<td width="12%"><input type="button" class="btn btn-success" name="delivery<?php echo $i; ?>" id="delivery<?php echo $i; ?>" value="Delivery" onclick="create_del(<?php echo $i; ?>)" /></td>
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
	function create_del(i){
		var invid = document.getElementById("inv_id"+i).value;
		window.location = "create_delivery.php?iid="+invid;
	}
	</script>

</body>

</html>
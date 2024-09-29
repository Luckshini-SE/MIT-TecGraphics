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
					<h1 class="h3 mb-3 col-10">Complete Job</h1>
					<!--<div class="col-2" align="right"><a href="job_plan.php"><button class="btn btn-success">Add</button></a></div>-->
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
									//$select_job = mysqli_query($con, "SELECT * FROM jobcard_details WHERE CAST(qty AS UNSIGNED) >  CAST(completed_qty AS UNSIGNED)");
									$select_job = mysqli_query($con, "SELECT jd.* FROM jobcard_details jd, jobcard j WHERE jd.jobcard_id = j.id AND CAST(jd.qty AS UNSIGNED) >  CAST(jd.completed_qty AS UNSIGNED) AND j.log_user = '{$_SESSION["logUserId"]}'");
									if(mysqli_num_rows($select_job) > 0){
									?>
									
									<table class="table table-bordered" >
										<thead>
										<tr>
											<th>Job No</th>
											<th>Customer</th>
											<th>Product</th>
											<th>Order Qty</th>
											<th>Remaining</th>
											<th width="15%">Complete Qty</th>
											<th width="10%">Select</th>
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

											$select_prod = mysqli_query($con, "SELECT name FROM products WHERE id = '{$result_job['prod_id']}'");
											$result_prod = mysqli_fetch_array($select_prod);

										?>
										<tr>
											<td><?php echo $result_jobno['jobno']; ?><input type="hidden" name="job_id<?php echo $i; ?>" id="job_id<?php echo $i; ?>" value="<?php echo $result_job['id']; ?>" /></td>
											<td><?php echo $customer; ?></td>
											<td><?php echo $result_prod['name']; ?></td>
											<td><?php echo $result_job['qty']; ?></td>
											<td><?php echo $result_job['qty']-$result_job['completed_qty']; ?><input type="hidden" name="rem_qty<?php echo $i; ?>" id="rem_qty<?php echo $i; ?>" value="<?php echo $result_job['qty']-$result_job['completed_qty']; ?>" /></td>
											<td><input type="text" class="form-control" name="com_qty<?php echo $i; ?>" id="com_qty<?php echo $i; ?>" readonly onkeypress="return isNumberKey(event);" onchange="check_qty(<?php echo $i; ?>)" /><span class="error_msg" id="com_error<?php echo $i; ?>" ></span></td>
											<td align="center"><input type="checkbox" name="select<?php echo $i; ?>" id="select<?php echo $i; ?>" onclick="enableQty(<?php echo $i; ?>)" /></td>
										</tr>
										<?php $i++; } ?>
										<input type="hidden" name="num_rows" id="num_rows" value="<?php echo $i-1; ?>" />
										</tbody>
									</table>
									
										<div class="row">
											<div class="col-lg-2 mb-3">
												<input type="submit" class="btn btn-success" name="submit" id="submit" value="Save" />
											</div>
										</div>

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
	function enableQty(i){
		if(document.getElementById("select"+i).checked == true){
			document.getElementById("com_qty"+i).readOnly = false;
		} else {
			document.getElementById("com_qty"+i).readOnly = true;
			document.getElementById("com_qty"+i).value = '0';
		}
	}

	function isNumberKey(evt){

		var charCode = (evt.which) ? evt.which : event.keyCode;
		if (charCode == 8 || (charCode > 47 && charCode < 58)) { // Allow Numbers, Delete & Back Space
			return true;
		} else {
			return false;
		}
	}

	function check_qty(i){
		var com_qty = parseInt(document.getElementById("com_qty"+i).value);
		var rem_qty = parseInt(document.getElementById("rem_qty"+i).value);

		if(com_qty > rem_qty){
			alert('Quantity cannot exceed '+rem_qty);
			document.getElementById("com_qty"+i).value = '0';
		}
	}

	function validateForm() {
		  var prevent = '';
		
		  num_rows = document.getElementById("num_rows").value;

		  for(i=1; i<=num_rows; i++){
		  if(document.getElementById("select"+i).checked == true){
		  let com_qty = document.forms["complete_form"]["com_qty"+i].value;
		  if (com_qty == "" || com_qty == 0) {
			document.getElementById("com_error"+i).innerHTML = "Please fill";
			document.getElementById("com_qty"+i).className  = "form-control error";
			prevent = 'yes';
		  } else {
			document.getElementById("com_error"+i).innerHTML = "";
			document.getElementById("com_qty"+i).className  = "form-control";
		  }
		  } else {
			document.getElementById("com_error"+i).innerHTML = "";
			document.getElementById("com_qty"+i).className  = "form-control";
		  }
		  }

		  if(prevent == 'yes'){
			  return false;
		  }
		}
	</script>

</body>

</html>
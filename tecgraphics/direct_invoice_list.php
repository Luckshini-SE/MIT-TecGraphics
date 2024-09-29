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
					<h1 class="h3 mb-3 col-10">Direct Invoice List</h1>
					<div class="col-2" align="right"><a href="direct_invoice.php"><button class="btn btn-success">Add</button></a></div>
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
									<table id="datatables-reponsive" class="table table-striped" style="width:100%">
										<thead>
										  <tr>
											<th>Invoice No.</th>
											<th>Date</th>
											<th>Customer</th>
											<th>Amount (Rs.)</th>
											<th>Cancel</th>
											<th>&nbsp;</th>
										  </tr>
										</thead>
										<tbody>
										  <?php
										  $select_req = mysqli_query($con, "SELECT * FROM invoice WHERE inv_type = 'direct'");
										  while($result_req = mysqli_fetch_array($select_req)){

										  $select_cust = mysqli_query($con, "SELECT title, name, last_name FROM customer WHERE id = '{$result_req['cus_id']}'");
										  $result_cust = mysqli_fetch_array($select_cust);
											if($result_cust['title']!='6'){
												$select_title = mysqli_query($con, "SELECT title FROM title WHERE id = '{$result_cust['title']}'");
												$result_title = mysqli_fetch_array($select_title);
												$cusname = $result_title['title'].'. '.$result_cust['name'].' '.$result_cust['last_name'];
											} else {
												$cusname = $result_cust['name'].' '.$result_cust['last_name'];
											}

											if($result_req['total'] != $result_req['pay_balance']){
												$disable = 'disabled';
												$tooltip = 'Payment received';
												$link = "javascript: void(0)";
											} else {
												$disable = '';
												$tooltip = 'Cancel invoice';
												$link = "cancel_direct_invoice.php?iid=".$result_req['id'];
											}

										  ?>
										  <tr>
											<td><?php echo $result_req['invoice_no']; ?></td>
											<td><?php echo $result_req['invoice_date']; ?></td>
											<td><?php echo $cusname; ?></td>
											<td align="right"><?php echo number_format($result_req['total'],2); ?></td>
											<?php if($result_req['cancel'] != 'yes'){ ?>
											<td align="center"><a href="<?php echo $link; ?>" title="<?php echo $tooltip; ?>" ><button class="btn btn-sm btn-danger" <?php echo $disable; ?>><i data-feather="x"></i></button></a></td>
											<td align="center"><a href="print_invoice.php?qid=<?php echo $result_req['id']; ?>" target="_blank"><button type="button" class="btn btn-sm btn-primary" ><i data-feather="printer"></i></button></a></td>
											<?php } else { ?>
											<td align="center"><span class="badge bg-danger rounded-pill">Cancelled</span></td>
											<td align="center">&nbsp;</td>
											<?php } ?>
										  </tr>
										  <?php } ?>
										</tbody>
									</table>
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
	<script src="js/datatables.js"></script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Datatables Responsive
			$("#datatables-reponsive").DataTable({
				responsive: true
			});
		});
	</script>
	
</body>

</html>
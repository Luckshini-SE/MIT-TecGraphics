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
					<h1 class="h3 mb-3 col-10">Payment Voucher List</h1>
					<div class="col-2" align="right"><a href="pay_voucher.php"><button class="btn btn-success">Add</button></a></div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<table id="datatables-reponsive" class="table table-striped" style="width:100%">
										<thead>
										  <tr>
											<th>No.</th>
											<th>Date</th>
											<th>Supplier</th>
											<th>Amount (Rs.)</th>
											<th>Method</th>
										  </tr>
										</thead>
										<tbody>
										  <?php
										  $select_pv = mysqli_query($con, "SELECT * FROM payment_voucher");
										  while($result_pv= mysqli_fetch_array($select_pv)){

											$select_sup = mysqli_query($con, "SELECT sname FROM supplier WHERE id = '{$result_pv['supplier']}'");
											$result_sup = mysqli_fetch_array($select_sup);

										  ?>
										  <tr>
											<td><?php echo $result_pv['v_no']; ?></td>
											<td><?php echo $result_pv['v_date']; ?></td>
											<td><?php echo $result_sup['sname']; ?></td>
											<td align="right"><?php echo number_format($result_pv['amount'],2); ?></td>
											<td><?php echo $result_pv['paytype']; ?></td>
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
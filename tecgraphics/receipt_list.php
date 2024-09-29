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
					<h1 class="h3 mb-3 col-10">Receipt List</h1>
					<div class="col-2" align="right"><a href="receipt.php"><button class="btn btn-success">Add</button></a></div>
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
											<th>Customer</th>
											<th>Amount (Rs.)</th>
											<th>Method</th>
										  </tr>
										</thead>
										<tbody>
										  <?php
										  $select_in = mysqli_query($con, "SELECT * FROM receipt");
										  while($result_in= mysqli_fetch_array($select_in)){

											$select_cus = mysqli_query($con, "SELECT name, last_name FROM customer WHERE id = '{$result_in['customer']}'");
											$result_cus = mysqli_fetch_array($select_cus);

										  ?>
										  <tr>
											<td><?php echo $result_in['rec_no']; ?></td>
											<td><?php echo $result_in['rec_date']; ?></td>
											<td><?php echo $result_cus['name'].' '.$result_cus['last_name']; ?></td>
											<td align="right"><?php echo number_format($result_in['amount'],2); ?></td>
											<td><?php echo $result_in['pay_type']; ?></td>
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
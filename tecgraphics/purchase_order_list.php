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
					<h1 class="h3 mb-3 col-10">Purchase Order List</h1>
					<div class="col-2" align="right"><a href="purchase_order.php"><button class="btn btn-success">Add</button></a></div>
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
											<th>Approved</th>
											<th>GRN</th>
											<th>&nbsp;</th>
										  </tr>
										</thead>
										<tbody>
										  <?php
										  $select_po = mysqli_query($con, "SELECT * FROM purchase_order_summary");
										  while($result_po = mysqli_fetch_array($select_po)){

											$select_supp = mysqli_query($con, "SELECT sname FROM supplier WHERE id = '{$result_po['supplier']}'");
											$result_supp = mysqli_fetch_array($select_supp);

											if($result_po['grn'] == 'no'){
												$status = 'Pending';
											} else {
												$status = 'Completed';
											}
										  ?>
										  <tr>
											<td><?php echo $result_po['po_no']; ?></td>
											<td><?php echo $result_po['po_date']; ?></td>
											<td><?php echo $result_supp['sname']; ?></td>
											<td align="right"><?php echo number_format($result_po['total'], 2, '.', ','); ?></td>
											<td><?php echo ucfirst($result_po['approval']); ?></td>
											<td><?php echo $status; ?></td>
											<td align="center"><?php if($result_po['approval'] == 'yes'){ ?><a href="print_po.php?pid=<?php echo $result_po['id']; ?>" target="_blank"><button class="btn btn-sm btn-primary"><i data-feather="printer"></i></button></a><?php } ?></td>
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
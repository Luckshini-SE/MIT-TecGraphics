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
					<h1 class="h3 mb-3 col-10">Goods Received Note List</h1>
					<div class="col-2" align="right"><a href="goods_received.php"><button class="btn btn-success">Add</button></a></div>
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
											<th>&nbsp;</th>
										  </tr>
										</thead>
										<tbody>
										  <?php
										  $select_grn = mysqli_query($con, "SELECT * FROM grn_summary");
										  while($result_grn= mysqli_fetch_array($select_grn)){

											$select_supp = mysqli_query($con, "SELECT sname FROM supplier WHERE id = '{$result_grn['supplier']}'");
											$result_supp = mysqli_fetch_array($select_supp);

										  ?>
										  <tr>
											<td><?php echo $result_grn['grn_no']; ?></td>
											<td><?php echo $result_grn['grn_date']; ?></td>
											<td><?php echo $result_supp['sname']; ?></td>
											<td align="right"><?php echo number_format($result_grn['total'], 2, '.', ','); ?></td>
											<td><?php echo ucfirst($result_grn['approval']); ?></td>
											<td align="center"><?php if($result_grn['approval'] == 'yes'){ ?><a href="print_grn.php?pid=<?php echo $result_grn['id']; ?>" target="_blank"><button class="btn btn-sm btn-primary"><i data-feather="printer"></i></button></a><?php } ?></td>
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
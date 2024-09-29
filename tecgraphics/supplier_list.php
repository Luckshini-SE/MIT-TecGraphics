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
					<h1 class="h3 mb-3 col-10">Supplier List</h1>
					<div class="col-2" align="right"><a href="supplier_register.php"><button class="btn btn-success">Add</button></a></div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<table id="datatables-reponsive" class="table table-striped" style="width:100%">
										<thead>
										  <tr>
											<th>Name</th>
											<th>Contact Person</th>
											<th>Contact</th>
											<th>Email</th>
											<th>Address</th>
											<th>&nbsp;</th>
										  </tr>
										</thead>
										<tbody>
										  <?php
										  $select_supp = mysqli_query($con, "SELECT * FROM supplier");
										  while($result_supp = mysqli_fetch_array($select_supp)){

										  ?>
										  <tr>
											<td><?php echo $result_supp['sname']; ?></td>
											<td><?php echo $result_supp['contactp']; ?></td>
											<td><?php echo $result_supp['contact']; ?></td>
											<td><?php echo $result_supp['email']; ?></td>
											<td><?php echo $result_supp['address']; ?></td>
										 	<td align="center"><a href="supplier_register.php?id=<?php echo $result_supp['id']; ?>" ><button type="button" class="btn btn-sm btn-warning" ><i data-feather="edit"></i></button></a></td>
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